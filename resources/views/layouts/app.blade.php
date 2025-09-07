<!DOCTYPE html>
<html lang="en" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title> {{ trans('global.site_title') . ' | Dashboard' }} </title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/public/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- RTL style -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
        class="adminlte-rtl-css" disabled>
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('/public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
        class="adminlte-rtl-css" disabled>
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"
        class="adminlte-rtl-css" disabled>
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/jqvmap/jqvmap.min.css') }}" class="adminlte-rtl-css"
        disabled>
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/daterangepicker/daterangepicker.css') }}"
        class="adminlte-rtl-css" disabled>
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('/public/plugins/summernote/summernote-bs4.css') }}" class="adminlte-rtl-css"
        disabled>
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" class="adminlte-rtl-css"
        disabled>
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{ asset('/public/dist/css/custom.css') }}" class="adminlte-rtl-css" disabled>
    <!-- CK Editor -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/styles.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .button-purple {
            color: #fff;
            background-color: {{ PRIMARY_COLOR_HEX }};
        }

        .switch {
            position: relative;
            display: inline-block;
            /* width: 60px;
                height: 34px; */
            width: 50px;
            height: 25px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            /* height: 26px;
            width: 26px; */
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: {{ PRIMARY_COLOR_HEX }};
        }

        input:focus+.slider {
            box-shadow: 0 0 1px {{ PRIMARY_COLOR_HEX }};
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        [class*=sidebar-light-] .nav-treeview>.nav-item>.nav-link.active,
        [class*=sidebar-light-] .nav-treeview>.nav-item>.nav-link.active:hover {
            color: #fff;
            background-color: {{ PRIMARY_COLOR_HEX }};
        }

        .nav-pills .nav-link.active {
            background-color: {{ PRIMARY_COLOR_HEX }};
        }

        [class*=sidebar-light-] .nav-sidebar>.nav-item>.nav-link.active {
            background-color: {{ PRIMARY_COLOR_HEX }};
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="{{ 'main-header navbar navbar-expand navbar-dark navbar-' . PRIMARY_COLOR }}">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <div style="display: flex; justify-content: flex-end;">
                <ul class="navbar-nav ml-auto">
                    <!-- Locale -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.changeLang') }}" id="toggleDirection">
                            <i class="fas fa-globe"></i>
                            <span class="badge badge-warning navbar-badge">{{ app()->getLocale() }}</span>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="{{ 'main-sidebar sidebar-light-' . PRIMARY_COLOR . '-primary elevation-4' }}">
            <!-- Brand Logo -->
            <a href="#" class="{{ 'brand-link navbar-' . PRIMARY_COLOR }}">
                <img src="{{ asset('/public/dist/img/waheej_logo.png') }}" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light text-white">{{ trans('global.site_title') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/public/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()?->full_name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                @include('layouts.menu')
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024 Waheej.</strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/public/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('/public/dist/js/demo.js') }}"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('/public/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('/public/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('/public/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('/public/plugins/jquery-mapael/maps/world_countries.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>

    <!-- PAGE SCRIPTS -->
    <script src="{{ asset('/public/dist/js/pages/dashboard2.js') }}"></script>

    <!-- RTL -->
    <script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" class="adminlte-rtl-css" disabled></script>
    <script src="{{ asset('/public/dist/js/pages/dashboard.js') }}" class="adminlte-rtl-css" disabled></script>
    <script>
        window.onload = function() {
            var html = document.documentElement;
            var adminlteRtlCss = document.getElementsByClassName('adminlte-rtl-css');
            if (html.getAttribute('dir') === 'ltr') {
                for (var i = 0; i < adminlteRtlCss.length; i++) {
                    adminlteRtlCss[i].disabled = true;
                }
            } else {
                for (var i = 0; i < adminlteRtlCss.length; i++) {
                    adminlteRtlCss[i].disabled = false;
                }
            }
        };
    </script>
    <script>
        document.getElementById('toggleDirection').addEventListener('click', function() {
            var html = document.documentElement;
            var adminlteRtlCss = document.getElementsByClassName('adminlte-rtl-css');

            if (html.getAttribute('dir') === 'ltr') {
                html.setAttribute('dir', 'rtl');
                for (var i = 0; i < adminlteRtlCss.length; i++) {
                    adminlteRtlCss[i].disabled = false;
                }
            } else {
                html.setAttribute('dir', 'ltr');
                for (var i = 0; i < adminlteRtlCss.length; i++) {
                    adminlteRtlCss[i].disabled = true;
                }
            }
        });
    </script>
</body>

</html>
