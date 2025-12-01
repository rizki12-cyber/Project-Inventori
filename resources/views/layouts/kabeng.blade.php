<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard Kabeng')</title>

<link rel="icon" href="{{ asset($pengaturan->favicon ?? 'assets/images/logo1.png') }}" type="image/png" sizes="32x32">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary-color: #4285f4;
    --sidebar-bg: #ffffff;
    --sidebar-text: #2c3e50;
    --sidebar-hover: #f3f6fa;
    --sidebar-active-bg: #e8f0fe;
    --sidebar-active-border: var(--primary-color);
    --transition: all 0.3s ease;
}

body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    height: 100vh;
    background-color: #f8f9fa;
}

#wrapper {
    display: flex;
    height: 100vh;
    transition: var(--transition);
}

/* Sidebar */
#sidebar-wrapper {
    min-width: 250px;
    max-width: 250px;
    background-color: var(--sidebar-bg);
    color: var(--sidebar-text);
    border-right: 1px solid #e5e7eb;
    box-shadow: 4px 0 15px rgba(0,0,0,0.03);
    display: flex;
    flex-direction: column;
    padding-bottom: 20px;
    overflow-y: auto;
}

#sidebar-wrapper .sidebar-heading {
    font-size: 1.4rem;
    font-weight: 700;
    text-align: center;
    padding: 1.2rem 0;
    border-bottom: 1px solid #f0f0f0;
    color: var(--primary-color);
    letter-spacing: 0.5px;
}

#sidebar-wrapper .jurusan-text {
    text-align: center;
    font-size: 0.9rem;
    color: #607d8b;
    margin-top: 4px;
}

#sidebar-wrapper .list-group-item {
    background-color: transparent;
    border: none;
    color: var(--sidebar-text);
    font-weight: 500;
    transition: var(--transition);
    border-radius: 10px;
    margin: 6px 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
}

#sidebar-wrapper .list-group-item:hover {
    background-color: var(--sidebar-hover);
    transform: translateX(3px);
}

#sidebar-wrapper .list-group-item.active {
    background-color: var(--sidebar-active-bg);
    border-left: 4px solid var(--sidebar-active-border);
    color: var(--sidebar-active-border);
    font-weight: 600;
}

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
    background-color: white;
    padding: 0.75rem 1.5rem;
}

/* User dropdown */
.user-dropdown {
    position: relative;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    transition: var(--transition);
}

.user-profile:hover {
    background-color: #f1f5f9;
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 0.5rem;
    min-width: 200px;
}

.dropdown-item.logout {
    color: #e74c3c;
}

.dropdown-item.logout:hover {
    background-color: #ffeaea;
}

#main-content {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    background-color: #f8f9fa;
}

footer {
    text-align: center;
    padding: 12px 0;
    background-color: #fff;
    border-top: 1px solid #dee2e6;
}

#wrapper.toggled #sidebar-wrapper {
    margin-left: -250px;
}
</style>
</head>
<body>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">KABENG</div>
        <div class="jurusan-text">
    {{ Auth::user()->konsentrasi?->nama_konsentrasi ?? 'Konsentrasi Tidak Diketahui' }}
        </div>

        <div class="list-group list-group-flush">
            <a href="{{ route('kabeng.dashboard') }}" class="list-group-item {{ request()->routeIs('kabeng.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="{{ route('kabeng.barang.index') }}" class="list-group-item {{ request()->routeIs('kabeng.barang.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Data Barang Jurusan
            </a>

            <a href="{{ route('kabeng.laporan') }}" class="list-group-item">
                <i class="bi bi-file-earmark-text"></i> Laporan Barang
            </a>

        </div>
    </div>

    <!-- Main content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-2">
            <div class="container-fluid">

                <button class="btn btn-outline-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>

                <h5 class="ms-3 mb-0 d-none d-sm-block">@yield('title')</h5>

                <div class="ms-auto user-dropdown">
                    <div class="user-profile" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="d-none d-md-block">
                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                            <small class="text-muted">Kepala Bengkel</small>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('kabeng.profile.index') }}">
                                <i class="bi bi-person"></i> Profil
                            </a>
                        </li>
                    
                        <li><hr class="dropdown-divider"></li>
                    
                        <li>
                            <a class="dropdown-item logout" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                    
                </div>

            </div>
        </nav>

        <div id="main-content">
            @yield('content')
        </div>

        <footer>
            &copy; {{ date('Y') }} SMKN 1 TALAGA - Sistem Inventori Barang.
        </footer>

    </div>
</div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('sidebarToggle').addEventListener('click', () => {
    document.getElementById('wrapper').classList.toggle('toggled');
});
</script>

@yield('scripts')

</body>
</html>
