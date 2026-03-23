<?php
// app/Http/Controllers/Customer/CustomerController.php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Orders linked by account ID OR by email (catches walk-in orders
        // placed by cashier before the customer had an account)
        $orders = Transaction::where(function ($q) use ($user) {
                $q->where('customer_user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->with(['orderItems'])
            ->latest()
            ->paginate(10);

        // All completed orders — used to determine what they can review
        $completedOrders = Transaction::where(function ($q) use ($user) {
                $q->where('customer_user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->where('status', 'completed')
            ->with(['orderItems.product'])
            ->get();

        // Flat list of purchased products with their transaction context
        $purchasedItems = $completedOrders
            ->flatMap(fn($t) => $t->orderItems->map(fn($item) => [
                'transaction_id' => $t->id,
                'product_id'     => $item->product_id,
                'product_name'   => $item->product_name,
                'order_number'   => $t->order_number,
                'date'           => $t->created_at->format('M d, Y'),
            ]))
            ->unique('product_id');

        // Reviews this customer has already written
        $myReviews = Review::where('user_id', $user->id)
            ->with(['product' => fn($q) => $q->withTrashed()])
            ->latest()
            ->get();

        // Track which product+transaction combos are already reviewed
        $reviewed = Review::where('user_id', $user->id)
            ->get(['product_id', 'transaction_id'])
            ->map(fn($r) => $r->product_id . '-' . $r->transaction_id)
            ->toArray();

        // Products they haven't reviewed yet
        $pendingReviews = $purchasedItems->reject(
            fn($i) => in_array($i['product_id'] . '-' . $i['transaction_id'], $reviewed)
        );

        // All products for the mini shop on the dashboard
        $categories = Category::all();
        // Load ALL available products (no limit) so customer can browse full menu
        $allProducts = Product::with(['category', 'photos', 'addons'])
            ->where('is_available', true)
            ->latest()
            ->get();

        // Max price for slider — rounded up to nearest 50
        $maxProductPrice = $allProducts->max('price_tall') ?? 500;
        $maxProductPrice = (int)(ceil($maxProductPrice / 50) * 50);

        return view('customer.dashboard', compact(
            'orders',
            'purchasedItems',
            'pendingReviews',
            'myReviews',
            'reviewed',
            'categories',
            'allProducts',
            'maxProductPrice'
        ));
    }
}