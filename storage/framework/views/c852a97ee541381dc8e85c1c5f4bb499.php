<?php $__env->startSection('title', 'Suites & Accommodations - Grand Horizon Hotel'); ?>

<?php $__env->startSection('content'); ?>

<!-- Header Banner -->
<div class="bg-dark text-white py-5 mb-5" style="background: linear-gradient(rgba(11,19,43,0.85), rgba(11,19,43,0.95)), url('https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1920&q=80') center/cover;">
    <div class="container text-center py-4">
        <span class="text-warning text-uppercase letter-spacing-2 fw-bold small">Luxury Accommodations</span>
        <h1 class="display-4 font-serif fw-bold mt-1 text-white">Curated Suites & Penthouses</h1>
        <p class="lead text-white-50 max-w-700 mx-auto">
            Find the quintessential sanctuary tailored to your travel desires, complete with complimentary high-speed fiber internet and premium bath amenities.
        </p>
    </div>
</div>

<div class="container mb-5">
    <!-- Filter Bar -->
    <div class="card shadow-sm border-0 mb-5 p-4 bg-white rounded-4 border">
        <form action="<?php echo e(route('rooms.index')); ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-lg-3 col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase"><i class="bi bi-calendar-event text-warning me-1"></i> Check-In</label>
                <input type="date" name="check_in" class="form-control" value="<?php echo e($checkIn); ?>" min="<?php echo e(date('Y-m-d')); ?>">
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase"><i class="bi bi-calendar-check text-warning me-1"></i> Check-Out</label>
                <input type="date" name="check_out" class="form-control" value="<?php echo e($checkOut); ?>" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>">
            </div>
            <div class="col-lg-2 col-md-4">
                <label class="form-label small fw-bold text-secondary text-uppercase"><i class="bi bi-people text-warning me-1"></i> Guests</label>
                <select name="guests" class="form-select">
                    <option value="">Any Capacity</option>
                    <option value="1" <?php echo e(request('guests') == '1' ? 'selected' : ''); ?>>1 Person</option>
                    <option value="2" <?php echo e(request('guests') == '2' ? 'selected' : ''); ?>>2 People</option>
                    <option value="3" <?php echo e(request('guests') == '3' ? 'selected' : ''); ?>>3 People</option>
                    <option value="4" <?php echo e(request('guests') == '4' ? 'selected' : ''); ?>>4+ People</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <label class="form-label small fw-bold text-secondary text-uppercase"><i class="bi bi-tag text-warning me-1"></i> Max Price</label>
                <select name="max_price" class="form-select">
                    <option value="">Any Budget</option>
                    <option value="200" <?php echo e(request('max_price') == '200' ? 'selected' : ''); ?>>Under $200</option>
                    <option value="350" <?php echo e(request('max_price') == '350' ? 'selected' : ''); ?>>Under $350</option>
                    <option value="500" <?php echo e(request('max_price') == '500' ? 'selected' : ''); ?>>Under $500</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-gold w-100 py-2 fw-semibold">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-outline-secondary py-2" title="Reset Filters">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Rooms Results Grid -->
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-6">
                <div class="card card-luxury h-100 border rounded-4 overflow-hidden">
                    <div class="row g-0 h-100">
                        <div class="col-md-5 position-relative">
                            <img src="<?php echo e($type->featured_image); ?>" class="w-100 h-100 object-fit-cover min-h-250" alt="<?php echo e($type->name); ?>">
                            <span class="badge bg-dark text-warning position-absolute top-0 start-0 m-3 px-3 py-2 shadow-sm fs-6">
                                $<?php echo e(number_format($type->base_price, 0)); ?> <small class="text-white-50">/ night</small>
                            </span>
                        </div>
                        <div class="col-md-7 d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge bg-gold text-dark small fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1 text-success"></i> Available
                                </span>
                                <small class="text-muted"><i class="bi bi-arrows-fullscreen me-1"></i> <?php echo e($type->room_size_sqft); ?> sq ft</small>
                            </div>
                            <h4 class="font-serif fw-bold text-dark mt-1 mb-2"><?php echo e($type->name); ?></h4>
                            <p class="text-secondary small mb-3 flex-grow-1">
                                <?php echo e(Str::limit($type->tagline ?? $type->description, 120)); ?>

                            </p>

                            <!-- Key Specs -->
                            <div class="row g-2 small text-secondary mb-3 py-2 border-top border-bottom">
                                <div class="col-6">
                                    <i class="bi bi-door-closed text-warning me-1"></i> <?php echo e($type->bed_type); ?>

                                </div>
                                <div class="col-6">
                                    <i class="bi bi-people text-warning me-1"></i> Up to <?php echo e($type->capacity_adults + $type->capacity_children); ?> Guests
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('booking.create', ['room_type_id' => $type->id, 'check_in' => $checkIn, 'check_out' => $checkOut])); ?>" class="btn btn-gold flex-grow-1 py-2 fw-semibold">
                                    <i class="bi bi-calendar2-check me-1"></i> Reserve Now
                                </a>
                                <a href="<?php echo e(route('rooms.show', $type->slug)); ?>" class="btn btn-outline-dark px-3 py-2" title="Details">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                <h4 class="font-serif fw-bold">No Suites Match Your Selected Filter</h4>
                <p class="text-secondary mb-4">Please try adjusting your budget or capacity preferences to view available rooms.</p>
                <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-gold px-4 py-2 rounded-pill">Reset Filters</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/rooms/index.blade.php ENDPATH**/ ?>