<?php $__env->startSection('title', 'Grand Horizon - 5-Star Luxury Beachfront Resort & Suites'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Hero Banner */
    .hero-section {
        background: linear-gradient(rgba(11, 19, 43, 0.65), rgba(11, 19, 43, 0.85)),
                    url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        min-height: 85vh;
        display: flex;
        align-items: center;
        color: #ffffff;
        position: relative;
    }

    .hero-search-card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        margin-top: -60px;
        position: relative;
        z-index: 20;
        border: 1px solid rgba(197, 168, 128, 0.3);
    }

    .feature-icon-box {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(197, 168, 128, 0.15);
        color: #b09164;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 1rem;
    }

    .hotel-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        background: rgba(197, 168, 128, 0.2);
        color: var(--hotel-gold);
        border: 1px solid rgba(197, 168, 128, 0.4);
        font-size: 0.85rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 600;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section -->
<section class="hero-section text-center text-md-start">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hotel-badge-pill mb-3">
                    <i class="bi bi-star-fill text-warning"></i> Award-Winning 5-Star Hospitality
                </div>
                <h1 class="display-3 fw-bold mb-3 text-white">
                    Where Timeless Luxury <br class="d-none d-md-block">
                    <span class="text-warning">Meets Ocean Serenity</span>
                </h1>
                <p class="lead text-white-50 mb-4 pe-lg-5">
                    Immerse yourself in unparalleled luxury, bespoke 24/7 butler attention, oceanfront jacuzzi penthouses, and world-class thermal spa sanctuaries.
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start">
                    <a href="<?php echo e(route('booking.create')); ?>" class="btn btn-gold btn-lg px-4 py-3 rounded-pill">
                        <i class="bi bi-calendar2-check me-2"></i> Book Your Stay
                    </a>
                    <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                        Explore Suites & Rooms
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Booking Availability Search Bar -->
<div class="container">
    <div class="hero-search-card p-4 p-md-5">
        <form action="<?php echo e(route('rooms.index')); ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-lg-3 col-md-6">
                <label class="form-label text-secondary small fw-bold text-uppercase"><i class="bi bi-calendar-event text-warning me-1"></i> Check-In Date</label>
                <input type="date" name="check_in" class="form-control form-control-lg border-secondary-subtle" value="<?php echo e(date('Y-m-d')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label text-secondary small fw-bold text-uppercase"><i class="bi bi-calendar-check text-warning me-1"></i> Check-Out Date</label>
                <input type="date" name="check_out" class="form-control form-control-lg border-secondary-subtle" value="<?php echo e(date('Y-m-d', strtotime('+2 days'))); ?>" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
            </div>
            <div class="col-lg-2 col-md-4">
                <label class="form-label text-secondary small fw-bold text-uppercase"><i class="bi bi-person text-warning me-1"></i> Guests</label>
                <select name="guests" class="form-select form-select-lg border-secondary-subtle">
                    <option value="1">1 Adult</option>
                    <option value="2" selected>2 Adults</option>
                    <option value="3">3 Adults</option>
                    <option value="4">4+ Adults (Family)</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <label class="form-label text-secondary small fw-bold text-uppercase"><i class="bi bi-door-closed text-warning me-1"></i> Suite Type</label>
                <select name="bed_type" class="form-select form-select-lg border-secondary-subtle">
                    <option value="">All Suites</option>
                    <option value="King">King Bed</option>
                    <option value="Queen">Queen / Double</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <button type="submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold">
                    <i class="bi bi-search me-1"></i> Check Rates
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Hotel Highlights & Stats -->
<section class="py-5 mt-4">
    <div class="container py-4">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="p-3 border rounded-3 bg-white shadow-sm">
                    <h2 class="display-6 fw-bold text-dark font-serif mb-1"><?php echo e($totalRooms); ?></h2>
                    <p class="text-secondary small text-uppercase mb-0">Luxury Rooms & Suites</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 border rounded-3 bg-white shadow-sm">
                    <h2 class="display-6 fw-bold text-success font-serif mb-1"><?php echo e($availableRooms); ?></h2>
                    <p class="text-secondary small text-uppercase mb-0">Available Today</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 border rounded-3 bg-white shadow-sm">
                    <h2 class="display-6 fw-bold text-warning font-serif mb-1">5.0 <i class="bi bi-star-fill fs-5"></i></h2>
                    <p class="text-secondary small text-uppercase mb-0">Guest Satisfaction Rating</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 border rounded-3 bg-white shadow-sm">
                    <h2 class="display-6 fw-bold text-dark font-serif mb-1">24 / 7</h2>
                    <p class="text-secondary small text-uppercase mb-0">Concierge & Front Desk</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Rooms Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-warning text-uppercase letter-spacing-2 fw-bold small">Exclusive Accommodations</span>
            <h2 class="display-5 font-serif fw-bold mt-1 mb-3">Signature Suites & Penthouses</h2>
            <p class="text-secondary">
                Every suite has been curated with bespoke handcrafted furniture, expansive ocean or city panoramas, acoustic peace, and state-of-the-art amenities.
            </p>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-luxury h-100 d-flex flex-column">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img src="<?php echo e($type->featured_image); ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo e($type->name); ?>">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-dark text-warning px-3 py-2 fs-6 shadow-sm">
                                    $<?php echo e(number_format($type->base_price, 0)); ?> <small class="text-white-50 fw-normal">/ night</small>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-secondary-subtle text-secondary small">
                                    <i class="bi bi-person-fill me-1"></i> Up to <?php echo e($type->capacity_adults + $type->capacity_children); ?> Guests
                                </span>
                                <span class="badge bg-light text-muted small border">
                                    <i class="bi bi-arrows-fullscreen me-1"></i> <?php echo e($type->room_size_sqft); ?> sq ft
                                </span>
                            </div>
                            <h4 class="card-title font-serif fw-bold text-dark mb-2"><?php echo e($type->name); ?></h4>
                            <p class="text-secondary small mb-3 flex-grow-1">
                                <?php echo e(Str::limit($type->description, 110)); ?>

                            </p>
                            
                            <!-- Amenities Preview -->
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                <?php if(is_array($type->amenities)): ?>
                                    <?php $__currentLoopData = array_slice($type->amenities, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-light text-dark border small fw-normal">
                                            <i class="bi bi-check text-success"></i> <?php echo e($amenity); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2 pt-2 border-top">
                                <a href="<?php echo e(route('booking.create', ['room_type_id' => $type->id])); ?>" class="btn btn-gold py-2 fw-semibold">
                                    <i class="bi bi-calendar-check me-1"></i> Book This Suite
                                </a>
                                <a href="<?php echo e(route('rooms.show', $type->slug)); ?>" class="btn btn-outline-secondary btn-sm py-2">
                                    View Details & Gallery
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-outline-dark btn-lg px-5 rounded-pill">
                Browse All Suites & Rates <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Facilities & Resort Experience -->
<section class="py-5">
    <div class="container py-4">
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <span class="text-warning text-uppercase letter-spacing-2 fw-bold small">Refined Facilities</span>
                <h2 class="display-5 font-serif fw-bold mt-1">World-Class Wellness & Leisure</h2>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="<?php echo e(route('facilities.index')); ?>" class="btn btn-outline-gold rounded-pill px-4">
                    Explore All Facilities <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="p-4 border rounded-3 bg-white h-100 shadow-sm d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="feature-icon-box">
                                <i class="bi <?php echo e($facility->icon ?? 'bi-gem'); ?>"></i>
                            </div>
                            <span class="badge bg-<?php echo e($facility->status_badge); ?> text-uppercase small">
                                <?php echo e(str_replace('_', ' ', $facility->status)); ?>

                            </span>
                        </div>
                        <h5 class="fw-bold text-dark font-serif mb-2"><?php echo e($facility->facility_name); ?></h5>
                        <p class="text-secondary small mb-3 flex-grow-1">
                            <?php echo e($facility->daily_maintenance_notes ?? 'Premium private facility reserved exclusively for hotel guests and VIP club members.'); ?>

                        </p>
                        <div class="pt-3 border-top small text-muted d-flex justify-content-between">
                            <span><i class="bi bi-clock me-1 text-warning"></i> <?php echo e($facility->operating_hours); ?></span>
                            <span><i class="bi bi-geo-alt me-1 text-warning"></i> <?php echo e($facility->location); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Guest Reviews Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-warning text-uppercase letter-spacing-2 fw-bold small">Guest Stories</span>
            <h2 class="display-5 font-serif fw-bold mt-1">Praised by Connoisseurs Worldwide</h2>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="card card-luxury p-4 h-100">
                        <div class="d-flex text-warning mb-3">
                            <?php for($i = 0; $i < $t['rating']; $i++): ?>
                                <i class="bi bi-star-fill me-1"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="text-secondary font-serif fst-italic mb-4 flex-grow-1">
                            "<?php echo e($t['quote']); ?>"
                        </p>
                        <div class="d-flex align-items-center gap-3 pt-3 border-top">
                            <img src="<?php echo e($t['avatar']); ?>" class="rounded-circle object-fit-cover" width="48" height="48" alt="<?php echo e($t['name']); ?>">
                            <div>
                                <h6 class="mb-0 fw-bold text-dark"><?php echo e($t['name']); ?></h6>
                                <small class="text-muted"><?php echo e($t['title']); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <span class="text-warning text-uppercase letter-spacing-2 fw-bold small">Book With Confidence</span>
        <h2 class="display-5 font-serif fw-bold text-white mt-1 mb-3">Your Unforgettable Escape Awaits</h2>
        <p class="lead text-white-50 max-w-700 mx-auto mb-4">
            Enjoy instant booking confirmations, transparent rates with zero hidden booking fees, and digital receipts generated instantly on checkout.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?php echo e(route('booking.create')); ?>" class="btn btn-gold btn-lg px-5 py-3 rounded-pill fw-bold">
                Reserve Your Suite Online
            </a>
            <a href="<?php echo e(route('booking.lookup')); ?>" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                Track Existing Booking
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/home.blade.php ENDPATH**/ ?>