<?php
// app/Http/Controllers/Cashier/OrderController.php
namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\TransactionReceipt;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('cashier.orders', compact('categories'));
    }

    public function getProducts(Request $request)
    {
        $products = Product::with(['category', 'addons', 'photos'])
            ->where('is_available', true)
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->search, fn($q) => $q->where('name', 'LIKE', '%' . $request->search . '%'))
            ->get(['id', 'name', 'category_id', 'price_tall', 'price_grande', 'main_photo'])
            ->map(fn($p) => [
                'id'          => $p->id,
                'name'        => $p->name,
                'category_id' => $p->category_id,
                'price_tall'  => $p->price_tall,
                'price_grande'=> $p->price_grande,
                // Return the full public URL so JS can use it directly in <img src>
                'photo_url'   => $p->main_photo
                    ? asset('storage/' . $p->main_photo)
                    : ($p->photos->first() ? asset('storage/' . $p->photos->first()->path) : null),
                // Return addons as a simple array of {id, name, price}
                'addons'      => $p->addons->map(fn($a) => [
                    'id'    => $a->id,
                    'name'  => $a->name,
                    'price' => $a->price,
                ])->values(),
            ]);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'      => ['nullable', 'string', 'max:255'],
            'customer_email'     => ['nullable', 'email'],
            'payment_method'     => ['required', 'in:cash,gcash,maya,card'],
            'amount_tendered'    => ['nullable', 'numeric', 'min:0'],
            'items'              => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.size'       => ['required'],
            'items.*.quantity'   => ['required', 'integer', 'min:1'],
            'items.*.addons'     => ['nullable', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $subtotal  = 0;
            $lineItems = [];

            foreach ($request->items as $item) {
                $product   = Product::findOrFail($item['product_id']);
                $price     = $item['size'] === 'Grande (22oz)'
                    ? ($product->price_grande ?? $product->price_tall)
                    : $product->price_tall;
                $line      = $price * $item['quantity'];
                $subtotal += $line;

                $lineItems[] = [
                    'product'  => $product,
                    'size'     => $item['size'],
                    'price'    => $price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $line,
                    'addons'   => $item['addons'] ?? [],
                ];
            }

            $tax   = round($subtotal * 0.12, 2);
            $total = $subtotal + $tax;

            // FIX: Look up the customer account by email so the transaction
            // is linked to their account — this is what makes their order
            // history and review eligibility work on the customer dashboard.
            $customerUserId = null;
            if ($request->customer_email) {
                $customer = User::where('email', $request->customer_email)
                    ->where('role', 'customer')
                    ->first();
                $customerUserId = $customer?->id;
            }

            $transaction = Transaction::create([
                'order_number'    => Transaction::generateOrderNumber(),
                'cashier_id'      => auth()->id(),
                'customer_user_id'=> $customerUserId,   // FIX: link to customer account
                'customer_name'   => $request->customer_name ?? 'Walk-in',
                'customer_email'  => $request->customer_email,
                'payment_method'  => $request->payment_method,
                'subtotal'        => $subtotal,
                'tax'             => $tax,
                'total'           => $total,
                'amount_tendered' => $request->amount_tendered,
                'change'          => max(0, ($request->amount_tendered ?? 0) - $total),
                'status'          => 'pending',
                'completed_at'    => null,
            ]);

            foreach ($lineItems as $line) {
                $orderItem = $transaction->orderItems()->create([
                    'product_id'   => $line['product']->id,
                    'product_name' => $line['product']->name,
                    'size'         => $line['size'],
                    'unit_price'   => $line['price'],
                    'quantity'     => $line['quantity'],
                    'subtotal'     => $line['subtotal'],
                ]);

                foreach ($line['addons'] as $addonName) {
                    $orderItem->addons()->create([
                        'addon_name'  => $addonName,
                        'addon_price' => 0,
                    ]);
                }
            }

            DB::commit();

            // Reload fully with all relationships needed for email and PDF
            $transaction->load(['orderItems.addons', 'cashier']);

            // Send receipt email immediately on order placement
            // (per requirement: email sent after transaction is placed)
            $mailSent = false;
            $mailError = null;
            if ($transaction->customer_email) {
                try {
                    Mail::to($transaction->customer_email)
                        ->send(new TransactionReceipt($transaction));
                    $mailSent = true;
                } catch (\Throwable $mailEx) {
                    $mailError = $mailEx->getMessage();
                    \Illuminate\Support\Facades\Log::error('Receipt mail failed: ' . $mailError . ' | ' . $mailEx->getFile() . ':' . $mailEx->getLine());
                }
            }

            return response()->json([
                'success'     => true,
                'transaction' => $transaction,
                'receipt_url' => route('admin.transactions.pdf', $transaction),
                'mail_sent'   => $mailSent,
                'mail_error'  => $mailError,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}