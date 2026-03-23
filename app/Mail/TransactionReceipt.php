<?php
// app/Mail/TransactionReceipt.php
namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionReceipt extends Mailable
{
    // NOTE: Queueable trait removed intentionally — mail sends synchronously
    // so it works without needing 'php artisan queue:work'
    use SerializesModels;

    public function __construct(public Transaction $transaction)
    {
        $this->transaction->loadMissing(['orderItems.addons', 'cashier']);
    }

    public function build(): self
    {
        $mail = $this
            ->subject('Your Kafé Lumière Order Receipt — ' . $this->transaction->order_number)
            ->view('emails.receipt')
            ->with(['transaction' => $this->transaction]);

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
            // PDF failed — email still sends, just without attachment
            \Illuminate\Support\Facades\Log::warning('PDF attachment skipped: ' . $e->getMessage());
        }

        return $mail;
    }
}