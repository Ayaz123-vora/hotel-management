<?php $__env->startSection('title', 'Find My Reservation - Grand Horizon Hotel'); ?>

<?php $__env->startSection('content'); ?>

<!-- Header -->
<div class="bg-dark text-white py-5 mb-5" style="background: linear-gradient(rgba(11,19,43,0.85), rgba(11,19,43,0.95)), url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1920&q=80') center/cover;">
    <div class="container text-center py-4">
        <span class="text-warning text-uppercase letter-spacing-2 fw-bold small">Guest Self-Service Portal</span>
        <h1 class="display-4 font-serif fw-bold mt-1 text-white">Find Your Reservation</h1>
        <p class="lead text-white-50 max-w-700 mx-auto">
            Retrieve your booking details, view room allocations, and access your official digital receipts anytime.
        </p>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <!-- Search Form Card -->
            <div class="card card-luxury p-4 p-md-5 border rounded-4 shadow-sm bg-white mb-5">
                <h4 class="font-serif fw-bold mb-3">Retrieve Booking</h4>
                <p class="text-secondary small mb-4">Please enter your 10-character booking reference code and the email address used during reservation.</p>

                <?php if($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo e($error); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('booking.lookup')); ?>" method="GET">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Booking Reference Code</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white"><i class="bi bi-ticket-perforated text-warning"></i></span>
                            <input type="text" name="booking_reference" class="form-control text-uppercase" placeholder="e.g. GH-26-PENT01" value="<?php echo e(request('booking_reference')); ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Guest Email Address</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white"><i class="bi bi-envelope text-warning"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="e.g. sophia.montgomery@example.com" value="<?php echo e(request('email')); ?>" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm">
                        <i class="bi bi-search me-1"></i> Retrieve Reservation Details
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top text-center">
                    <small class="text-muted">
                        Need quick sample data? Try reference: <strong class="text-dark">GH-26-PENT01</strong> with email: <strong class="text-dark">sophia.montgomery@example.com</strong>
                    </small>
                </div>
            </div>

            <!-- Found Reservation Result Card -->
            <?php if($reservation): ?>
                <div class="card card-luxury border rounded-4 shadow-md bg-white overflow-hidden mb-5">
                    <div class="bg-dark text-white p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-warning text-dark text-uppercase px-2 py-1 small mb-1">Reservation Verified</span>
                            <h4 class="font-serif fw-bold text-white mb-0"><?php echo e($reservation->booking_reference); ?></h4>
                        </div>
                        <span class="badge bg-<?php echo e($reservation->status_badge); ?> fs-6 px-3 py-2 text-uppercase">
                            <?php echo e(str_replace('_', ' ', $reservation->booking_status)); ?>

                        </span>
                    </div>

                    <div class="p-4 p-md-5">
                        <div class="row g-4 mb-4 pb-3 border-bottom">
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Primary Guest</small>
                                <h6 class="fw-bold text-dark mb-0"><?php echo e($reservation->guest->full_name); ?></h6>
                                <small class="text-secondary"><?php echo e($reservation->guest->email); ?> &bull; <?php echo e($reservation->guest->phone); ?></small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Reserved Suite</small>
                                <h6 class="fw-bold text-dark mb-0"><?php echo e($reservation->roomType->name); ?></h6>
                                <small class="text-secondary"><?php echo e($reservation->roomType->bed_type); ?></small>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Stay Duration</small>
                                <h6 class="fw-bold text-dark mb-0">
                                    <?php echo e($reservation->check_in_date->format('M d, Y')); ?> &rarr; <?php echo e($reservation->check_out_date->format('M d, Y')); ?>

                                </h6>
                                <small class="text-secondary"><?php echo e($reservation->nights); ?> Nights &bull; <?php echo e($reservation->adults); ?> Adults</small>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Room Assignment</small>
                                <?php if($reservation->room): ?>
                                    <h6 class="fw-bold text-success mb-0">
                                        <i class="bi bi-door-closed-fill"></i> Room <?php echo e($reservation->room->room_number); ?> (Floor <?php echo e($reservation->room->floor); ?>)
                                    </h6>
                                    <?php if($reservation->assigned_key_card): ?>
                                        <small class="text-muted font-monospace">Digital Key: <?php echo e($reservation->assigned_key_card); ?></small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <h6 class="fw-bold text-warning mb-0">Room Assigned at Check-in</h6>
                                    <small class="text-muted">Guaranteed reservation confirmed</small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Financial Ledger summary -->
                        <div class="p-3 bg-light rounded-3 border mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-bold d-block">Folio Financial Status</small>
                                <span class="fw-bold text-dark fs-5">$<?php echo e(number_format($reservation->total_amount, 2)); ?></span>
                                <span class="badge bg-success ms-2">PAID ($<?php echo e(number_format($reservation->paid_amount, 2)); ?>)</span>
                            </div>
                            <a href="<?php echo e(route('booking.receipt', $reservation->booking_reference)); ?>" target="_blank" class="btn btn-dark fw-bold">
                                <i class="bi bi-receipt me-1"></i> View / Print Digital Receipt
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/booking/lookup.blade.php ENDPATH**/ ?>