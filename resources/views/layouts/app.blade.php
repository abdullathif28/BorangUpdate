<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>Borang Digital Jateng</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap 5 bundle (sudah termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Theme Overrides to Match Login & Admin -->
    <style>
        :root {
            --bs-primary: #0f4c81;
            --bs-primary-rgb: 15, 76, 129;
            --bs-success: #22c55e;
            --bs-success-rgb: 34, 197, 94;
        }
        .bg-primary { background-color: #0f4c81 !important; }
        .text-primary { color: #0f4c81 !important; }
        .btn-primary { background-color: #0f4c81 !important; border-color: #0f4c81 !important; }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active { background-color: #0c3e6a !important; border-color: #0c3e6a !important; }
        .btn-outline-primary { color: #0f4c81 !important; border-color: #0f4c81 !important; }
        .btn-outline-primary:hover { background-color: #0f4c81 !important; color: #fff !important; }

        .bg-success { background-color: #22c55e !important; }
        .text-success { color: #22c55e !important; }
        .btn-success { background-color: #22c55e !important; border-color: #22c55e !important; }
        .btn-success:hover, .btn-success:focus, .btn-success:active { background-color: #1ca34d !important; border-color: #1ca34d !important; }
        .btn-outline-success { color: #22c55e !important; border-color: #22c55e !important; }
        .btn-outline-success:hover { background-color: #22c55e !important; color: #fff !important; }
        
        .nav-link.active { color: #0f4c81 !important; font-weight: 700; }
        
        /* Sidebar active styling */
        .sidenav .nav-link.active { background-color: rgba(15, 76, 129, 0.1) !important; }
        .sidenav .nav-link.active .icon-shape, .sidenav .nav-link.active i {
            background-color: #0f4c81 !important; color: white !important;
        }
    </style>
</head>

<body class="{{ $class ?? '' }}">

    @guest
        @yield('content')
    @endguest

    @auth
        @if (in_array(request()->route()->getName(), [
            'sign-in-static',
            'sign-up-static',
            'login',
            'register',
            'recover-password',
            'rtl',
            'virtual-reality'
        ]))
            @yield('content')
        @else
            @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
                <div class="min-height-300 bg-primary position-absolute w-100"></div>
            @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
                <div class="position-absolute w-100 min-height-300 top-0"
                     style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
                    <span class="mask bg-primary opacity-6"></span>
                </div>
            @endif

            @include('layouts.navbars.auth.sidenav')

            <main class="main-content border-radius-lg">
                @yield('content')
            </main>

            @include('components.fixed-plugin')
        @endif
    @endauth

    <!-- Plugin tambahan -->
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="assets/js/argon-dashboard.js"></script>

    <script>
        // scrollbar
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = { damping: '0.5' }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

        // dark mode
        document.addEventListener("DOMContentLoaded", function() {
            const savedTheme = localStorage.getItem("theme");
            const themeToggle = document.querySelector(".dark-mode-toggle");
            const sidenav = document.querySelector('.sidenav');

            if (savedTheme === "dark") {
                document.body.classList.add("dark-version");
                if (themeToggle) themeToggle.checked = true;
                if (sidenav) sidenav.classList.add("dark-version");
            } else {
                document.body.classList.remove("dark-version");
                if (themeToggle) themeToggle.checked = false;
                if (sidenav) sidenav.classList.remove("dark-version");
            }
        });

        function toggleTheme(el) {
            const body = document.body;
            const sidenav = document.querySelector('.sidenav');
            if (el.checked) {
                body.classList.add("dark-version");
                if (sidenav) sidenav.classList.add("dark-version");
                localStorage.setItem("theme", "dark");
            } else {
                body.classList.remove("dark-version");
                if (sidenav) sidenav.classList.remove("dark-version");
                localStorage.setItem("theme", "light");
            }
        }
    </script>

    @stack('js')
</body>
</html>
