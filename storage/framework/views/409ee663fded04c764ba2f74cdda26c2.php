<?php $__env->startSection('title', 'Front Desk Reservations'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Front Desk Reservations</h3>
        <p class="text-secondary small mb-0">Manage guest bookings, room key assignments, check-ins, and check-outs.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="<?php echo e(route('admin.reservations.create')); ?>" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> New Walk-In Booking
        </a>
    </div>
</div>

<!-- Filters & Search Bar -->
<div class="card border rounded-4 shadow-sm mb-4 bg-white p-3">
    <form action="<?php echo e(route('admin.reservations.index')); ?>" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by reference, guest name, email..." value="<?php echo e(request('search')); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmed (Upcoming)</option>
                <option value="checked_in" <?php echo e(request('status') == 'checked_in' ? 'selected' : ''); ?>>Checked In (In-House)</option>
                <option value="checked_out" <?php echo e(request('status') == 'checked_out' ? 'selected' : ''); ?>>Checked Out (Departed)</option>
                <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="<?php echo e(request('date')); ?>" title="Filter by active date">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100 fw-semibold">Filter</button>
            <a href="<?php echo e(route('admin.reservations.index')); ?>" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>
</div>

<!-- Reservations Table -->
<div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th>Booking Ref</th>
                        <th>Guest Details</th>
                        <th>Suite & Room</th>
                        <th>Stay Dates</th>
                        <th>Folio Balance</th>
                        <th>Booking Status</th>
                        <th>Payment</th>
                        <th class="text-end">Front Desk Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('admin.reservations.show', $r->id)); ?>" class="fw-bold font-monospace text-dark text-decoration-none">
                                    <?php echo e($r->booking_reference); ?>

                                </a>
                                <?php if($r->assigned_key_card): ?>
                                    <small class="d-block text-muted font-monospace"><?php echo e($r->assigned_key_card); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?php echo e($r->guest->full_name); ?></div>
                                <small class="text-muted"><?php echo e($r->guest->phone); ?> &bull; <?php echo e($r->guest->email); ?></small>
                                <?php if($r->guest->vip_status): ?>
                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">VIP</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-semibold"><?php echo e($r->roomType->name); ?></div>
                                <?php if($r->room): ?>
                                    <span class="badge bg-dark text-warning">Room <?php echo e($r->room->room_number); ?> (Floor <?php echo e($r->room->floor); ?>)</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary">Unassigned</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo e($r->check_in_date->format('M d')); ?> &rarr; <?php echo e($r->check_out_date->format('M d, Y')); ?>

                                <small class="d-block text-muted"><?php echo e($r->nights); ?> Night<?php echo e($r->nights > 1 ? 's' : ''); ?> &bull; <?php echo e($r->adults); ?> Adults</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">$<?php echo e(number_format($r->total_amount, 2)); ?></div>
                                <?php if($r->balance_due > 0): ?>
                                    <span class="badge bg-danger-subtle text-danger">Due: $<?php echo e(number_format($r->balance_due, 2)); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-success-subtle text-success">Settled</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo e($r->status_badge); ?> text-uppercase">
                                    <?php echo e(str_replace('_', ' ', $r->booking_status)); ?>

                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo e($r->payment_status === 'paid' ? 'success' : 'warning'); ?> text-uppercase">
                                    <?php echo e($r->payment_status); ?>

                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <?php if($r->booking_status === 'confirmed'): ?>
                                        <form action="<?php echo e(route('admin.reservations.check-in', $r->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success" title="Check-In Guest">
                                                <i class="bi bi-box-arrow-in-right"></i> Check In
                                            </button>
                                        </form>
                                    <?php elseif($r->booking_status === 'checked_in'): ?>
                                        <form action="<?php echo e(route('admin.reservations.check-out', $r->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger" title="Check-Out Guest">
                                                <i class="bi bi-box-arrow-right"></i> Check Out
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('admin.reservations.show', $r->id)); ?>" class="btn btn-outline-dark" title="View Folio">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('booking.receipt', $r->booking_reference)); ?>" target="_blank" class="btn btn-outline-secondary" title="Print Receipt">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                No reservations match the current query.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($reservations->hasPages()): ?>
        <div class="card-footer bg-white border-top p-3">
            <?php echo e($reservations->links()); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/reservations/index.blade.php ENDPATH**/ ?>