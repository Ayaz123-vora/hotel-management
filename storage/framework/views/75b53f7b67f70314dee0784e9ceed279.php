<?php $__env->startSection('title', 'Reservation Confirmed - Grand Horizon Hotel'); ?>

<?php $__env->startSection('content'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Card -->
            <div class="card card-luxury border-0 shadow-lg rounded-4 overflow-hidden text-center mb-4">
                <!-- Top Header Banner -->
                <div class="bg-success text-white py-5 px-4 position-relative" style="background: linear-gradient(135deg, #0f5132, #198754);">
                    <div class="badge bg-white text-success px-3 py-2 rounded-pill fs-6 mb-3 shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> Booking Confirmed & Verified
                    </div>
                    <h2 class="display-5 font-serif fw-bold mb-2">We Look Forward to Welcoming You</h2>
                    <p class="lead text-white-50 mb-0">Your reservation has been confirmed and automated confirmation has been registered.</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Booking Reference Highlight Box -->
                    <div class="p-4 bg-light rounded-4 border mb-4 text-center">
                        <small class="text-secondary text-uppercase fw-bold letter-spacing-1 d-block mb-1">Official Booking Reference</small>
                        <h1 class="display-5 fw-bold text-dark font-monospace mb-1"><?php echo e($reservation->booking_reference); ?></h1>
                        <small class="text-muted">Please present this reference number or digital receipt upon arrival at the front desk.</small>
                    </div>

                    <!-- Stay & Room Summary Details -->
                    <div class="row g-4 text-start mb-4">
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-white h-100">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Guest Details</small>
                                <h6 class="fw-bold text-dark mb-1"><?php echo e($reservation->guest->full_name); ?></h6>
                                <p class="small text-secondary mb-0">
                                    <i class="bi bi-envelope me-1"></i> <?php echo e($reservation->guest->email); ?><br>
                                    <i class="bi bi-telephone me-1"></i> <?php echo e($reservation->guest->phone); ?>

                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-white h-100">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Accommodation</small>
                                <h6 class="fw-bold text-dark mb-1"><?php echo e($reservation->roomType->name); ?></h6>
                                <p class="small text-secondary mb-0">
                                    <?php if($reservation->room): ?>
                                        <span class="badge bg-dark text-warning"><i class="bi bi-door-closed-fill me-1"></i> Assigned Room: <?php echo e($reservation->room->room_number); ?> (Floor <?php echo e($reservation->room->floor); ?>)</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary">Room assigned upon check-in</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-white h-100">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Check-In</small>
                                <h6 class="fw-bold text-dark mb-0"><?php echo e($reservation->check_in_date->format('l, F j, Y')); ?></h6>
                                <small class="text-muted">From 3:00 PM onwards</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-white h-100">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Check-Out</small>
                                <h6 class="fw-bold text-dark mb-0"><?php echo e($reservation->check_out_date->format('l, F j, Y')); ?></h6>
                                <small class="text-muted">By 11:00 AM</small>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Summary -->
                    <div class="p-3 bg-success-subtle text-success-emphasis border border-success-subtle rounded-3 text-start mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="fw-bold text-uppercase d-block">Transaction Status</small>
                            <span class="fw-bold fs-6">
                                <i class="bi bi-shield-check text-success me-1"></i> 
                                Paid in Full ($<?php echo e(number_format($reservation->paid_amount, 2)); ?>) via <?php echo e(ucfirst($latestPayment->payment_method ?? 'Online')); ?>

                            </span>
                            <?php if($latestPayment): ?>
                                <div class="small text-muted font-monospace mt-1">Transaction Ref: <?php echo e($latestPayment->transaction_id); ?></div>
                            <?php endif; ?>
                        </div>
                        <span class="badge bg-success text-white px-3 py-2 rounded-pill">Confirmed</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="<?php echo e(route('booking.receipt', $reservation->booking_reference)); ?>" target="_blank" class="btn btn-dark btn-lg px-4 py-3 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-receipt me-2"></i> Print / Download Digital Receipt
                        </a>
                        <a href="<?php echo e(route('facilities.index')); ?>" class="btn btn-outline-dark btn-lg px-4 py-3 rounded-pill fw-semibold">
                            <i class="bi bi-water me-2"></i> Book Spa & Cabanas
                        </a>
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-link text-secondary py-3 text-decoration-none">
                            Return to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/booking/confirmation.blade.php ENDPATH**/ ?>