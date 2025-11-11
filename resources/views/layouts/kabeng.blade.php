<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Kabeng')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            height: 100vh;
            overflow: hidden;
        }

        #wrapper {
            display: flex;
            height: 100vh;
            transition: all 0.3s ease;
        }

        /* Sidebar */
        #sidebar-wrapper {
            min-width: 250px;
            max-width: 250px;
            background-color: #2e4053;
            color: #fff;
            border-radius: 0 15px 15px 0;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        #sidebar-wrapper .sidebar-heading {
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            padding: 1.5rem 0 0.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        #sidebar-wrapper .jurusan-text {
            text-align: center;
            font-size: 0.95rem;
            color: #a9cce3;
            margin-bottom: 1rem;
        }

        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            border: none;
            color: #ecf0f1;
            font-weight: 500;
            transition: all 0.2s;
            border-radius: 8px;
            margin: 4px 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #sidebar-wrapper .list-group-item:hover {
            background-color: #34495e;
            color: #fff;
            transform: translateX(5px);
        }

        /* Page Content */
        #page-content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Navbar */
        .navbar {
            border-radius: 0 0 15px 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            flex-shrink: 0;
        }

        /* Scrollable content */
        #main-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 12px 0;
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            font-size: 0.9rem;
            color: #6c757d;
            flex-shrink: 0;
        }

        /* Sidebar toggled */
        #wrapper.toggled #sidebar-wrapper {
            margin-left: -260px;
        }
    </style>
</head>
<body>

<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">SMKN 1 TALAGA</div>
        <div class="jurusan-text">
            {{ Auth::user()->jurusan ?? 'Jurusan Tidak Diketahui' }}
        </div>

        <div class="list-group list-group-flush">
            <a href="{{ route('kabeng.dashboard') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('kabeng.barang.index') }}"" class="list-group-item list-group-item-action">
                <i class="bi bi-box"></i> Data Barang Jurusan
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="bi bi-file-earmark-text"></i> Laporan Barang
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="bi bi-person-circle"></i> Profil
            </a>

            <!-- Logout -->
            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="list-group-item list-group-item-action text-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-2">
            <div class="container-fluid">
                <button class="btn btn-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>
                <h4 class="ms-3 mb-0">@yield('title')</h4>
            </div>
        </nav>

        <!-- Scrollable Content -->
        <div id="main-content">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer>
            &copy; {{ date('Y') }} SMKN 1 TALAGA - Sistem Inventori Barang. All rights reserved.
        </footer>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar Toggle -->
<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const wrapper = document.getElementById('wrapper');
    sidebarToggle.addEventListener('click', () => {
        wrapper.classList.toggle('toggled');
    });
</script>

</body>
</html>
