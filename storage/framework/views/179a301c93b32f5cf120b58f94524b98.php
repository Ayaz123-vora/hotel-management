<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Grand Horizon Luxury Hotel & Suites'); ?></title>
    <!-- Google Fonts: Playfair Display & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --hotel-navy: #0b132b;
            --hotel-deep-blue: #1c2541;
            --hotel-gold: #c5a880;
            --hotel-gold-hover: #b09164;
            --hotel-cream: #faf8f5;
            --hotel-dark: #121824;
            --hotel-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #334155;
            background-color: #fdfdfd;
        }

        h1, h2, h3, h4, h5, .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* Navbar */
        .navbar-luxury {
            background-color: rgba(11, 19, 43, 0.96);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(197, 168, 128, 0.25);
            transition: all 0.3s ease;
        }

        .navbar-brand .hotel-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            letter-spacing: 1.5px;
            color: #ffffff;
            font-weight: 700;
        }

        .navbar-brand .hotel-subtitle {
            font-size: 0.65rem;
            letter-spacing: 3px;
            color: var(--hotel-gold);
            text-transform: uppercase;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.82) !important;
            transition: color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--hotel-gold) !important;
        }

        /* Gold Button */
        .btn-gold {
            background-color: var(--hotel-gold);
            color: #0b132b;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: 1px solid var(--hotel-gold);
            transition: all 0.25s ease;
        }

        .btn-gold:hover {
            background-color: var(--hotel-gold-hover);
            border-color: var(--hotel-gold-hover);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(197, 168, 128, 0.3);
        }

        .btn-outline-gold {
            background-color: transparent;
            color: var(--hotel-gold);
            border: 1px solid var(--hotel-gold);
            font-weight: 600;
        }

        .btn-outline-gold:hover {
            background-color: var(--hotel-gold);
            color: #0b132b;
        }

        /* Luxury Card */
        .card-luxury {
            border: 1px solid rgba(0, 0, 0, 0.07);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffff;
        }

        .card-luxury:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px rgba(11, 19, 43, 0.1);
        }

        /* Badges */
        .badge-gold {
            background-color: rgba(197, 168, 128, 0.15);
            color: #936f38;
            border: 1px solid rgba(197, 168, 128, 0.4);
            font-weight: 600;
            padding: 0.35rem 0.65rem;
            border-radius: 30px;
        }

        /* Footer */
        .footer-luxury {
            background-color: var(--hotel-navy);
            color: #cbd5e1;
            border-top: 2px solid var(--hotel-gold);
        }

        .footer-luxury a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-luxury a:hover {
            color: var(--hotel-gold);
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Top Luxury Bar -->
    <div class="bg-black text-white-50 py-1 border-bottom border-dark small">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="me-3"><i class="bi bi-geo-alt text-warning me-1"></i> Oceanview Boulevard 500, Waterfront District</span>
                <span class="d-none d-md-inline"><i class="bi bi-telephone text-warning me-1"></i> Concierge: +1 (800) 472-6346</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo e(route('booking.lookup')); ?>" class="text-white-50 text-decoration-none hover-gold">
                    <i class="bi bi-search me-1"></i> Find My Reservation
                </a>
                <span class="text-secondary">|</span>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="badge bg-warning text-dark text-decoration-none">
                        <i class="bi bi-speedometer2 me-1"></i> Staff Portal
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('admin.login')); ?>" class="text-white-50 text-decoration-none">
                        <i class="bi bi-lock me-1"></i> Staff Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-luxury sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex flex-column" href="<?php echo e(route('home')); ?>">
                <span class="hotel-title">GRAND HORIZON</span>
                <span class="hotel-subtitle">LUXURY HOTEL & RESIDENCES</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hotelNav" aria-controls="hotelNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="hotelNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('rooms.*') ? 'active' : ''); ?>" href="<?php echo e(route('rooms.index')); ?>">Suites & Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('facilities.*') ? 'active' : ''); ?>" href="<?php echo e(route('facilities.index')); ?>">Facilities & Spa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('booking.lookup') ? 'active' : ''); ?>" href="<?php echo e(route('booking.lookup')); ?>">My Booking</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-gold px-4 py-2 rounded-pill shadow-sm" href="<?php echo e(route('booking.create')); ?>">
                            <i class="bi bi-calendar-check me-1"></i> Reserve Now
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Global Alert Messages -->
    <div class="container mt-3">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session('info')): ?>
            <div class="alert alert-info alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-info-circle-fill me-2 fs-5 align-middle"></i>
                <?php echo e(session('info')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-x-circle-fill me-2 fs-5 align-middle"></i>
                <strong>Please verify your input:</strong>
                <ul class="mb-0 mt-1 small">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main Body Content -->
    <main class="flex-grow-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="footer-luxury pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <h4 class="text-white mb-2 font-serif">GRAND HORIZON</h4>
                    <p class="text-warning small text-uppercase letter-spacing-2 mb-3">5-Star Luxury Beachfront Resort</p>
                    <p class="small text-secondary mb-4">
                        A sanctuary of timeless grandeur, refined comfort, and bespoke hospitality. Offering world-class oceanfront suites, Michelin-standard dining, and holistic wellness experiences.
                    </p>
                    <div class="d-flex gap-3 fs-5 text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <span class="text-white small ms-2">Forbes 5-Star Certified</span>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="text-white text-uppercase letter-spacing-1 mb-3 small">Quick Links</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li><a href="<?php echo e(route('rooms.index')); ?>">Suites & Villas</a></li>
                        <li><a href="<?php echo e(route('facilities.index')); ?>">Spa & Wellness</a></li>
                        <li><a href="<?php echo e(route('booking.create')); ?>">Online Booking</a></li>
                        <li><a href="<?php echo e(route('booking.lookup')); ?>">Track Reservation</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6">
                    <h6 class="text-white text-uppercase letter-spacing-1 mb-3 small">Hotel Amenities</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 text-secondary">
                        <li><i class="bi bi-check2 text-warning me-2"></i> Infinity Sky Pool & Cabanas</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i> Thermal Spa & Aromatherapy</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i> 24/7 Executive Butler Service</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i> Chauffeur Limousine Fleet</li>
                        <li><i class="bi bi-check2 text-warning me-2"></i> High-Speed Wi-Fi 6</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white text-uppercase letter-spacing-1 mb-3 small">Contact & Concierge</h6>
                    <p class="small text-secondary mb-2">
                        <i class="bi bi-geo-alt-fill text-warning me-2"></i> 500 Oceanview Blvd, Marina Bay
                    </p>
                    <p class="small text-secondary mb-2">
                        <i class="bi bi-telephone-fill text-warning me-2"></i> +1 (800) 472-6346 (Toll-Free)
                    </p>
                    <p class="small text-secondary mb-3">
                        <i class="bi bi-envelope-fill text-warning me-2"></i> reservations@grandhorizonhotel.com
                    </p>
                    <div class="p-3 rounded bg-dark border border-secondary text-secondary small">
                        <strong class="text-white">Check-in:</strong> 3:00 PM <br>
                        <strong class="text-white">Check-out:</strong> 11:00 AM
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-secondary">
                <p class="mb-2 mb-md-0">&copy; <?php echo e(date('Y')); ?> Grand Horizon Luxury Hotel. Built with Laravel MVC, MySQL & XAMPP.</p>
                <div>
                    <a href="<?php echo e(route('admin.login')); ?>" class="text-warning text-decoration-none">Staff Access Portal</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/layouts/app.blade.php ENDPATH**/ ?>