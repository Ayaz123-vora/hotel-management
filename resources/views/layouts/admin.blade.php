<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin & Front Desk Portal') - Grand Horizon Hotel</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #334155;
            --gold-accent: #c5a880;
            --main-bg: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--main-bg);
            color: #1e293b;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            border-right: 1px solid #1e293b;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .admin-sidebar .brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid #1e293b;
        }

        .admin-sidebar .nav-link {
            color: #94a3b8;
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            border-radius: 8px;
            margin: 0.2rem 0.75rem;
            transition: all 0.2s;
        }

        .admin-sidebar .nav-link i {
            font-size: 1.15rem;
            margin-right: 0.85rem;
            width: 22px;
            text-align: center;
        }

        .admin-sidebar .nav-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
        }

        .admin-sidebar .nav-link.active {
            color: #ffffff;
            background-color: var(--sidebar-active);
            border-left: 3px solid var(--gold-accent);
            font-weight: 600;
        }

        .sidebar-heading {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            padding: 1rem 1.25rem 0.35rem;
            font-weight: 700;
        }

        /* Main Content wrapper */
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Header */
        .admin-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        /* Stat KPI cards */
        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* Room status chips */
        .room-chip {
            padding: 0.85rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .room-chip:hover {
            transform: scale(1.03);
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                margin-left: -260px;
            }
            .admin-sidebar.show {
                margin-left: 0;
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="brand">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-warning text-dark p-2 rounded-3 fs-5 fw-bold lh-1">GH</div>
                <div>
                    <h6 class="text-white mb-0 fw-bold letter-spacing-1">GRAND HORIZON</h6>
                    <small class="text-secondary" style="font-size: 0.7rem;">MANAGEMENT PORTAL</small>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="sidebar-heading">Front Desk & Core</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Executive Dashboard
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Reservations & Front Desk
            </a>
            <a href="{{ route('admin.reservations.create') }}" class="nav-link text-warning">
                <i class="bi bi-person-plus"></i> Walk-In Check-In
            </a>

            <div class="sidebar-heading">Inventory & Ops</div>
            <a href="{{ route('admin.rooms.index') }}" class="nav-link {{ request()->routeIs('admin.rooms.index') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i> Room Matrix & Status
            </a>
            <a href="{{ route('admin.rooms.types') }}" class="nav-link {{ request()->routeIs('admin.rooms.types') ? 'active' : '' }}">
                <i class="bi bi-door-open"></i> Room Suites & Pricing
            </a>
            <a href="{{ route('admin.housekeeping.index') }}" class="nav-link {{ request()->routeIs('admin.housekeeping.*') ? 'active' : '' }}">
                <i class="bi bi-brush"></i> Housekeeping Board
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="nav-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
                <i class="bi bi-water"></i> Facility Operations
            </a>

            <div class="sidebar-heading">Customers & Finance</div>
            <a href="{{ route('admin.guests.index') }}" class="nav-link {{ request()->routeIs('admin.guests.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Guest Directory (CRM)
            </a>
            <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> Financial Ledger
            </a>

            <div class="sidebar-heading">System & Navigation</div>
            <a href="{{ route('home') }}" target="_blank" class="nav-link">
                <i class="bi bi-globe"></i> View Public Website
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="mt-3 px-3">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill">
                    <i class="bi bi-box-arrow-right me-1"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Section -->
    <div class="admin-main">
        <!-- Top Header -->
        <header class="admin-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-sm-block">
                    <span class="text-secondary small"><i class="bi bi-clock me-1"></i> {{ date('l, F j, Y') }} &bull; Hotel Time: {{ date('h:i A') }}</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill small">
                    <i class="bi bi-database-check me-1"></i> MySQL Connected
                </span>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm border dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-6 text-primary"></i>
                        <span class="fw-semibold">{{ Auth::user()->name ?? 'Staff User' }}</span>
                        <span class="badge bg-dark small">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><h6 class="dropdown-header">Signed in as {{ Auth::user()->email ?? '' }}</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank"><i class="bi bi-globe me-2"></i> Visit Website</a></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="container-fluid px-4 mt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="bi bi-info-circle-fill me-2 fs-5 align-middle"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <div class="container-fluid px-4 py-3 flex-grow-1">
            @yield('content')
        </div>

        <!-- Admin Footer -->
        <footer class="bg-white border-top py-3 px-4 text-secondary small text-center text-md-start d-flex justify-content-between align-items-center">
            <span>&copy; {{ date('Y') }} Grand Horizon Luxury Hotel Management System &bull; Laravel MVC & MySQL</span>
            <span class="d-none d-md-inline text-muted">Running on XAMPP Windows Server</span>
        </footer>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.toggle('show');
        });
    </script>
    @yield('scripts')
</body>
</html>
