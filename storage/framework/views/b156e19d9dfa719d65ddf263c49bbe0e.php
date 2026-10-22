<?php $__env->startSection('title', 'Financial Ledger & Payments'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Financial Ledger & Transactions</h3>
        <p class="text-secondary small mb-0">Audit online checkout transactions, receipts, and payment method reconciliations.</p>
    </div>
</div>

<!-- Financial Summary KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Total Revenue</span>
            <h2 class="fw-bold text-success mb-1">$<?php echo e(number_format($totalRevenue, 2)); ?></h2>
            <small class="text-muted">Verified successful payments</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Card Gateway</span>
            <h2 class="fw-bold text-dark mb-1">$<?php echo e(number_format($cardRevenue, 2)); ?></h2>
            <small class="text-muted">Visa / Mastercard / Amex</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">UPI & NetBanking</span>
            <h2 class="fw-bold text-dark mb-1">$<?php echo e(number_format($upiRevenue, 2)); ?></h2>
            <small class="text-muted">Instant QR & VPA transfers</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Counter / Cash</span>
            <h2 class="fw-bold text-dark mb-1">$<?php echo e(number_format($cashRevenue, 2)); ?></h2>
            <small class="text-muted">Physical front desk terminal</small>
        </div>
    </div>
</div>

<!-- Search & Filters -->
<div class="card border rounded-4 shadow-sm mb-4 bg-white p-3">
    <form action="<?php echo e(route('admin.payments.index')); ?>" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by Transaction ID, Receipt #, Guest name, Ref..." value="<?php echo e(request('search')); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <select name="method" class="form-select">
                <option value="">All Payment Methods</option>
                <option value="card" <?php echo e(request('method') == 'card' ? 'selected' : ''); ?>>Credit / Debit Card</option>
                <option value="upi" <?php echo e(request('method') == 'upi' ? 'selected' : ''); ?>>UPI / QR Code</option>
                <option value="cash" <?php echo e(request('method') == 'cash' ? 'selected' : ''); ?>>Counter / Cash</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="successful" <?php echo e(request('status') == 'successful' ? 'selected' : ''); ?>>Successful</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="refunded" <?php echo e(request('status') == 'refunded' ? 'selected' : ''); ?>>Refunded</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100 fw-semibold">Filter</button>
            <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>
</div>

<!-- Payments Table -->
<div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Receipt Number</th>
                        <th>Guest & Reference</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th class="text-end">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <span class="fw-bold font-monospace text-dark"><?php echo e($p->transaction_id); ?></span>
                                <?php if($p->gateway_reference): ?>
                                    <small class="d-block text-muted font-monospace" style="font-size: 0.7rem;"><?php echo e($p->gateway_reference); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace"><?php echo e($p->receipt_number); ?></span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?php echo e($p->reservation->guest->full_name ?? 'Guest'); ?></div>
                                <?php if($p->reservation): ?>
                                    <a href="<?php echo e(route('admin.reservations.show', $p->reservation->id)); ?>" class="text-muted text-decoration-none font-monospace">
                                        <?php echo e($p->reservation->booking_reference); ?>

                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-dark-subtle text-dark border"><?php echo e(ucfirst($p->payment_method)); ?></span>
                                <?php if($p->card_last_four): ?>
                                    <small class="text-muted">(&bull;&bull;&bull;&bull; <?php echo e($p->card_last_four); ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-bold text-success fs-6">$<?php echo e(number_format($p->amount, 2)); ?></span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo e($p->payment_status === 'successful' ? 'success' : 'warning'); ?> text-uppercase">
                                    <?php echo e($p->payment_status); ?>

                                </span>
                            </td>
                            <td>
                                <?php echo e($p->paid_at ? $p->paid_at->format('M d, Y') : 'N/A'); ?>

                                <small class="text-muted d-block"><?php echo e($p->paid_at ? $p->paid_at->format('h:i A') : ''); ?></small>
                            </td>
                            <td class="text-end">
                                <?php if($p->reservation): ?>
                                    <a href="<?php echo e(route('booking.receipt', $p->reservation->booking_reference)); ?>" target="_blank" class="btn btn-sm btn-outline-dark" title="Print Official Receipt">
                                        <i class="bi bi-printer-fill me-1"></i> Receipt
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No financial transaction records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($payments->hasPages()): ?>
        <div class="card-footer bg-white border-top p-3">
            <?php echo e($payments->links()); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>