<?php
// app/Mail/TransactionStatusUpdated.php
namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionStatusUpdated extends Mailable
{
    // NOTE: Queueable trait removed intentionally — sends synchronously
    use SerializesModels;

    public function __construct(
        public Transaction $transaction,
        public string $oldStatus
    ) {
        $this->transaction->loadMissing(['orderItems.addons', 'cashier']);
    }

    public function build(): self
    {
        $mail = $this
            ->subject('Order ' . $this->transaction->order_number . ' — Status Updated to ' . ucfirst($this->transaction->status))
            ->view('emails.status-updated')
            ->with([
                'transaction' => $this->transaction,
                'oldStatus'   => $this->oldStatus,
            ]);

        // Attach PDF receipt
        try {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'admin.transactions.receipt-pdf',
                ['transaction' => $this->transaction]
            )->setPaper('a5', 'portrait');

            $mail->attachData(
                $pdf->output(),
                'receipt-' . $this->transaction->order_number . '.pdf',
                ['mime' => 'application/pdf']
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('PDF attachment skipped: ' . $e->getMessage());
        }

        return $mail;
    }
}