<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard - Marketing</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <!-- WebFont -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"]
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- FIX MOBILE SIDEBAR -->
    <style>
        @media (max-width: 991px) {

            .sidebar {
                transform: translateX(-100%);
                transition: all 0.3s ease;
                position: fixed;
                z-index: 999;
                height: 100%;
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            body.sidebar-open::after {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.4);
                z-index: 998;
            }

            .main-panel {
                position: relative;
                z-index: 1;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        <div class="main-panel">

            {{-- Header --}}
            @include('layouts.header')

            {{-- Content --}}
            <div class="container">
                <div class="page-inner mt-4">
                    @yield('content')
                </div>
            </div>

        </div>

    </div>

    <!-- JS CORE (URUTAN WAJIB BENAR) -->
    <!-- 1. JQUERY DULU -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>

    <!-- 2. POPPER -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>

    <!-- 3. BOOTSTRAP -->
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- 4. PLUGIN SCROLLBAR (WAJIB kalau pakai kaiadmin) -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- 5. BARU KAIADMIN -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

    <!-- SIDEBAR TOGGLE FIX TANPA ERROR JQUERY -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const toggleButtons = document.querySelectorAll('.toggle-sidebar, .sidenav-toggler');

            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    document.body.classList.toggle('sidebar-open');
                });
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.sidebar') &&
                    !e.target.closest('.toggle-sidebar') &&
                    !e.target.closest('.sidenav-toggler')) {

                    document.body.classList.remove('sidebar-open');
                }
            });

        });
    </script>
    @stack('scripts')

</body>

</html>
