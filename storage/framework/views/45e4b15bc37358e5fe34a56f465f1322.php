<?php $__env->startSection('title', 'Room Suites & Pricing'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Rooms</a>
    <div>
        <h3 class="fw-bold mb-0">Room Suites & Pricing</h3>
        <p class="text-secondary small mb-0">Configure room types, nightly base rates, guest capacities, and dimensions.</p>
    </div>
</div>

<div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th>Suite Name & Tagline</th>
                        <th>Base Price</th>
                        <th>Capacity</th>
                        <th>Bed Configuration</th>
                        <th>Size (Sq Ft)</th>
                        <th>Total Units</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="<?php echo e($type->featured_image); ?>" class="rounded-3 object-fit-cover border" width="60" height="45" alt="<?php echo e($type->name); ?>">
                                    <div>
                                        <div class="fw-bold text-dark fs-6"><?php echo e($type->name); ?></div>
                                        <small class="text-muted"><?php echo e(Str::limit($type->tagline, 60)); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold fs-6 text-success">$<?php echo e(number_format($type->base_price, 2)); ?></span>
                                <small class="text-muted d-block">/ night</small>
                            </td>
                            <td>
                                <span class="fw-semibold"><?php echo e($type->capacity_adults); ?> Adults</span>
                                <?php if($type->capacity_children > 0): ?>
                                    <small class="text-muted d-block">+<?php echo e($type->capacity_children); ?> Children</small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($type->bed_type); ?></td>
                            <td><?php echo e($type->room_size_sqft); ?> sq ft</td>
                            <td>
                                <span class="badge bg-dark"><?php echo e($type->rooms_count ?? $type->rooms()->count()); ?> Units</span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editTypeModal<?php echo e($type->id); ?>">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Pricing
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Room Type Modal -->
                        <div class="modal fade" id="editTypeModal<?php echo e($type->id); ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-header bg-dark text-white p-4">
                                        <h5 class="modal-title font-serif">Edit <?php echo e($type->name); ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?php echo e(route('admin.rooms.types.update', $type->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-secondary text-uppercase">Nightly Base Rate ($)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" step="0.01" name="base_price" class="form-control" value="<?php echo e($type->base_price); ?>" required>
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-secondary text-uppercase">Adult Capacity</label>
                                                    <input type="number" name="capacity_adults" class="form-control" value="<?php echo e($type->capacity_adults); ?>" min="1" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-secondary text-uppercase">Child Capacity</label>
                                                    <input type="number" name="capacity_children" class="form-control" value="<?php echo e($type->capacity_children); ?>" min="0" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-secondary text-uppercase">Bed Configuration</label>
                                                <input type="text" name="bed_type" class="form-control" value="<?php echo e($type->bed_type); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-secondary text-uppercase">Room Size (Sq Ft)</label>
                                                <input type="number" name="room_size_sqft" class="form-control" value="<?php echo e($type->room_size_sqft); ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer p-3 bg-light border-top">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-warning fw-bold px-4">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/rooms/types.blade.php ENDPATH**/ ?>