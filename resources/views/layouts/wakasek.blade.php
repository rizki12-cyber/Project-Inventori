<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard Wakasek')</title>

<link rel="icon" href="{{ asset($pengaturan->favicon ?? 'assets/images/logo1.png') }}" type="image/png" sizes="32x32">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    background-color: #f8f9fa;
    margin: 0;
}

#wrapper {
    display: flex;
    height: 100vh;
    transition: var(--transition);
}

/* SIDEBAR */
#sidebar-wrapper {
    min-width: 250px;
    max-width: 250px;
    background-color: var(--sidebar-bg);
    border-right: 1px solid #e5e7eb;
    box-shadow: 4px 0 15px rgba(0,0,0,0.03);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    padding-bottom: 20px;
    animation: slideInLeft .4s ease forwards;
}

.sidebar-heading {
    font-size: 1.4rem;
    font-weight: 700;
    text-align: center;
    padding: 1.2rem 0;
    border-bottom: 1px solid #f0f0f0;
    color: var(--primary-color);
    letter-spacing: .5px;
    animation: fadeInDown .6s ease forwards;
}

#sidebar-wrapper .list-group {
    padding: 1rem 0;
    flex-grow: 1;
}

.list-group-item {
    background-color: transparent;
    border: none;
    color: var(--sidebar-text);
    border-radius: 10px;
    margin: 6px 12px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: var(--transition);
    animation: fadeInUp .4s ease forwards;
    opacity: 0;
}

.list-group-item i {
    font-size: 1.2rem;
    color: #64748b;
    transition: var(--transition);
}

.list-group-item:hover {
    background-color: var(--sidebar-hover);
    transform: translateX(3px);
}

.list-group-item:hover i {
    color: var(--primary-color);
}

.list-group-item.active {
    background-color: var(--sidebar-active-bg);
    color: var(--primary-color);
    font-weight: 600;
    border-left: 4px solid var(--primary-color);
    box-shadow: inset 4px 0 0 var(--primary-color);
}

.list-group-item.active i {
    color: var(--primary-color);
}

/* PAGE WRAPPER */
#page-content-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #f8f9fa;
}

/* NAVBAR */
.navbar {
    background: #fff;
    padding: .75rem 1.5rem;
    border-radius: 0 0 15px 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
}

/* LOGO + TITLE */
.header-info {
    display: flex;
    align-items: center;
    margin-left: 1rem;
}

.header-info img {
    height: 30px;
    margin-right: 10px;
}

.header-info h5 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    color: #34495e;
}

/* USER DROPDOWN */
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
    background: var(--primary-color);
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.dropdown-menu {
    border: none;
    border-radius: 10px;
    min-width: 200px;
    box-shadow: 0 4px 20px rgba(0,0,0,.1);
}

.dropdown-item {
    padding: .75rem 1rem;
    border-radius: 6px;
}

.dropdown-item.logout {
    color: #e74c3c;
}

.dropdown-item.logout:hover {
    background-color: #ffeaea;
}

/* CONTENT */
#main-content {
    flex: 1;
    padding: 24px;
    overflow-y: auto;
}

footer {
    background: #fff;
    text-align: center;
    padding: 12px 0;
    border-top: 1px solid #dee2e6;
}

/* SIDEBAR TOGGLE */
#wrapper.toggled #sidebar-wrapper {
    margin-left: -250px;
}

/* ANIMATIONS */
@keyframes fadeInUp {
    from {transform: translateY(20px); opacity: 0;}
    to {transform: translateY(0); opacity: 1;}
}

@keyframes fadeInDown {
    from {transform: translateY(-10px); opacity: 0;}
    to {transform: translateY(0); opacity: 1;}
}

@keyframes slideInLeft {
    from {transform: translateX(-20px); opacity: 0;}
    to {transform: translateX(0); opacity: 1;}
}
</style>
</head>

<body>

<div id="wrapper">

    <!-- SIDEBAR -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">INVENTORI</div>
        <div class="list-group list-group-flush">

            <a href="{{ route('wakasek.dashboard') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('wakasek.dashboard') ? 'active' : '' }}"
               style="animation-delay:.1s;">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="{{ route('wakasek.barang.index') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('wakasek.barang.*') ? 'active' : '' }}"
               style="animation-delay:.2s;">
                <i class="bi bi-box-seam"></i> Data Barang
            </a>

            <a href="{{ route('wakasek.laporan.index') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('wakasek.laporan.*') ? 'active' : '' }}"
               style="animation-delay:.3s;">
                <i class="bi bi-file-earmark-text"></i> Laporan
            </a>

        </div>
    </div>

    <!-- PAGE CONTENT -->
    <div id="page-content-wrapper">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-2">
            <div class="container-fluid">

                <button class="btn btn-outline-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>

                <div class="header-info d-none d-sm-flex">
                <img src="{{ asset($pengaturan->logo_sekolah ?? 'assets/images/logo1.png') }}" alt="Logo Sekolah">
                    <h5>SMKN 1 TALAGA</h5>
                </div>

                <!-- USER DROPDOWN -->
                <div class="ms-auto user-dropdown">
                    <div class="user-profile" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar">W</div>
                        <div class="user-info d-none d-md-block">
                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                            <small class="text-muted">Wakasek</small>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('wakasek.profile') }}">
                                <i class="bi bi-person"></i> Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item logout"
                               href="#"
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
            © {{ date('Y') }} SMKN 1 TALAGA - Sistem Inventori Barang.
        </footer>

    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('sidebarToggle').addEventListener('click', () => {
    document.getElementById('wrapper').classList.toggle('toggled');
});
</script>

@yield('scripts')

</body>
</html>
