<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Receipt — Kafé Lumière</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: Arial, Helvetica, sans-serif; background: #F5EFE6; padding: 30px 20px; color: #1C1008; }
  .container { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #E8D5C4; }

  /* Header */
  .header { background: #4A2C17; padding: 28px 32px; text-align: center; }
  .header-icon { font-size: 28px; margin-bottom: 6px; }
  .header h1 { font-family: Georgia, serif; font-style: italic; color: #D4A853; font-size: 24px; margin: 0; letter-spacing: 1px; }
  .header .tagline { color: rgba(255,255,255,0.55); font-size: 11px; margin-top: 4px; letter-spacing: 0.5px; }
  .header .address { color: rgba(255,255,255,0.4); font-size: 10px; margin-top: 5px; }

  /* Receipt label */
  .receipt-label { background: #C8874A; color: #fff; text-align: center; padding: 8px; font-size: 11px; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; }

  /* Greeting */
  .greeting { padding: 20px 28px 14px; font-size: 14px; color: #333; border-bottom: 1px solid #F0E4D4; }
  .greeting strong { color: #4A2C17; }

  /* Info block */
  .info-block { padding: 14px 28px; background: #FAF7F2; border-bottom: 1px solid #F0E4D4; }
  .info-row { display: table; width: 100%; padding: 4px 0; font-size: 12px; }
  .info-label { display: table-cell; color: #888; width: 40%; }
  .info-value { display: table-cell; color: #1C1008; font-weight: bold; text-align: right; }

  /* Section title */
  .section-title { background: #4A2C17; color: #fff; font-size: 10px; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase; padding: 6px 28px; }

  /* Items */
  .items { padding: 0 28px; }
  .item-row { padding: 10px 0; border-bottom: 1px solid #F5EFE6; display: table; width: 100%; }
  .item-left { display: table-cell; width: 70%; vertical-align: top; }
  .item-right { display: table-cell; width: 30%; text-align: right; vertical-align: top; }
  .item-name { font-size: 13px; font-weight: bold; color: #1C1008; }
  .item-meta { font-size: 10px; color: #888; margin-top: 2px; }
  .item-addon { font-size: 10px; color: #C8874A; margin-top: 2px; }
  .item-price { font-size: 13px; font-weight: bold; color: #4A2C17; }
  .item-unit { font-size: 10px; color: #aaa; }

  /* Totals */
  .totals { padding: 10px 28px; background: #FAF7F2; border-top: 1px solid #E8D5C4; }
  .total-row { display: table; width: 100%; padding: 3px 0; font-size: 12px; }
  .total-label { display: table-cell; color: #777; }
  .total-val   { display: table-cell; text-align: right; color: #1C1008; }
  .grand-total { background: #4A2C17; padding: 12px 28px; display: table; width: 100%; }
  .grand-label { display: table-cell; color: #D4A853; font-size: 14px; font-weight: bold; font-family: Georgia, serif; }
  .grand-val   { display: table-cell; text-align: right; color: #fff; font-size: 16px; font-weight: bold; font-family: Georgia, serif; }

  /* Footer */
  .footer { padding: 18px 28px; text-align: center; background: #F5EFE6; }
  .footer-brand { font-family: Georgia, serif; font-style: italic; font-size: 14px; color: #4A2C17; margin-bottom: 4px; }
  .footer-text { font-size: 10px; color: #888; line-height: 1.6; }
  .footer-note { margin-top: 10px; font-size: 10px; color: #aaa; font-style: italic; }
</style>
</head>
<body>
<div class="container">

  
  <div class="header">
    <div class="header-icon">☕</div>
    <h1>Kafé Lumière</h1>
    <div class="tagline">Milk Tea &amp; Coffee Shop</div>
    <div class="address">123 Brew Street, Manila, Philippines &nbsp;·&nbsp; (02) 8888-1234</div>
  </div>

  <div class="receipt-label">Official Order Receipt</div>

  
  <div class="greeting">
    Dear <strong><?php echo e($transaction->customer_name); ?></strong>,<br>
    <span style="font-size:12px;color:#666;margin-top:4px;display:block;">
      Thank you for your order! Your receipt is below. A PDF copy is also attached to this email.
    </span>
  </div>

  
  <div class="section-title">Order Details</div>
  <div class="info-block">
    <div class="info-row">
      <span class="info-label">Order Number</span>
      <span class="info-value"><?php echo e($transaction->order_number); ?></span>
    </div>
    <div class="info-row">
      <span class="info-label">Date &amp; Time</span>
      <span class="info-value"><?php echo e($transaction->created_at->timezone('Asia/Manila')->format('M d, Y h:i A')); ?></span>
    </div>
    <div class="info-row">
      <span class="info-label">Payment</span>
      <span class="info-value"><?php echo e(strtoupper($transaction->payment_method)); ?></span>
    </div>
    <div class="info-row">
      <span class="info-label">Cashier</span>
      <span class="info-value"><?php echo e(($transaction->cashier && $transaction->cashier->role === 'customer') ? 'Kafé Lumière' : ($transaction->cashier->full_name ?? 'Kafé Lumière')); ?></span>
    </div>
    <?php if($transaction->customer_email): ?>
    <div class="info-row">
      <span class="info-label">Email</span>
      <span class="info-value"><?php echo e($transaction->customer_email); ?></span>
    </div>
    <?php endif; ?>
  </div>

  
  <div class="section-title">Items Ordered</div>
  <div class="items">
    <?php $__currentLoopData = $transaction->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="item-row">
      <div class="item-left">
        <div class="item-name"><?php echo e($item->product_name); ?></div>
        <div class="item-meta"><?php echo e($item->size); ?> &nbsp;·&nbsp; Qty: <?php echo e($item->quantity); ?></div>
        <?php if($item->addons->count()): ?>
          <div class="item-addon">+ <?php echo e($item->addons->pluck('addon_name')->join(', ')); ?></div>
        <?php endif; ?>
      </div>
      <div class="item-right">
        <div class="item-price">&#8369;<?php echo e(number_format($item->subtotal, 2)); ?></div>
        <div class="item-unit">&#8369;<?php echo e(number_format($item->unit_price, 2)); ?> each</div>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  
  <div class="totals">
    <div class="total-row">
      <span class="total-label">Subtotal</span>
      <span class="total-val">&#8369;<?php echo e(number_format($transaction->subtotal, 2)); ?></span>
    </div>
    <div class="total-row">
      <span class="total-label">VAT (12%)</span>
      <span class="total-val">&#8369;<?php echo e(number_format($transaction->tax, 2)); ?></span>
    </div>
    <?php if($transaction->amount_tendered): ?>
    <div class="total-row">
      <span class="total-label">Amount Tendered</span>
      <span class="total-val">&#8369;<?php echo e(number_format($transaction->amount_tendered, 2)); ?></span>
    </div>
    <div class="total-row">
      <span class="total-label">Change</span>
      <span class="total-val">&#8369;<?php echo e(number_format($transaction->change, 2)); ?></span>
    </div>
    <?php endif; ?>
  </div>

  <div class="grand-total">
    <span class="grand-label">TOTAL DUE</span>
    <span class="grand-val">&#8369;<?php echo e(number_format($transaction->total, 2)); ?></span>
  </div>

  
  <div class="footer">
    <div class="footer-brand">Kafé Lumière</div>
    <div class="footer-text">
      This is your official receipt. Please keep this for your records.<br>
      For concerns: <strong>kafelumiere@email.com</strong> &nbsp;|&nbsp; (02) 8888-1234
    </div>
    <div class="footer-note">"Every cup tells a story."</div>
  </div>

</div>
</body>
</html><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/emails/receipt.blade.php ENDPATH**/ ?>