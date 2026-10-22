<?php $__env->startSection('title', 'Housekeeping & Facility Cleaning Board'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Housekeeping Operations Board</h3>
        <p class="text-secondary small mb-0">Manage daily sanitization, linen turnovers, turn-down services, and inspection sign-offs.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <button class="btn btn-warning btn-sm px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#newTaskModal">
            <i class="bi bi-plus-circle-fill me-1"></i> Schedule Cleaning Task
        </button>
    </div>
</div>

<!-- Rooms Needing Immediate Turnover / Inspection -->
<div class="card border rounded-4 shadow-sm bg-white mb-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-serif fw-bold mb-0 text-dark">
            <i class="bi bi-exclamation-circle-fill text-warning me-2"></i> Rooms Requiring Turnover & Inspection
        </h5>
        <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 rounded-pill">
            <?php echo e($roomsNeedingCleaning->count()); ?> Rooms Pending Turnover
        </span>
    </div>

    <?php if($roomsNeedingCleaning->count() > 0): ?>
        <div class="row g-3">
            <?php $__currentLoopData = $roomsNeedingCleaning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-xl-3">
                    <div class="p-3 border rounded-3 bg-light d-flex flex-column justify-content-between h-100">
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="fw-bold text-dark mb-0">Room <?php echo e($rm->room_number); ?></h5>
                                <span class="badge bg-<?php echo e($rm->status_badge); ?> text-uppercase" style="font-size: 0.65rem;"><?php echo e($rm->status); ?></span>
                            </div>
                            <small class="text-secondary d-block"><?php echo e($rm->roomType->name); ?> &bull; Floor <?php echo e($rm->floor); ?></small>
                            <small class="text-danger fw-semibold d-block mt-1">Status: <?php echo e(ucfirst($rm->housekeeping_status)); ?></small>
                        </div>
                        <form action="<?php echo e(route('admin.housekeeping.mark-clean', $rm->id)); ?>" method="POST" class="mt-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">
                                <i class="bi bi-check2-circle me-1"></i> Mark Clean & Inspected
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-3 text-muted">
            <i class="bi bi-stars text-success fs-3 d-block mb-1"></i>
            All hotel rooms are currently cleaned, sanitized, and inspected!
        </div>
    <?php endif; ?>
</div>

<!-- Housekeeping Tasks Kanban Columns -->
<div class="row g-4">
    <!-- 1. Pending Tasks -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white h-100">
            <div class="card-header bg-warning-subtle py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-hourglass-split me-1"></i> Pending Tasks</h6>
                <span class="badge bg-dark"><?php echo e($pendingTasks->count()); ?></span>
            </div>
            <div class="card-body p-3 d-flex flex-column gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $pendingTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 border rounded-3 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="fw-bold text-dark fs-6">Room <?php echo e($task->room->room_number ?? 'N/A'); ?></span>
                            <span class="badge bg-<?php echo e($task->priority_badge); ?> text-uppercase" style="font-size: 0.65rem;"><?php echo e($task->priority); ?></span>
                        </div>
                        <small class="text-muted d-block text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">
                            <?php echo e(str_replace('_', ' ', $task->task_type)); ?>

                        </small>
                        <p class="small text-secondary mb-2"><?php echo e($task->notes ?? 'Standard turnover and linen restocking.'); ?></p>
                        <small class="text-muted d-block mb-3"><i class="bi bi-person me-1"></i> Assigned: <?php echo e($task->assigned_staff_name ?? 'Housekeeping Team'); ?></small>
                        
                        <form action="<?php echo e(route('admin.housekeeping.task.status', $task->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn btn-outline-primary btn-sm w-100 fw-semibold">
                                Start Cleaning &rarr;
                            </button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4 text-muted small">No pending tasks.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 2. In Progress Tasks -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white h-100">
            <div class="card-header bg-primary-subtle py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-arrow-repeat me-1"></i> Cleaning In Progress</h6>
                <span class="badge bg-primary"><?php echo e($inProgressTasks->count()); ?></span>
            </div>
            <div class="card-body p-3 d-flex flex-column gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $inProgressTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 border rounded-3 bg-white shadow-sm border-primary">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="fw-bold text-dark fs-6">Room <?php echo e($task->room->room_number ?? 'N/A'); ?></span>
                            <span class="badge bg-primary text-uppercase" style="font-size: 0.65rem;">In Progress</span>
                        </div>
                        <small class="text-muted d-block text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">
                            <?php echo e(str_replace('_', ' ', $task->task_type)); ?>

                        </small>
                        <p class="small text-secondary mb-2"><?php echo e($task->notes ?? 'Cleaning underway.'); ?></p>
                        <small class="text-muted d-block mb-3"><i class="bi bi-person me-1"></i> <?php echo e($task->assigned_staff_name); ?></small>
                        
                        <form action="<?php echo e(route('admin.housekeeping.task.status', $task->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">
                                <i class="bi bi-check-lg me-1"></i> Mark Completed & Inspected
                            </button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4 text-muted small">No rooms currently being cleaned.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 3. Completed Tasks -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white h-100">
            <div class="card-header bg-success-subtle py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-success"><i class="bi bi-check-circle-fill me-1"></i> Completed & Inspected</h6>
                <span class="badge bg-success"><?php echo e($completedTasks->count()); ?></span>
            </div>
            <div class="card-body p-3 d-flex flex-column gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $completedTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 border rounded-3 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="fw-bold text-dark">Room <?php echo e($task->room->room_number ?? 'N/A'); ?></span>
                            <span class="badge bg-success-subtle text-success small">Done</span>
                        </div>
                        <small class="text-muted d-block"><?php echo e(str_replace('_', ' ', $task->task_type)); ?></small>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-check-all text-success"></i> Signed off <?php echo e($task->completed_at ? $task->completed_at->diffForHumans() : 'recently'); ?>

                        </small>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4 text-muted small">No recently completed tasks.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Schedule Cleaning Task -->
<div class="modal fade" id="newTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white p-4">
                <h5 class="modal-title font-serif">Schedule Housekeeping Task</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('admin.housekeeping.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Room Number</label>
                        <select name="room_id" class="form-select" required>
                            <?php $__currentLoopData = $allRooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($r->id); ?>">Room <?php echo e($r->room_number); ?> (Floor <?php echo e($r->floor); ?>) &bull; Status: <?php echo e(ucfirst($r->status)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Task Type</label>
                        <select name="task_type" class="form-select" required>
                            <option value="routine_cleaning" selected>Routine Daily Cleaning</option>
                            <option value="checkout_sanitization">Checkout Sanitization & Turnover</option>
                            <option value="deep_cleaning">Deep Cleaning & Upholstery</option>
                            <option value="turn_down">Evening Turn-Down Service</option>
                            <option value="linen_change">Linen & Towel Replacement</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Priority</label>
                        <select name="priority" class="form-select" required>
                            <option value="normal" selected>Normal</option>
                            <option value="high">High Priority</option>
                            <option value="urgent">Urgent (Immediate Guest Arrival)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Assigned Staff Member</label>
                        <input type="text" name="assigned_staff_name" class="form-control" placeholder="e.g. Carlos Mendez" value="Carlos Mendez">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Special Notes & Instructions</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="e.g. VIP guest arrival, extra organic toiletries..."></textarea>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold px-4">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/housekeeping/index.blade.php ENDPATH**/ ?>