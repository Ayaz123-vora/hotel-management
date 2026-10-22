<?php $__env->startSection('title', 'Guest Directory & CRM'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Guest Directory & CRM</h3>
        <p class="text-secondary small mb-0">Manage guest profiles, lifetime stays, VIP status, and contact history.</p>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="card border rounded-4 shadow-sm mb-4 bg-white p-3">
    <form action="<?php echo e(route('admin.guests.index')); ?>" method="GET" class="row g-2 align-items-center">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone, ID number..." value="<?php echo e(request('search')); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <select name="vip" class="form-select">
                <option value="">All Guests</option>
                <option value="1" <?php echo e(request('vip') == '1' ? 'selected' : ''); ?>>VIP Guests Only</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100 fw-semibold">Search</button>
            <a href="<?php echo e(route('admin.guests.index')); ?>" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>
</div>

<!-- Guests Table -->
<div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th>Guest Name</th>
                        <th>Contact Information</th>
                        <th>Identification</th>
                        <th>Location</th>
                        <th>Total Stays</th>
                        <th>VIP Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $guests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-dark text-warning p-2 rounded-circle fw-bold text-center" style="width: 36px; height: 36px; line-height: 20px;">
                                        <?php echo e(substr($g->first_name, 0, 1)); ?><?php echo e(substr($g->last_name, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <a href="<?php echo e(route('admin.guests.show', $g->id)); ?>" class="fw-bold text-dark text-decoration-none">
                                            <?php echo e($g->full_name); ?>

                                        </a>
                                        <small class="text-muted d-block">Registered <?php echo e($g->created_at->format('M Y')); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="bi bi-envelope text-warning me-1"></i> <?php echo e($g->email); ?></div>
                                <small class="text-muted"><i class="bi bi-telephone text-warning me-1"></i> <?php echo e($g->phone); ?></small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?php echo e($g->id_type); ?></span>
                                <small class="text-muted font-monospace d-block"><?php echo e($g->id_number ?? 'Not Recorded'); ?></small>
                            </td>
                            <td><?php echo e($g->city ?? 'N/A'); ?>, <?php echo e($g->country ?? 'N/A'); ?></td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-1 fs-6">
                                    <?php echo e($g->reservations_count); ?> Stay<?php echo e($g->reservations_count != 1 ? 's' : ''); ?>

                                </span>
                            </td>
                            <td>
                                <form action="<?php echo e(route('admin.guests.toggle-vip', $g->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm <?php echo e($g->vip_status ? 'btn-warning' : 'btn-outline-secondary'); ?>" title="Click to toggle VIP status">
                                        <i class="bi bi-star<?php echo e($g->vip_status ? '-fill' : ''); ?> me-1"></i> <?php echo e($g->vip_status ? 'VIP Guest' : 'Regular'); ?>

                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.guests.show', $g->id)); ?>" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-journal-text me-1"></i> View Profile
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No guest profiles found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($guests->hasPages()): ?>
        <div class="card-footer bg-white border-top p-3">
            <?php echo e($guests->links()); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/guests/index.blade.php ENDPATH**/ ?>