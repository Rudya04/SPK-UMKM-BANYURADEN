<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - UMKM Banyuraden</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <!-- Font Awesome untuk icon tambahan -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- Chart.js untuk grafik -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
        }

        /* Dark Mode Variables */
        .dark-mode {
            --bs-body-bg: #1a1a1a;
            --bs-body-color: #ffffff;
            --bs-light: #2d2d2d;
            --bs-border-color: #3d3d3d;
            --card-bg: #2d2d2d;
            --text-color: #ffffff;
            --primary-color: #2980b9;
        }

        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Modern Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--bs-light);
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--bs-border-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-color);
            color: white;
            font-weight: bold;
        }

        .sidebar.collapsed .sidebar-text {
            display: none;
        }

        .sidebar-nav {
            padding: 1rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            color: var(--bs-body-color);
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            background: var(--primary-color) !important;
            color: white !important;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .nav-link i {
            width: 24px;
            font-size: 1.2rem;
            margin-right: 0.8rem;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            padding: 0.8rem;
            justify-content: center;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        /* Content Area */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            background: var(--bs-body-bg);
        }

        .sidebar.collapsed + .content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Navbar */
        .top-navbar {
            background: var(--bs-light);
            padding: 1rem 2rem;
            margin: -2rem -2rem 2rem -2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 3rem;
            border-radius: 20px;
            border: 1px solid var(--bs-border-color);
            background: var(--bs-body-bg);
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        /* Modern Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: var(--card-bg, #ffffff);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card {
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::after {
            content: '';
            position: absolute;
            right: -40px;
            bottom: -40px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .dashboard-card i {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        /* Modern Buttons */
        .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }

        /* Modern Table */
        .table {
            color: var(--bs-body-color);
        }

        .table thead th {
            border-top: none;
            border-bottom: 2px solid var(--bs-border-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: rgba(52, 152, 219, 0.1);
        }

        /* Status Badges */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            background: var(--card-bg, #ffffff);
            border: 1px solid var(--bs-border-color);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            cursor: pointer;
        }

        .profile-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Notifications */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 350px;
        }

        /* Activity Feed */
        .activity-feed {
            list-style: none;
            padding: 0;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--bs-border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .activity-icon.success {
            background: #2ecc71;
        }

        .activity-icon.warning {
            background: #f39c12;
        }

        .activity-icon.danger {
            background: #e74c3c;
        }

        /* Mobile Responsiveness */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content-wrapper {
                margin-left: 0;
            }

            .sidebar.collapsed + .content-wrapper {
                margin-left: 0;
            }

            .top-navbar {
                padding: 1rem;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .search-box {
                width: 100%;
                order: 3;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bs-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
        }

        /* Full page loading overlay */
        #loading-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .table-wrapper {
            overflow-x: auto;
        }
    </style>
      <style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
      border-radius: 8px;
    }

    .section-title {
      font-weight: 600;
      margin-top: 2rem;
      color: #0d47a1;
    }

    .sub-title {
      font-weight: 500;
      margin-top: 1rem;
    }

    ul {
      padding-left: 1.2rem;
    }

    .note {
      background-color: #e3f2fd;
      padding: 1rem;
      border-left: 5px solid #0d47a1;
      border-radius: 4px;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

<!-- Loading overlay (TENGAH HALAMAN) -->
<div id="loading-overlay">
    <div class="text-center">
        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-2 fw-bold">Silakan tunggu...</div>
    </div>
</div>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-store"></i>
        </div>
        <span class="sidebar-text fw-bold h5 mb-0">SalesApp</span>
    </div>

    <div class="sidebar-nav">
        <ul class="nav flex-column">
            @role('admin')
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('criteria') }}" class="nav-link">
                    <i class="bi bi-app-indicator"></i>
                    <span>Kriteria</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sub-criteria') }}" class="nav-link">
                    <i class="bi bi-back"></i>
                    <span>Sub Kriteria</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('alternative') }}" class="nav-link">
                    <i class="bi bi-person-fill-down"></i>
                    <span>Alternatif</span>
                </a>
            </li>
            @endrole
            <li class="nav-item">
                <a href="{{ route('ranking') }}" class="nav-link">
                    <i class="bi bi-calculator"></i>
                    <span>Perangkingan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guide.index') }}" class="nav-link">
                    <i class="bi bi-journal-bookmark"></i>
                    <span>Panduan</span>
                </a>
            </li>
            @role('admin')
            <li class="nav-item">
                <a href="{{ route('ranking.flow') }}" class="nav-link">
                    <i class="bi bi-stack-overflow"></i>
                    <span>Alur Perankingan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">
                    <i class="bi bi-people-fill"></i>
                    <span>Pengguna</span>
                </a>
            </li>
            @endrole
        </ul>
    </div>
</nav>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Top Navbar -->
    <nav class="top-navbar">
        <button class="btn btn-light" id="sidebarToggle">
            {{--            <i class="fas fa-bars"></i>--}}
        </button>

        <div class="search-box">
            {{--            <i class="fas fa-search"></i>--}}
            {{--            <input type="text" class="form-control" placeholder="Cari apa saja...">--}}
        </div>

        <div class="d-flex align-items-center gap-3">

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <button class="profile-btn" data-bs-toggle="dropdown">
                    <span>{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down small"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@yield("script")
