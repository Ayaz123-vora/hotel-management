<?php $__env->startSection('title', 'Guest Profile: ' . $guest->full_name); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?php echo e(route('admin.guests.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Guests</a>
    <div>
        <h3 class="fw-bold mb-0">Guest Profile</h3>
        <p class="text-secondary small mb-0">Comprehensive stay history and lifetime spend folio.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Guest Info Summary Card -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white p-4 text-center">
            <div class="bg-dark text-warning p-3 rounded-circle fw-bold fs-3 mx-auto mb-3" style="width: 72px; height: 72px; line-height: 48px;">
                <?php echo e(substr($guest->first_name, 0, 1)); ?><?php echo e(substr($guest->last_name, 0, 1)); ?>

            </div>
            <h4 class="font-serif fw-bold text-dark mb-1"><?php echo e($guest->full_name); ?></h4>
            <div class="mb-3">
                <?php if($guest->vip_status): ?>
                    <span class="badge bg-warning text-dark px-3 py-1 fs-6">VIP Guest</span>
                <?php else: ?>
                    <span class="badge bg-secondary-subtle text-secondary px-3 py-1">Standard Guest</span>
                <?php endif; ?>
            </div>

            <div class="p-3 bg-light rounded-3 text-start small mb-4 border">
                <div class="mb-2"><strong>Email:</strong> <?php echo e($guest->email); ?></div>
                <div class="mb-2"><strong>Phone:</strong> <?php echo e($guest->phone); ?></div>
                <div class="mb-2"><strong>ID:</strong> <?php echo e($guest->id_type); ?> (<?php echo e($guest->id_number ?? 'N/A'); ?>)</div>
                <div><strong>Address:</strong> <?php echo e($guest->address ?? 'N/A'); ?>, <?php echo e($guest->city ?? ''); ?> <?php echo e($guest->country ?? ''); ?></div>
            </div>

            <!-- Stats -->
            <div class="row g-2 mb-4">
                <div class="col-6">
                    <div class="p-3 border rounded-3 bg-white">
                        <h4 class="fw-bold text-dark mb-0"><?php echo e($guest->reservations->count()); ?></h4>
                        <small class="text-muted">Total Stays</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 border rounded-3 bg-white">
                        <h4 class="fw-bold text-success mb-0">$<?php echo e(number_format($totalSpend, 0)); ?></h4>
                        <small class="text-muted">Lifetime Spend</small>
                    </div>
                </div>
            </div>

            <form action="<?php echo e(route('admin.guests.toggle-vip', $guest->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-outline-dark btn-sm w-100">
                    <i class="bi bi-star me-1"></i> Toggle VIP Recognition
                </button>
            </form>
        </div>
    </div>

    <!-- Stay History Column -->
    <div class="col-lg-8">
        <div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history text-warning me-2"></i> Complete Stay & Folio History</h6>
                <span class="badge bg-dark"><?php echo e($guest->reservations->count()); ?> Records</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Booking Ref</th>
                                <th>Suite / Room</th>
                                <th>Dates</th>
                                <th>Status</th>
                                <th>Total Billed</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $guest->reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('admin.reservations.show', $res->id)); ?>" class="fw-bold font-monospace text-dark text-decoration-none">
                                            <?php echo e($res->booking_reference); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <div><?php echo e($res->roomType->name); ?></div>
                                        <?php if($res->room): ?>
                                            <span class="badge bg-dark text-warning">Room <?php echo e($res->room->room_number); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($res->check_in_date->format('M d')); ?> - <?php echo e($res->check_out_date->format('M d, Y')); ?>

                                        <small class="text-muted d-block"><?php echo e($res->nights); ?> Nights</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($res->status_badge); ?> text-uppercase">
                                            <?php echo e(str_replace('_', ' ', $res->booking_status)); ?>

                                        </span>
                                    </td>
                                    <td class="fw-bold text-success">$<?php echo e(number_format($res->total_amount, 2)); ?></td>
                                    <td class="text-end">
                                        <a href="<?php echo e(route('admin.reservations.show', $res->id)); ?>" class="btn btn-sm btn-outline-dark" title="View Folio">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('booking.receipt', $res->booking_reference)); ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Receipt">
                                            <i class="bi bi-receipt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No stay records found for this guest.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/guests/show.blade.php ENDPATH**/ ?>