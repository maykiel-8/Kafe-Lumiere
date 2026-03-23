<?php
// app/Http/Controllers/Admin/TransactionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\TransactionStatusUpdated;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['cashier', 'orderItems'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $transactions = $query->paginate(15)->withQueryString();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => ['required', 'in:pending,completed,cancelled'],
        ]);

        $old = $transaction->status;
        $transaction->update([
            'status'       => $request->status,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        // Send email with PDF receipt attached
        if ($transaction->customer_email) {
            try {
                // Reload with all relationships before mailing
                $transaction->loadMissing(['orderItems.addons', 'cashier']);
                Mail::to($transaction->customer_email)
                    ->send(new TransactionStatusUpdated($transaction, $old));
            } catch (\Throwable $mailEx) {
                \Illuminate\Support\Facades\Log::error('Status update mail failed: ' . $mailEx->getMessage());
            }
        }

        return response()->json(['success' => true, 'status' => $transaction->status]);
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load(['orderItems.addons', 'cashier']);
        return view('admin.transactions.receipt', compact('transaction'));
    }

    public function pdf(Transaction $transaction)
    {
        $transaction->load(['orderItems.addons', 'cashier']);
        $pdf = Pdf::loadView('admin.transactions.receipt-pdf', compact('transaction'))
            ->setPaper('a5', 'portrait');
        return $pdf->download('receipt-' . $transaction->order_number . '.pdf');
    }
}