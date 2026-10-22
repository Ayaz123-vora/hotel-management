<?php $__env->startSection('title', 'Executive Management Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<!-- Page Title & Top Actions -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Executive Dashboard</h3>
        <p class="text-secondary small mb-0">Real-time room occupancy, front-desk arrival flows, and facility operations.</p>
    </div>
    <div class="d-flex gap-2 mt-3 mt-md-0">
        <a href="<?php echo e(route('admin.reservations.create')); ?>" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Front Desk Walk-In
        </a>
        <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-dark btn-sm px-3 shadow-sm">
            <i class="bi bi-grid-3x3-gap me-1"></i> Room Matrix
        </a>
    </div>
</div>

<!-- Primary KPI Cards Row -->
<div class="row g-3 mb-4">
    <!-- Occupancy Rate -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary small fw-bold text-uppercase">Occupancy Rate</span>
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-pie-chart-fill"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-1"><?php echo e($occupancyRate); ?>%</h2>
            <div class="progress mb-2" style="height: 6px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($occupancyRate); ?>%"></div>
            </div>
            <small class="text-muted"><?php echo e($occupiedRooms); ?> of <?php echo e($totalRooms); ?> Rooms Currently Occupied</small>
        </div>
    </div>

    <!-- Room Inventory Status -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary small fw-bold text-uppercase">Available Rooms</span>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-door-open-fill"></i>
                </div>
            </div>
            <h2 class="fw-bold text-success mb-1"><?php echo e($availableRooms); ?></h2>
            <div class="d-flex gap-2 small mt-2">
                <span class="badge bg-warning-subtle text-warning-emphasis"><?php echo e($reservedRooms); ?> Reserved</span>
                <span class="badge bg-info-subtle text-info-emphasis"><?php echo e($cleaningRooms); ?> Cleaning</span>
                <span class="badge bg-secondary-subtle text-secondary"><?php echo e($maintenanceRooms); ?> Maint.</span>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary small fw-bold text-uppercase">Monthly Revenue</span>
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <h2 class="fw-bold text-dark mb-1">$<?php echo e(number_format($monthRevenue, 2)); ?></h2>
            <small class="text-muted">Today's Transactions: <strong class="text-success">$<?php echo e(number_format($todayRevenue, 2)); ?></strong></small>
        </div>
    </div>

    <!-- Pending Housekeeping -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary small fw-bold text-uppercase">Housekeeping Queue</span>
                <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-brush-fill"></i>
                </div>
            </div>
            <h2 class="fw-bold text-danger mb-1"><?php echo e($pendingHousekeepingCount); ?></h2>
            <small class="text-muted">Rooms requiring turn-down or sanitization</small>
        </div>
    </div>
</div>

<!-- Front Desk Operations: Arrivals & Departures Today -->
<div class="row g-4 mb-4">
    <!-- Today's Arrivals -->
    <div class="col-lg-6">
        <div class="card border rounded-4 shadow-sm h-100 bg-white">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-box-arrow-in-right text-success me-2"></i> Today's Arrivals (Check-Ins)</h6>
                <span class="badge bg-success-subtle text-success"><?php echo e($todayArrivals->count()); ?> Guests</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Guest</th>
                                <th>Suite</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $todayArrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark"><?php echo e($arr->guest->full_name); ?></div>
                                        <small class="text-muted font-monospace"><?php echo e($arr->booking_reference); ?></small>
                                    </td>
                                    <td>
                                        <div><?php echo e($arr->roomType->name); ?></div>
                                        <?php if($arr->room): ?>
                                            <span class="badge bg-dark text-warning">Room <?php echo e($arr->room->room_number); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary">Assign at Desk</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($arr->status_badge); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $arr->booking_status))); ?></span>
                                    </td>
                                    <td class="text-end">
                                        <?php if($arr->booking_status === 'confirmed'): ?>
                                            <form action="<?php echo e(route('admin.reservations.check-in', $arr->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-success px-3 fw-bold">
                                                    <i class="bi bi-key-fill me-1"></i> Check In
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">Checked In</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No arrivals scheduled for today.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Departures -->
    <div class="col-lg-6">
        <div class="card border rounded-4 shadow-sm h-100 bg-white">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-box-arrow-right text-danger me-2"></i> Today's Departures (Check-Outs)</h6>
                <span class="badge bg-danger-subtle text-danger"><?php echo e($todayDepartures->count()); ?> Guests</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Folio Balance</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $todayDepartures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark"><?php echo e($dep->guest->full_name); ?></div>
                                        <small class="text-muted font-monospace"><?php echo e($dep->booking_reference); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-dark text-warning">Room <?php echo e($dep->room->room_number ?? 'N/A'); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">$<?php echo e(number_format($dep->balance_due, 2)); ?></span>
                                    </td>
                                    <td class="text-end">
                                        <form action="<?php echo e(route('admin.reservations.check-out', $dep->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-danger px-3 fw-bold">
                                                <i class="bi bi-box-arrow-right me-1"></i> Check Out
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No departures scheduled for today.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Visual Room Matrix Quick View -->
<div class="card border rounded-4 shadow-sm mb-4 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-grid-3x3-gap-fill text-warning me-2"></i> Live Room Matrix & Status Board</h6>
            <small class="text-muted">Click any room to adjust its operational or cleaning status.</small>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-success-subtle text-success">Available</span>
            <span class="badge bg-danger-subtle text-danger">Occupied</span>
            <span class="badge bg-warning-subtle text-warning-emphasis">Reserved</span>
            <span class="badge bg-info-subtle text-info-emphasis">Cleaning</span>
            <span class="badge bg-secondary-subtle text-secondary">Maintenance</span>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row g-2">
            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                    <div class="room-chip bg-<?php echo e($room->status_badge); ?>-subtle text-<?php echo e($room->status_badge); ?>-emphasis border border-<?php echo e($room->status_badge); ?>-subtle" data-bs-toggle="modal" data-bs-target="#statusModal<?php echo e($room->id); ?>">
                        <div class="fw-bold fs-5">Room <?php echo e($room->room_number); ?></div>
                        <small class="d-block text-truncate" style="font-size: 0.72rem;"><?php echo e($room->roomType->name); ?></small>
                        <span class="badge bg-<?php echo e($room->status_badge); ?> text-uppercase mt-1" style="font-size: 0.65rem;">
                            <?php echo e($room->status); ?>

                        </span>
                    </div>

                    <!-- Modal for Quick Status Changer -->
                    <div class="modal fade" id="statusModal<?php echo e($room->id); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content rounded-4 border-0 shadow">
                                <div class="modal-header bg-dark text-white p-3">
                                    <h6 class="modal-title font-serif">Room <?php echo e($room->room_number); ?> Status</h6>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="<?php echo e(route('admin.rooms.status', $room->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-body p-3">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Room Status</label>
                                        <select name="status" class="form-select mb-3">
                                            <option value="available" <?php echo e($room->status === 'available' ? 'selected' : ''); ?>>Available</option>
                                            <option value="occupied" <?php echo e($room->status === 'occupied' ? 'selected' : ''); ?>>Occupied</option>
                                            <option value="reserved" <?php echo e($room->status === 'reserved' ? 'selected' : ''); ?>>Reserved</option>
                                            <option value="cleaning" <?php echo e($room->status === 'cleaning' ? 'selected' : ''); ?>>Cleaning</option>
                                            <option value="maintenance" <?php echo e($room->status === 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                                        </select>
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Housekeeping</label>
                                        <select name="housekeeping_status" class="form-select">
                                            <option value="clean" <?php echo e($room->housekeeping_status === 'clean' ? 'selected' : ''); ?>>Clean & Inspected</option>
                                            <option value="inspecting" <?php echo e($room->housekeeping_status === 'inspecting' ? 'selected' : ''); ?>>Under Inspection</option>
                                            <option value="dirty" <?php echo e($room->housekeeping_status === 'dirty' ? 'selected' : ''); ?>>Dirty / Needs Turnover</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer p-2 bg-light">
                                        <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold">Update Room</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- Recent Reservations List -->
<div class="card border rounded-4 shadow-sm bg-white mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history text-primary me-2"></i> Recent Bookings & Folios</h6>
        <a href="<?php echo e(route('admin.reservations.index')); ?>" class="btn btn-sm btn-outline-dark">View All Reservations &rarr;</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th>Booking Ref</th>
                        <th>Guest</th>
                        <th>Suite</th>
                        <th>Stay Dates</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recentReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('admin.reservations.show', $r->id)); ?>" class="fw-bold text-dark font-monospace text-decoration-none">
                                    <?php echo e($r->booking_reference); ?>

                                </a>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?php echo e($r->guest->full_name); ?></div>
                                <small class="text-muted"><?php echo e($r->guest->email); ?></small>
                            </td>
                            <td><?php echo e($r->roomType->name); ?></td>
                            <td>
                                <?php echo e($r->check_in_date->format('M d')); ?> - <?php echo e($r->check_out_date->format('M d, Y')); ?>

                                <small class="text-muted d-block"><?php echo e($r->nights); ?> Nights</small>
                            </td>
                            <td class="fw-bold text-success">$<?php echo e(number_format($r->total_amount, 2)); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($r->status_badge); ?> text-uppercase">
                                    <?php echo e(str_replace('_', ' ', $r->booking_status)); ?>

                                </span>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.reservations.show', $r->id)); ?>" class="btn btn-sm btn-light border" title="View Folio">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('booking.receipt', $r->booking_reference)); ?>" target="_blank" class="btn btn-sm btn-outline-dark" title="Print Receipt">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>