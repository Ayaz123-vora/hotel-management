<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal Login - Grand Horizon Hotel</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0b132b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            max-width: 440px;
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(197, 168, 128, 0.4);
            overflow: hidden;
        }

        .btn-gold {
            background-color: #c5a880;
            color: #0b132b;
            font-weight: 600;
            border: none;
        }

        .btn-gold:hover {
            background-color: #b09164;
            color: #ffffff;
        }
    </style>
</head>
<body class="p-3">

    <div class="login-card">
        <!-- Top Banner -->
        <div class="bg-dark text-white p-4 text-center border-bottom border-warning">
            <div class="badge bg-warning text-dark px-3 py-1 rounded-pill small mb-2 fw-bold">Grand Horizon Staff Portal</div>
            <h3 class="font-serif fw-bold text-white mb-1" style="font-family: 'Playfair Display', serif;">Management Login</h3>
            <p class="text-white-50 small mb-0">Front Desk & Hotel Operations Command Center</p>
        </div>

        <div class="p-4 p-md-5">
            <?php if(session('info')): ?>
                <div class="alert alert-info py-2 small border-0"><?php echo e(session('info')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger py-2 small border-0">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($err); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.login.post')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary text-uppercase">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person text-warning"></i></span>
                        <input type="email" name="email" id="loginEmail" class="form-control" placeholder="admin@hotel.com" value="<?php echo e(old('email', 'admin@hotel.com')); ?>" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary text-uppercase">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-lock text-warning"></i></span>
                        <input type="password" name="password" id="loginPassword" class="form-control" placeholder="••••••••" value="password123" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 small">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                        <label class="form-check-label text-secondary" for="remember">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold btn-lg w-100 py-3 rounded-pill fw-bold shadow-sm mb-4">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Portal
                </button>
            </form>

            <!-- Quick Fill Demo Accounts -->
            <div class="p-3 bg-light rounded-3 border small">
                <span class="text-muted fw-bold d-block mb-2 text-uppercase" style="font-size: 0.72rem;">Quick Fill Demo Staff Roles:</span>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-sm btn-outline-dark" onclick="fillCreds('admin@hotel.com')">
                        <i class="bi bi-shield-check"></i> Admin
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" onclick="fillCreds('reception@hotel.com')">
                        <i class="bi bi-person-badge"></i> Receptionist
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" onclick="fillCreds('housekeeping@hotel.com')">
                        <i class="bi bi-brush"></i> Housekeeper
                    </button>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?php echo e(route('home')); ?>" class="text-secondary small text-decoration-none">
                    &larr; Back to Guest Website
                </a>
            </div>
        </div>
    </div>

    <script>
        function fillCreds(email) {
            document.getElementById('loginEmail').value = email;
            document.getElementById('loginPassword').value = 'password123';
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>