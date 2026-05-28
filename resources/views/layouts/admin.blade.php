<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - BorangDigital IPM</title>
    
    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* === CORE VARIABLES (Elegant Palette) === */
        :root {
            --primary: #0f4c81;        
            --primary-dark: #0a365c;
            --primary-light: #eff6ff;
            --accent: #10b981;         
            
            --bg-body: #f8fafc;
            --bg-surface: #ffffff;
            
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            
            --sidebar-width: 280px;
            --topbar-height: 70px;
            
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.02);
            --shadow-md: 0 10px 30px -10px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        /* === RESET & BASE === */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: var(--bg-body); 
            color: var(--text-dark); 
            -webkit-font-smoothing: antialiased;
            letter-spacing: -0.01em;
        }

        /* === SIDEBAR (Luxury & Elegant) === */
        .sidebar {
            position: fixed; 
            left: 0; top: 0; bottom: 0;
            width: var(--sidebar-width); 
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex; flex-direction: column; 
            z-index: 1050;
            box-shadow: 4px 0 24px rgba(0,0,0,0.08);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-brand {
            padding: 24px 20px 20px; 
            display: flex; align-items: center; gap: 14px;
        }
        
        .sidebar-brand .brand-icon {
            width: 44px; height: 44px; 
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px; 
            display: flex; align-items: center; justify-content: center; 
            font-weight: 800; font-size: 18px; color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            flex-shrink: 0;
        }
        
        .sidebar-brand .brand-text {
            display: flex; flex-direction: column;
            overflow: hidden;
        }
        
        .sidebar-brand .brand-text h6 { 
            color: white; font-size: 15px; font-weight: 700; margin: 0; letter-spacing: 0.5px;
        }
        
        .sidebar-brand .brand-text .pimpinan {
            color: rgba(255,255,255,0.7); font-size: 12px; font-weight: 500; margin-top: 3px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .sidebar-nav { 
            flex: 1; padding: 12px 0; overflow-y: auto; 
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }

        .sidebar-nav .nav-section-title {
            padding: 12px 28px 8px; font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.4);
        }
        
        /* Elegant Menu Items */
        .sidebar-nav .nav-item {
            margin-bottom: 4px;
            padding: 0 16px;
        }

        .sidebar-nav .nav-item a {
            display: flex; align-items: center; gap: 14px;
            padding: 10px 14px; color: rgba(255,255,255,0.65);
            text-decoration: none; font-size: 13.5px; font-weight: 500;
            border-radius: var(--radius-md);
            transition: all 0.3s ease;
        }
        
        /* The Icon Box inside Nav Item */
        .sidebar-nav .nav-icon { 
            width: 32px; height: 32px; 
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 14px;
            background: rgba(255,255,255,0.03);
            color: rgba(255,255,255,0.7);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-item a:hover {
            color: rgba(255,255,255,0.95); 
            background: rgba(255,255,255,0.04);
        }
        .sidebar-nav .nav-item a:hover .nav-icon {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: scale(1.05);
        }
        
        .sidebar-nav .nav-item a.active {
            background: rgba(255,255,255,0.1); 
            color: white; 
            font-weight: 600;
            box-shadow: inset 3px 0 0 var(--accent);
        }
        .sidebar-nav .nav-item a.active .nav-icon {
            background: #ffffff;
            color: var(--primary);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transform: scale(1.05);
        }

        /* Sidebar Footer */
        .sidebar-footer { 
            padding: 20px 24px; 
            background: rgba(0,0,0,0.15); 
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        
        .user-info { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .user-avatar {
            width: 38px; height: 38px; 
            background: var(--bg-surface); color: var(--primary);
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            font-weight: 800; font-size: 15px; flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .user-details { overflow: hidden; }
        .user-details h6 { color: white; font-size: 13px; font-weight: 600; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-details small { color: rgba(255,255,255,0.5); font-size: 11px; font-weight: 500; }
        
        .btn-logout {
            display: flex; align-items: center; gap: 10px; width: 100%;
            padding: 10px 16px; background: transparent;
            color: #fca5a5; border: 1px solid rgba(248, 113, 113, 0.2);
            border-radius: var(--radius-md); font-size: 13px; font-weight: 600; cursor: pointer;
            justify-content: center; transition: all 0.2s ease;
        }
        .btn-logout:hover { 
            background: rgba(239, 68, 68, 0.1); 
            color: #f87171; 
            border-color: rgba(248, 113, 113, 0.4); 
        }

        /* === TOPBAR (Glassmorphism & Clean) === */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-width); right: 0;
            height: var(--topbar-height); 
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            display: flex; align-items: center; padding: 0 32px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            z-index: 99; justify-content: space-between;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .topbar-title { display: flex; align-items: center; gap: 16px; }
        .topbar-title-text h5 { font-size: 18px; font-weight: 700; color: var(--text-dark); margin: 0; letter-spacing: -0.5px; }
        .topbar-title-text small { font-size: 13px; color: var(--text-muted); font-weight: 500; }
        
        .topbar-badge {
            background: var(--bg-body); color: var(--primary);
            padding: 6px 14px; border-radius: 50rem; font-size: 12px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-sm);
        }

        /* === MAIN CONTENT === */
        .main-content {
            margin-left: var(--sidebar-width); 
            margin-top: var(--topbar-height);
            padding: 32px; 
            min-height: calc(100vh - var(--topbar-height));
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* === GLOBAL STYLES (Cards, Tables, Grids) === */
        .card { 
            background: var(--bg-surface); 
            border-radius: var(--radius-lg); 
            box-shadow: var(--shadow-md); 
            border: 1px solid rgba(226, 232, 240, 0.8); 
            margin-bottom: 24px;
            overflow: hidden; 
        }
        .card-header { 
            padding: 20px 24px; 
            border-bottom: 1px solid rgba(241, 245, 249, 1); 
            display: flex; align-items: center; justify-content: space-between; 
            background: transparent;
        }
        .card-header h6 { font-size: 16px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .card-body { padding: 24px; }

        /* Dashboard Stat Cards */
        .stat-card { 
            background: white; border-radius: var(--radius-lg); padding: 24px; 
            box-shadow: var(--shadow-md); border: 1px solid rgba(226, 232, 240, 0.8); 
            display: flex; align-items: center; gap: 20px; margin-bottom: 0; 
            transition: transform 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
        .stat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
        .stat-icon.primary { background: var(--primary-light); color: var(--primary); }
        .stat-icon.success { background: #d1fae5; color: #059669; }
        .stat-icon.warning { background: #fef3c7; color: #d97706; }
        .stat-icon.danger  { background: #fee2e2; color: #dc2626; }
        .stat-info h3 { font-size: 26px; font-weight: 800; color: var(--text-dark); margin: 0; line-height: 1.2; }
        .stat-info p { font-size: 13px; color: var(--text-muted); margin: 2px 0 0; font-weight: 500; }

        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 32px; }

        /* Badges */
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; letter-spacing: 0.5px; text-transform: uppercase; }
        .badge-pending  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-approved, .badge-aktif { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-rejected, .badge-ditolak { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-selesai  { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        /* Global Tables */
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-light);
            background-color: #fff;
        }
        .table-container > table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        .table-container > table > thead th { 
            background: #f8fafc; padding: 14px 20px; font-size: 11.5px; 
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; 
            color: var(--text-muted); border-bottom: 1px solid var(--border-light); 
            white-space: nowrap; vertical-align: middle;
        }
        .table-container > table > tbody td { 
            padding: 14px 20px; font-size: 14px; font-weight: 500;
            border-bottom: 1px solid #f1f5f9; color: var(--text-dark);
            vertical-align: middle;
        }
        .table-container > table > tbody tr:hover td { background: #f8fafc; }
        .table-container > table > tbody td input[type="checkbox"].form-check-input {
            margin: 0 auto; display: block; width: 20px; height: 20px;
        }

        /* ========================================================================= */
        /* FIX OVERLAPPING ISSUE ON MOBILE (FORCE DISABLE STICKY COLUMNS GLOBALLY)   */
        /* ========================================================================= */
        @media (max-width: 768px) {
            html body main.main-content .table-container table th:nth-child(n),
            html body main.main-content .table-container table td:nth-child(n),
            html body main.main-content .table-responsive table th:nth-child(n),
            html body main.main-content .table-responsive table td:nth-child(n) {
                position: static !important; 
                left: auto !important;
                right: auto !important;
                box-shadow: none !important;
                z-index: 0 !important;
                white-space: nowrap !important;
            }
            .table-container, .table-responsive {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
                border: 0 !important;
                padding-bottom: 10px;
            }
        }

        /* Global Buttons */
        .main-content .btn { 
            padding: 10px 18px; border-radius: 8px; font-size: 13.5px; font-weight: 600; 
            display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; 
            border: 1px solid transparent; cursor: pointer; text-decoration: none;
        }
        .main-content .btn-sm { padding: 6px 14px; font-size: 12px; }
        .main-content .btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 10px rgba(15, 76, 129, 0.2); }
        .main-content .btn-primary:hover { background: var(--primary-light); transform: translateY(-1px); box-shadow: 0 6px 14px rgba(15, 76, 129, 0.3); }
        .main-content .btn-success { background: #10b981; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); }
        .main-content .btn-success:hover { background: #059669; transform: translateY(-1px); }
        .main-content .btn-danger { background: #ef4444; color: white; }
        .main-content .btn-danger:hover { background: #dc2626; }
        .main-content .btn-warning { background: #f59e0b; color: white; }
        .main-content .btn-secondary { background: var(--border-light); color: var(--text-dark); }
        .main-content .btn-secondary:hover { background: #cbd5e1; }
        .main-content .btn-outline { background: transparent; border: 1.5px solid var(--primary); color: var(--primary); }
        .main-content .btn-outline:hover { background: var(--primary); color: white; }

        /* Forms & Checks */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; }
        .form-control { 
            width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; 
            border-radius: 10px; font-size: 14px; transition: all 0.2s; outline: none; 
            font-family: 'Inter', sans-serif; background: #f8fafc; color: var(--text-dark);
        }
        .form-control:focus { border-color: var(--primary); background: #ffffff; box-shadow: 0 0 0 4px rgba(15,76,129,0.1); }
        
        /* Dropdowns */
        .dropdown { position: relative; display: inline-block; }
        .dropdown-menu { display: none; position: absolute; background-color: #fff; min-width: 180px; box-shadow: var(--shadow-lg); border-radius: var(--radius-md); border: 1px solid var(--border-light); z-index: 1000; padding: 8px 0; margin-top: 8px; }
        .dropdown-menu.show { display: block; animation: slideDown 0.2s ease; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .dropdown-item { display: block; width: 100%; padding: 10px 20px; font-weight: 500; color: var(--text-dark); text-decoration: none; font-size: 13.5px; transition: all 0.2s; }
        .dropdown-item:hover { color: var(--primary); background-color: #f1f5f9; }
        .dropdown-item.active { color: var(--primary); background-color: var(--primary-light); font-weight: 600; }
        
        .tab-content > .tab-pane { display: none; }
        .tab-content > .active { display: block; }
        .fade { transition: opacity 0.15s linear; }
        .fade:not(.show) { opacity: 0; }

        /* Alerts */
        .alert { 
            padding: 16px 20px; border-radius: var(--radius-md); font-size: 14px; font-weight: 500;
            margin-bottom: 24px; display: flex; align-items: center; gap: 12px; border: 1px solid transparent;
            box-shadow: var(--shadow-sm);
        }
        .alert i { font-size: 18px; }
        .alert-success { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        .alert-danger  { background: #fef2f2; color: #991b1b; border-color: #fca5a5; }
        .alert-warning { background: #fffbeb; color: #92400e; border-color: #fcd34d; }
        .alert-info    { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }

        /* Utils */
        .d-flex { display: flex; }
        .align-items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .mb-4 { margin-bottom: 24px; }
        .mb-3 { margin-bottom: 16px; }
        .text-muted { color: var(--text-muted); }
        .text-sm { font-size: 13px; }
        .fw-bold { font-weight: 700; }

        /* === RESPONSIVE MOBILE === */
        .sidebar-overlay { 
            display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); 
            backdrop-filter: blur(2px); z-index: 1040; opacity: 0; transition: opacity 0.3s ease; 
        }
        .sidebar-overlay.active { display: block; opacity: 1; }
        
        .mobile-menu-btn { 
            display: none; background: transparent; border: none; color: var(--text-dark); 
            font-size: 22px; cursor: pointer; padding: 6px; border-radius: 8px; transition: background 0.2s;
        }
        .mobile-menu-btn:active { background: #f1f5f9; }

        @media (max-width: 1200px) {
            .grid-4 { grid-template-columns: repeat(2, 1fr); } 
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .main-content { padding: 24px; }
        }

        @media (max-width: 768px) { 
            .grid-4, .grid-3, .grid-2 { grid-template-columns: 1fr; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            
            .topbar { left: 0; padding: 0 16px; }
            .main-content { margin-left: 0; padding: 16px; margin-top: var(--topbar-height); }
            
            .mobile-menu-btn { display: flex; align-items: center; justify-content: center; }
            
            .topbar-title-text h5 { font-size: 16px; }
            .topbar-title-text small { display: none; }
            
            .topbar-badge span { display: none; }
            .topbar-badge { padding: 8px; border-radius: 50%; box-shadow: none; border: none; background: transparent; color: var(--text-muted); }
            .topbar-badge i { margin: 0; font-size: 18px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
            <div class="brand-text">
                <h6>BorangDigital</h6>
                <div class="pimpinan">{{ auth()->user()->nama_pimpinan ?? 'Admin Panel' }}</div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section-title">Utama</div>
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
                </a>
            </div>

            <div class="nav-section-title">Pelatihan</div>
            <div class="nav-item">
                <a href="{{ route('pelatihan.index') }}" class="{{ request()->routeIs('pelatihan.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></div> Daftar Pelatihan
                </a>
            </div>

            <div class="nav-section-title">Borang</div>
            <div class="nav-item">
                <a href="{{ route('keaktifan.index') }}" class="{{ request()->routeIs('keaktifan.index') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-clipboard-list"></i></div> Observasi Materi
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('observasiPendalaman.index') }}" class="{{ str_contains(request()->url(), 'observasiPendalaman') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-search"></i></div> Pendalaman
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('observasiImamahKajian.index') }}" class="{{ str_contains(request()->url(), 'observasiImamahKajian') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-mosque"></i></div> Imamah
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('observasigames.index') }}" class="{{ str_contains(request()->url(), 'observasigames') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-gamepad"></i></div> Games
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('hafalan.index') }}" class="{{ request()->routeIs('hafalan.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-book-open"></i></div> Hafalan
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('notulensi.index') }}" class="{{ request()->routeIs('notulensi.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-file-alt"></i></div> Notulensi
                </a>
            </div>

            <div class="nav-section-title">Manajemen</div>
            <div class="nav-item">
                <a href="{{ route('peserta.index') }}" class="{{ request()->routeIs('peserta.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-users"></i></div> Data Peserta
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('rekapitulasi.index') }}" class="{{ str_contains(request()->url(), 'rekapitulasi') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-chart-bar"></i></div> Rekapitulasi
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.subrole.index') }}" class="{{ request()->routeIs('admin.subrole.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-user-tag"></i></div> Tim Penilai
                </a>
            </div>
        </nav>
        
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->nama_pimpinan ?? 'A', 0, 1)) }}</div>
                <div class="user-details">
                    <h6>{{ auth()->user()->nama_pimpinan ?? auth()->user()->name }}</h6>
                    <small>{{ auth()->user()->tingkat_pimpinan ?? 'Administrator' }}</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-title">
            <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i></button>
            <div class="topbar-title-text">
                <h5>@yield('page-title', 'Dashboard')</h5>
                <small>@yield('page-subtitle', 'Sistem Informasi Borang')</small>
            </div>
        </div>
        <div class="topbar-badge">
            <i class="fas fa-shield-alt"></i> <span>Akses Admin</span>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> 
                <div>{!! session('success') !!}</div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> 
                <div>{{ session('error') }}</div>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> 
                <div>{{ session('warning') }}</div>
            </div>
        @endif

        @yield('content')
    </main>
    
    <!-- Scripts -->
    @stack('scripts')
    @stack('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            }

            if(mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleSidebar);
            if(overlay) overlay.addEventListener('click', toggleSidebar);
            
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768 && sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>