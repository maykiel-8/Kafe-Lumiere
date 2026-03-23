<!DOCTYPE html>
{{-- resources/views/emails/status-updated.blade.php --}}
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:Arial,sans-serif;background:#FAF7F2;padding:20px;color:#1C1008;}
  .wrap{max-width:520px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #E8D5C4;}
  .header{background:#4A2C17;padding:24px 28px;text-align:center;}
  .header h1{font-family:Georgia,serif;font-style:italic;color:#D4A853;font-size:22px;margin:0;}
  .body{padding:24px 28px;}
  .badge{display:inline-block;padding:4px 14px;border-radius:20px;font-size:12px;font-weight:bold;}
  .badge-completed{background:#e8f5e0;color:#3d5c35;}
  .badge-cancelled{background:#fde8e8;color:#8b1a1a;}
  .badge-pending{background:#fef3d0;color:#7a5a10;}
  .info-box{background:#F5EFE6;border-radius:8px;padding:14px 18px;margin:14px 0;}
  .info-row{display:flex;justify-content:space-between;font-size:13px;padding:3px 0;color:#666;}
  .info-row strong{color:#1C1008;}
  .footer{background:#F5EFE6;padding:14px 28px;text-align:center;font-size:11px;color:#888;}
  .footer strong{font-family:Georgia,serif;font-style:italic;color:#4A2C17;font-size:14px;display:block;margin-bottom:3px;}
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <h1>☕ Kafé Lumière</h1>
  </div>
  <div class="body">
    <p style="font-size:14px;margin-bottom:12px;">Hi <strong>{{ $transaction->customer_name }}</strong>,</p>
    <p style="font-size:13px;color:#555;margin-bottom:10px;">
      Your order <strong>{{ $transaction->order_number }}</strong> status has been updated.
    </p>

    <div>
      <span style="font-size:12px;color:#888;">Previous:</span>
      <span class="badge badge-{{ $oldStatus }}">{{ ucfirst($oldStatus) }}</span>
      <span style="color:#888;margin:0 6px;">→</span>
      <span class="badge badge-{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span>
    </div>

    <div class="info-box">
      <div class="info-row"><span>Order Number</span><strong>{{ $transaction->order_number }}</strong></div>
      <div class="info-row"><span>Total</span><strong>₱{{ number_format($transaction->total,2) }}</strong></div>
      <div class="info-row"><span>Payment</span><strong style="text-transform:uppercase;">{{ $transaction->payment_method }}</strong></div>
      <div class="info-row"><span>Updated</span><strong>{{ $transaction->updated_at->timezone('Asia/Manila')->format('M d, Y h:i A') }}</strong></div>
    </div>

    @if($transaction->status === 'completed')
      <p style="font-size:13px;color:#555;">Your receipt (PDF) is attached. Thank you for your purchase!</p>
    @elseif($transaction->status === 'cancelled')
      <p style="font-size:13px;color:#555;">
        We're sorry your order was cancelled. Contact us at
        <a href="mailto:kafelumiere@email.com" style="color:#C8874A;">kafelumiere@email.com</a> for assistance.
      </p>
    @endif
  </div>
  <div class="footer">
    <strong>Kafé Lumière</strong>
    123 Brew Street, Manila · (02) 8888-1234
  </div>
</div>
</body>
</html>