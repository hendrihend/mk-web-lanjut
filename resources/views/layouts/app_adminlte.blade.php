<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Marketing Users') - Admin Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    @vite(['resources/css/admin.css'])

    <style>
        :root {
            --app-bg: #f5f7fb;
            --app-border: #e5e7eb;
        }

        body {
            background-color: var(--app-bg);
        }

        .content-wrapper {
            background-color: var(--app-bg);
        }

        .brand-link {
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .sidebar-dark-primary .brand-link {
            background-color: #343a40;
        }

        .main-sidebar {
            box-shadow: 0 0 1.5rem rgba(0,0,0,.08);
        }

        .main-header {
            border-bottom: 1px solid var(--app-border);
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.025);
        }

        .main-footer {
            border-top: 1px solid var(--app-border);
            background-color: #fff;
        }

        .content-header {
            padding-bottom: 0.75rem;
        }

        .nav-sidebar .nav-link {
            border-radius: 0.75rem;
            margin: 0.15rem 0.4rem;
        }

        .nav-sidebar .nav-link:hover,
        .nav-sidebar .nav-link.active {
            background-color: rgba(255,255,255,.12);
        }

        @media (max-width: 768px) {
            .content-header h1 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('marketing-users.index') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <span class="brand-image img-circle elevation-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(255,255,255,.15);">
                    <i class="fas fa-chart-line"></i>
                </span>
                <span class="brand-text font-weight-light">Marketing Manager</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(255,255,255,.15); border-radius: 50%;">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Admin User</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Marketing Users -->
                        <li class="nav-item">
                            <a href="{{ route('marketing-users.index') }}" class="nav-link {{ request()->routeIs('marketing-users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Marketing Users
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>

                        <!-- User Sales -->
                        <li class="nav-item">
                            <a href="{{ route('user-sales.index') }}" class="nav-link {{ request()->routeIs('user-sales.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>User Sales</p>
                            </a>
                        </li>

                        <!-- Transactions -->
                        <li class="nav-item">
                            <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-exchange-alt"></i>
                                <p>Transactions</p>
                            </a>
                        </li>

                        <!-- Divider -->
                        <li class="nav-header">SETTINGS</li>

                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                        <!-- Logout -->
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2026 <a href="#">Marketing Users Management System</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @vite(['resources/js/admin.js'])

    @yield('scripts')
</body>

</html>