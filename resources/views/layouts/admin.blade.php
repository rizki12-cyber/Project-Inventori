<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard Admin')</title>

<link rel="icon" href="{{ asset('assets/images/logo1.png') }}" type="image/png" sizes="32x32">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root {
    --primary-color: #4285f4; /* Warna Biru Baru */
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
    position: relative;
    z-index: 1000;
    transform: translateX(0);
    transition: var(--transition);
    animation: slideInLeft 0.4s ease forwards;

    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    padding-bottom: 20px;
}

#sidebar-wrapper .sidebar-heading {
    font-size: 1.4rem;
    font-weight: 700;
    text-align: center;
    padding: 1.2rem 0;
    border-bottom: 1px solid #f0f0f0;
    color: var(--primary-color);
    letter-spacing: 0.5px;
    animation: fadeInDown 0.6s ease forwards;
}

#sidebar-wrapper .list-group {
    padding: 1rem 0;
    flex-grow: 1;
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
    position: relative;
    overflow: hidden;
    cursor: pointer;
    animation: fadeInUp 0.4s ease forwards;
    opacity: 0;
}

#sidebar-wrapper .list-group-item span {
    transition: var(--transition);
}

#sidebar-wrapper .list-group-item i {
    font-size: 1.2rem;
    color: #64748b;
    transition: var(--transition);
}

#sidebar-wrapper .list-group-item:hover {
    background-color: var(--sidebar-hover);
    transform: translateX(3px);
}

#sidebar-wrapper .list-group-item:hover i {
    color: var(--sidebar-active-border);
}

#sidebar-wrapper .list-group-item.active {
    background-color: var(--sidebar-active-bg);
    color: var(--sidebar-active-border);
    font-weight: 600;
    border-left: 4px solid var(--sidebar-active-border);
    box-shadow: inset 4px 0 0 var(--sidebar-active-border);
    transform: translateX(0);
}

#sidebar-wrapper .list-group-item.active i {
    color: var(--sidebar-active-border);
}

/* Konten Halaman */
#page-content-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: var(--transition);
    background-color: #f8f9fa;
}

/* Navbar */
.navbar {
    border-radius: 0 0 15px 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    flex-shrink: 0;
    background-color: white;
    padding: 0.75rem 1.5rem;
}

/* Style tambahan untuk Logo dan Nama Sekolah di Navbar */
.header-info {
    display: flex;
    align-items: center;
    margin-left: 1rem;
}
.header-info img {
    height: 30px; /* Ukuran logo */
    margin-right: 10px;
}
.header-info h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #34495e;
    margin: 0;
}
/* Akhir style tambahan */


/* Dropdown Pengguna */
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
    background-color: var(--sidebar-active-border);
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

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.75rem 1rem;
    border-radius: 6px;
    transition: var(--transition);
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.logout {
    color: #e74c3c;
}

.dropdown-item.logout:hover {
    background-color: #ffeaea;
}

/* Konten Utama */
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
    font-size: 0.9rem;
    color: #6c757d;
    flex-shrink: 0;
}

/* Sidebar disembunyikan */
#wrapper.toggled #sidebar-wrapper {
    margin-left: -250px;
}

/* Animasi */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); opacity: 1; }
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}
</style>
</head>
<body>

<div id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">INVENTORI</div>
        <div class="list-group list-group-flush">

            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action 
                {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" style="animation-delay: 0.1s;">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.barang.index') }}" class="list-group-item list-group-item-action
                {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}" style="animation-delay: 0.2s;">
                <i class="bi bi-box-seam"></i> <span>Data Barang</span>
            </a>

            <a href="{{ route('admin.supplier.index') }}" class="list-group-item list-group-item-action
                {{ request()->routeIs('admin.supplier.*') ? 'active' : '' }}" style="animation-delay: 0.3s;">
                <i class="bi bi-truck"></i> <span>Data Supplier</span>
            </a>

            <a href="{{ route('admin.barangmasuk.index') }}" class="list-group-item list-group-item-action
                {{ request()->routeIs('admin.barangmasuk.*') ? 'active' : '' }}" style="animation-delay: 0.4s;">
                <i class="bi bi-arrow-down-circle"></i> <span>Barang Masuk</span>
            </a>

            <a href="{{ route('admin.barangkeluar.index') }}" class="list-group-item list-group-item-action
                {{ request()->routeIs('admin.barangkeluar.*') ? 'active' : '' }}" style="animation-delay: 0.5s;">
                <i class="bi bi-arrow-up-circle"></i> <span>Barang Keluar</span>
            </a>

            <a href="{{ route('admin.peminjaman.index') }}" class="list-group-item list-group-item-action
                {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}" style="animation-delay: 0.6s;">
                <i class="bi bi-journal-text"></i> <span>Peminjaman</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}" class="list-group-item list-group-item-action
                {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" style="animation-delay: 0.7s;">
                <i class="bi bi-file-earmark-text"></i> <span>Laporan</span>
            </a>

            <a href="{{ route('admin.datauser.index') }}" class="list-group-item list-group-item-action
                {{ request()->routeIs('admin.datauser.*') ? 'active' : '' }}" style="animation-delay: 0.8s;">
                <i class="bi bi-people"></i> <span>Data Pengguna</span>
            </a>

            <a href="{{ route('admin.programkeahlian.index') }}" class="list-group-item list-group-item-action
            {{ request()->routeIs('admin.programkeahlian.*') ? 'active' : '' }}" style="animation-delay: 0.9s;">
                <i class="bi bi-book"></i> <span>Data Program Keahlian</span>
            </a>

            <a href="{{ route('admin.konsentrasi.index') }}" class="list-group-item list-group-item-action
            {{ request()->routeIs('admin.konsentrasi.*') ? 'active' : '' }}" style="animation-delay: 1.0s;">
                <i class="bi bi-diagram-3"></i> <span>Data Konsentrasi Keahlian</span>
            </a>
        </div>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-2">
            <div class="container-fluid">
                <button class="btn btn-outline-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>
                
                <div class="header-info d-none d-sm-flex">
                    <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo Sekolah" class="me-2">
                    <h5>SMKN 1 TALAGA</h5>
                </div>
                <div class="ms-auto user-dropdown">
                    <div class="user-profile" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">A</div>
                        <div class="user-info d-none d-md-block">
                            <div class="fw-semibold">Admin</div>
                            <small class="text-muted">Administrator</small>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person"></i> Profil
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item logout" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Keluar
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
            &copy; {{ date('Y') }} SMKN 1 TALAGA - Sistem Inventori Barang. Seluruh hak cipta dilindungi.
        </footer>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const wrapper = document.getElementById('wrapper');

    sidebarToggle.addEventListener('click', () => {
        wrapper.classList.toggle('toggled');
    });
});
</script>

@yield('scripts')

</body>
</html>