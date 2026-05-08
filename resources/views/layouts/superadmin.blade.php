<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin') - BorangDigital IPM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #0f4c81;
            --primary-light: #1a6bb5;
            --accent: #22c55e;
            --accent-light: #4ade80;
            --danger: #dc3545;
            --success: #28a745;
            --warning: #ffc107;
            --sidebar-width: 260px;
            --topbar-height: 60px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; color: #2d3748; }

        /* SIDEBAR */
        .sidebar {
            position: fixed; left: 0; top: 0; bottom: 0;
            width: var(--sidebar-width); background: var(--primary);
            display: flex; flex-direction: column; z-index: 100;
            box-shadow: 4px 0 15px rgba(0,0,0,0.15);
        }
        .sidebar-brand {
            padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-brand .brand-icon {
            width: 42px; height: 42px; background: var(--accent);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 18px; color: var(--primary);
        }
        .sidebar-brand .brand-text { color: white; }
        .sidebar-brand .brand-text h6 { font-size: 13px; font-weight: 700; margin: 0; }
        .sidebar-brand .brand-text small { font-size: 10px; opacity: 0.6; text-transform: uppercase; letter-spacing: 1px; }

        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }
        .nav-section-title {
            padding: 8px 20px; font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.5px;
            color: rgba(255,255,255,0.4); margin-top: 8px;
        }
        .nav-item a {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 20px; color: rgba(255,255,255,0.75);
            text-decoration: none; font-size: 13.5px; font-weight: 500;
            transition: all 0.2s; border-left: 3px solid transparent;
        }
        .nav-item a:hover, .nav-item a.active {
            background: rgba(255,255,255,0.1); color: white;
            border-left-color: var(--accent);
        }
        .nav-item a .nav-icon { width: 20px; text-align: center; font-size: 14px; }
        .nav-badge {
            margin-left: auto; background: var(--accent); color: var(--primary);
            font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px;
        }
        .sidebar-footer {
            padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1);
        }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .user-avatar {
            width: 36px; height: 36px; background: var(--accent);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-weight: 700; color: var(--primary); font-size: 14px;
        }
        .user-details h6 { color: white; font-size: 13px; font-weight: 600; margin: 0; }
        .user-details small { color: rgba(255,255,255,0.5); font-size: 11px; }
        .btn-logout {
            display: flex; align-items: center; gap: 8px; width: 100%;
            padding: 9px 14px; background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.75); border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px; font-size: 13px; cursor: pointer;
            text-decoration: none; transition: all 0.2s; justify-content: center;
        }
        .btn-logout:hover { background: var(--danger); color: white; border-color: var(--danger); }

        /* TOPBAR */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-width); right: 0;
            height: var(--topbar-height); background: white;
            display: flex; align-items: center; padding: 0 24px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.08); z-index: 99;
            justify-content: space-between;
        }
        .topbar-title h5 { font-size: 17px; font-weight: 700; color: var(--primary); margin: 0; }
        .topbar-title small { font-size: 12px; color: #718096; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .topbar-badge {
            background: var(--accent); color: var(--primary);
            padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 28px; min-height: calc(100vh - var(--topbar-height));
        }

        /* CARDS */
        .card {
            background: white; border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid #e8edf3; overflow: hidden;
        }
        .card-header {
            padding: 18px 22px; border-bottom: 1px solid #f0f4f8;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h6 { font-size: 15px; font-weight: 700; color: var(--primary); margin: 0; }
        .card-body { padding: 22px; }

        /* STAT CARDS */
        .stat-card {
            background: white; border-radius: 14px; padding: 20px 22px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #e8edf3;
            display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 22px;
            flex-shrink: 0;
        }
        .stat-icon.primary { background: #dbeafe; color: var(--primary); }
        .stat-icon.success { background: #d1fae5; color: #059669; }
        .stat-icon.warning { background: #fef3c7; color: #d97706; }
        .stat-icon.danger  { background: #fee2e2; color: #dc2626; }
        .stat-info h3 { font-size: 26px; font-weight: 800; color: var(--primary); margin: 0; }
        .stat-info p { font-size: 12px; color: #718096; margin: 2px 0 0; }

        /* TABLES */
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: #f8fafc; padding: 12px 16px;
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.5px; color: #64748b; border-bottom: 2px solid #e8edf3;
        }
        tbody td { padding: 13px 16px; font-size: 13.5px; border-bottom: 1px solid #f0f4f8; }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }

        /* BADGES */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-pending  { background: #fef3c7; color: #92400e; }
        .badge-approved, .badge-aktif { background: #d1fae5; color: #065f46; }
        .badge-rejected, .badge-ditolak { background: #fee2e2; color: #991b1b; }
        .badge-selesai  { background: #e2e8f0; color: #475569; }

        /* BUTTONS */
        .btn { padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none; transition: all 0.2s; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-light); color: white; }
        .btn-success { background: #059669; color: white; }
        .btn-success:hover { background: #047857; color: white; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; color: white; }
        .btn-warning { background: var(--accent); color: var(--primary); }
        .btn-warning:hover { background: var(--accent-light); color: var(--primary); }
        .btn-secondary { background: #e2e8f0; color: #475569; }
        .btn-secondary:hover { background: #cbd5e1; color: #334155; }
        .btn-outline { background: transparent; border: 1.5px solid var(--primary); color: var(--primary); }
        .btn-outline:hover { background: var(--primary); color: white; }

        /* ALERTS */
        .alert { padding: 14px 18px; border-radius: 10px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .alert-info    { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }

        /* FORMS & CHECKS */
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px; border: 1.5px solid #d1d5db;
            border-radius: 8px; font-size: 14px; transition: all 0.2s;
            outline: none; font-family: 'Inter', sans-serif;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(15,76,129,0.1); }
        .form-check-input { width: 1.2em; height: 1.2em; margin-top: 0.15em; vertical-align: top; background-color: #fff; background-repeat: no-repeat; background-position: center; background-size: contain; border: 1px solid #cbd5e1; border-radius: 0.25em; transition: background-color .15s ease-in-out,border-color .15s ease-in-out; cursor: pointer; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e"); }

        /* DROPDOWNS & TABS */
        .dropdown { position: relative; display: inline-block; }
        .dropdown-menu { display: none; position: absolute; background-color: #fff; min-width: 160px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px; border: 1px solid #e8edf3; z-index: 1000; padding: 8px 0; margin-top: 8px; }
        .dropdown-menu.show { display: block; }
        .dropdown-item { display: block; width: 100%; padding: 8px 16px; clear: both; font-weight: 500; color: #475569; text-align: inherit; text-decoration: none; white-space: nowrap; background-color: transparent; border: 0; font-size: 13.5px; transition: all 0.2s; }
        .dropdown-item:hover, .dropdown-item:focus { color: var(--primary); background-color: #f8fafc; }
        .dropdown-item.active { color: var(--primary); background-color: #f0f4f8; font-weight: 600; }
        .tab-content > .tab-pane { display: none; }
        .tab-content > .active { display: block; }
        .fade { transition: opacity 0.15s linear; }
        @media (prefers-reduced-motion: reduce) { .fade { transition: none; } }
        .fade:not(.show) { opacity: 0; }

        /* UTILS */
        .d-flex { display: flex; }
        .align-items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .mb-4 { margin-bottom: 24px; }
        .mb-3 { margin-bottom: 16px; }
        .text-muted { color: #718096; }
        .text-sm { font-size: 13px; }
        .fw-bold { font-weight: 700; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        @media (max-width: 1200px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .grid-4, .grid-2 { grid-template-columns: 1fr; } }
    </style>
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">SA</div>
            <div class="brand-text">
                <h6>BorangDigital</h6>
                <small>Super Admin Panel</small>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-title">Utama</div>
            <div class="nav-item">
                <a href="{{ route('superadmin.dashboard') }}" class="{{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i> Dashboard
                </a>
            </div>

            <div class="nav-section-title">Manajemen</div>
            <div class="nav-item">
                <a href="{{ route('superadmin.admin.index') }}" class="{{ request()->routeIs('superadmin.admin.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog nav-icon"></i> Kelola Admin
                    @php $pendingAdmin = \App\Models\User::where('role','admin')->where('status','pending')->count(); @endphp
                    @if($pendingAdmin > 0)
                        <span class="nav-badge">{{ $pendingAdmin }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('superadmin.pelatihan.index') }}" class="{{ request()->routeIs('superadmin.pelatihan.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher nav-icon"></i> Kelola Pelatihan
                    @php $pendingPelatihan = \App\Models\Pelatihan::where('status','pending')->count(); @endphp
                    @if($pendingPelatihan > 0)
                        <span class="nav-badge">{{ $pendingPelatihan }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('superadmin.user.index') }}" class="{{ request()->routeIs('superadmin.user.*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon"></i> Semua User
                </a>
            </div>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}</div>
                <div class="user-details">
                    <h6>{{ auth()->user()->name ?? 'Super Admin' }}</h6>
                    <small>Super Admin</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-title">
            <h5>@yield('page-title', 'Dashboard')</h5>
            <small>@yield('page-subtitle', 'Super Admin Control Panel')</small>
        </div>
        <div class="topbar-right">
            <span class="topbar-badge"><i class="fas fa-shield-alt"></i> Super Admin</span>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {!! session('success') !!}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
    @stack('js')
</body>
</html>
