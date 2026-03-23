<!DOCTYPE html>


<html lang="en">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 11px;
    color: #1C1008;
    background: #fff;
    padding: 30px 28px;
  }

  /* ── Header ── */
  .header {
    text-align: center;
    padding-bottom: 16px;
    margin-bottom: 16px;
    border-bottom: 3px solid #4A2C17;
  }
  .shop-name {
    font-size: 22px;
    font-weight: bold;
    color: #4A2C17;
    letter-spacing: 2px;
    text-transform: uppercase;
  }
  .shop-tagline {
    font-size: 9px;
    color: #C8874A;
    letter-spacing: 1px;
    margin-top: 2px;
    font-style: italic;
  }
  .shop-address {
    font-size: 9px;
    color: #888;
    margin-top: 4px;
  }

  /* ── Receipt Title ── */
  .receipt-title {
    text-align: center;
    font-size: 13px;
    font-weight: bold;
    color: #4A2C17;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin: 14px 0 6px;
  }

  /* ── Status Badge ── */
  .status-badge {
    text-align: center;
    margin-bottom: 14px;
  }
  .badge {
    display: inline-block;
    padding: 3px 14px;
    border-radius: 12px;
    font-size: 9px;
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
  }
  .badge-completed { background: #e8f5e0; color: #3d5c35; border: 1px solid #b8d8a8; }
  .badge-pending   { background: #fef3d0; color: #7a5a10; border: 1px solid #f0d888; }
  .badge-cancelled { background: #fde8e8; color: #8b1a1a; border: 1px solid #f0b8b8; }

  /* ── Info Table ── */
  .info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 14px;
    background: #FAF7F2;
    border: 1px solid #E8D5C4;
    border-radius: 6px;
  }
  .info-table td {
    padding: 6px 12px;
    font-size: 10.5px;
    border-bottom: 1px solid #F0E4D4;
  }
  .info-table td:first-child {
    color: #888;
    width: 38%;
    font-weight: normal;
  }
  .info-table td:last-child {
    color: #1C1008;
    font-weight: bold;
    text-align: right;
  }
  .info-table tr:last-child td { border-bottom: none; }

  /* ── Section Header ── */
  .section-header {
    background: #4A2C17;
    color: #fff;
    font-size: 9px;
    font-weight: bold;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 5px 12px;
    margin-bottom: 0;
  }

  /* ── Items Table ── */
  .items-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #E8D5C4;
    border-top: none;
    margin-bottom: 14px;
  }
  .items-table th {
    background: #F5EFE6;
    color: #4A2C17;
    font-size: 9px;
    font-weight: bold;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    padding: 6px 10px;
    border-bottom: 1px solid #E8D5C4;
    text-align: left;
  }
  .items-table th:last-child { text-align: right; }
  .items-table td {
    padding: 8px 10px;
    font-size: 10.5px;
    border-bottom: 1px solid #F5EFE6;
    vertical-align: top;
  }
  .items-table td:last-child { text-align: right; font-weight: bold; }
  .items-table tr:last-child td { border-bottom: none; }
  .item-addon { font-size: 9px; color: #C8874A; margin-top: 2px; }
  .item-meta  { font-size: 9px; color: #888; margin-top: 1px; }

  /* ── Totals ── */
  .totals-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 14px;
  }
  .totals-table td {
    padding: 4px 10px;
    font-size: 10.5px;
  }
  .totals-table td:first-child { color: #777; }
  .totals-table td:last-child  { text-align: right; color: #1C1008; }
  .totals-table .grand td {
    border-top: 2px solid #4A2C17;
    padding-top: 8px;
    font-size: 13px;
    font-weight: bold;
    color: #4A2C17;
  }

  /* ── Footer ── */
  .footer {
    text-align: center;
    margin-top: 20px;
    padding-top: 12px;
    border-top: 1px dashed #C8874A;
    font-size: 9px;
    color: #aaa;
    line-height: 1.6;
  }
  .footer .tagline {
    font-size: 11px;
    font-weight: bold;
    color: #4A2C17;
    font-style: italic;
    margin-bottom: 3px;
  }
</style>
</head>
<body>


<div class="header">
  <div class="shop-name">Kafé Lumière</div>
  <div class="shop-tagline">Milk Tea &amp; Coffee Shop</div>
  <div class="shop-address">
    123 Brew Street, Manila, Philippines<br>
    Tel: (02) 8888-1234 &nbsp;·&nbsp; Email: kafelumiere@email.com
  </div>
</div>

<div class="receipt-title">Official Receipt</div>

<div class="status-badge">
  <span class="badge badge-<?php echo e($transaction->status); ?>">
    <?php echo e(strtoupper($transaction->status)); ?>

  </span>
</div>


<div class="section-header">Order Information</div>
<table class="info-table">
  <tr>
    <td>Order Number</td>
    <td><?php echo e($transaction->order_number); ?></td>
  </tr>
  <tr>
    <td>Date &amp; Time</td>
    <td><?php echo e($transaction->created_at->timezone('Asia/Manila')->format('F d, Y h:i A')); ?></td>
  </tr>
  <tr>
    <td>Cashier</td>
    <td><?php echo e(($transaction->cashier && $transaction->cashier->role === 'customer') ? 'Kafé Lumière' : ($transaction->cashier->full_name ?? 'Kafé Lumière')); ?></td>
  </tr>
  <tr>
    <td>Customer</td>
    <td><?php echo e($transaction->customer_name); ?></td>
  </tr>
  <?php if($transaction->customer_email): ?>
  <tr>
    <td>Email</td>
    <td><?php echo e($transaction->customer_email); ?></td>
  </tr>
  <?php endif; ?>
  <tr>
    <td>Payment Method</td>
    <td><?php echo e(strtoupper($transaction->payment_method)); ?></td>
  </tr>
</table>


<div class="section-header">Items Ordered</div>
<table class="items-table">
  <thead>
    <tr>
      <th style="width:50%;">Product</th>
      <th style="width:20%;">Size</th>
      <th style="width:10%;">Qty</th>
      <th style="width:20%;">Amount</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $transaction->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
      <td>
        <strong><?php echo e($item->product_name); ?></strong>
        <?php if($item->addons->count()): ?>
          <div class="item-addon">
            + <?php echo e($item->addons->pluck('addon_name')->join(', ')); ?>

          </div>
        <?php endif; ?>
      </td>
      <td class="item-meta"><?php echo e($item->size); ?></td>
      <td><?php echo e($item->quantity); ?></td>
      <td>
        &#8369;<?php echo e(number_format($item->subtotal, 2)); ?>

        <div class="item-meta">&#8369;<?php echo e(number_format($item->unit_price, 2)); ?> each</div>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>


<table class="totals-table">
  <tr>
    <td>Subtotal</td>
    <td>&#8369;<?php echo e(number_format($transaction->subtotal, 2)); ?></td>
  </tr>
  <tr>
    <td>VAT (12%)</td>
    <td>&#8369;<?php echo e(number_format($transaction->tax, 2)); ?></td>
  </tr>
  <?php if($transaction->amount_tendered): ?>
  <tr>
    <td>Amount Tendered</td>
    <td>&#8369;<?php echo e(number_format($transaction->amount_tendered, 2)); ?></td>
  </tr>
  <tr>
    <td>Change</td>
    <td>&#8369;<?php echo e(number_format($transaction->change, 2)); ?></td>
  </tr>
  <?php endif; ?>
  <tr class="grand">
    <td>TOTAL DUE</td>
    <td>&#8369;<?php echo e(number_format($transaction->total, 2)); ?></td>
  </tr>
</table>


<div class="footer">
  <div class="tagline">Thank you for choosing Kafé Lumière!</div>
  This is an official receipt. Please keep this for your records.<br>
  For concerns, contact us at kafelumiere@email.com or (02) 8888-1234<br>
  <br>
  <em>"Every cup tells a story."</em>
</div>

</body>
</html><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/transactions/receipt-pdf.blade.php ENDPATH**/ ?>