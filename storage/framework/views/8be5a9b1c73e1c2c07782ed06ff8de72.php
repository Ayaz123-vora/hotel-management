<?php $__env->startSection('title', 'Front Desk Walk-In Booking'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?php echo e(route('admin.reservations.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <div>
        <h3 class="fw-bold mb-0">New Walk-In Reservation</h3>
        <p class="text-secondary small mb-0">Front desk registration for walk-in or telephone reservations.</p>
    </div>
</div>

<form action="<?php echo e(route('admin.reservations.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="row g-4">
        <!-- Left: Form Fields -->
        <div class="col-lg-8">
            <!-- Room & Stay Details -->
            <div class="card border rounded-4 shadow-sm bg-white p-4 mb-4">
                <h5 class="font-serif fw-bold mb-3"><i class="bi bi-door-open-fill text-warning me-2"></i> Accommodation Selection</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Room Category</label>
                        <select name="room_type_id" id="walkInRoomType" class="form-select" required>
                            <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($rt->id); ?>" data-price="<?php echo e($rt->base_price); ?>">
                                    <?php echo e($rt->name); ?> &bull; $<?php echo e(number_format($rt->base_price, 0)); ?>/night
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Assign Physical Room (Optional)</label>
                        <select name="room_id" class="form-select">
                            <option value="">Auto-Assign or Assign Later</option>
                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($rm->id); ?>">Room <?php echo e($rm->room_number); ?> (Floor <?php echo e($rm->floor); ?>) &bull; <?php echo e($rm->roomType->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Check-In Date</label>
                        <input type="date" name="check_in_date" id="walkInCheckIn" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Check-Out Date</label>
                        <input type="date" name="check_out_date" id="walkInCheckOut" class="form-control" value="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Adults</label>
                        <input type="number" name="adults" class="form-control" value="2" min="1" max="10" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Children</label>
                        <input type="number" name="children" class="form-control" value="0" min="0" max="10">
                    </div>
                </div>
            </div>

            <!-- Guest Details -->
            <div class="card border rounded-4 shadow-sm bg-white p-4 mb-4">
                <h5 class="font-serif fw-bold mb-3"><i class="bi bi-person-fill text-warning me-2"></i> Guest Information</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="e.g. Liam" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="e.g. Chen" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="e.g. liam@example.com" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Phone</label>
                        <input type="tel" name="phone" class="form-control" placeholder="e.g. +1 (555) 019-2834" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">ID Type</label>
                        <select name="id_type" class="form-select">
                            <option value="Passport">Passport</option>
                            <option value="National ID">National ID</option>
                            <option value="Driver License">Driver's License</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">ID / Passport Number</label>
                        <input type="text" name="id_number" class="form-control" placeholder="e.g. US-9842109">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Special Requests & Notes</label>
                        <textarea name="special_requests" class="form-control" rows="2" placeholder="e.g. Late checkout, extra pillows..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Payment & Summary -->
        <div class="col-lg-4">
            <div class="card border rounded-4 shadow-sm bg-white p-4 sticky-top" style="top: 90px;">
                <h5 class="font-serif fw-bold mb-3 pb-2 border-bottom">Billing & Deposit</h5>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary text-uppercase">Deposit / Payment Collected Now</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="paid_amount" class="form-control" placeholder="0.00" value="0.00">
                    </div>
                    <small class="text-muted">Enter full or partial payment collected at desk.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary text-uppercase">Payment Method</label>
                    <select name="payment_method" class="form-select">
                        <option value="cash" selected>Cash at Front Desk</option>
                        <option value="card">Credit / Debit Card Terminal</option>
                        <option value="upi">UPI / Online Transfer</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> Create Reservation
                </button>
            </div>
        </div>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/reservations/create.blade.php ENDPATH**/ ?>