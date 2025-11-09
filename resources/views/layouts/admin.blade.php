<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Dashboard')</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --sidebar-bg: #2c3e50;
    --sidebar-active: #3498db;
    --sidebar-hover: #34495e;
    --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    height: 100vh;
    overflow: hidden;
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
    color: #fff;
    border-radius: 0 15px 15px 0;
    box-shadow: 4px 0 15px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    transition: var(--transition);
    position: relative;
    z-index: 1000;
}

#sidebar-wrapper .sidebar-heading {
    font-size: 1.5rem;
    font-weight: 700;
    text-align: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

#sidebar-wrapper .list-group {
    padding: 1rem 0;
    flex-grow: 1;
}

#sidebar-wrapper .list-group-item {
    background-color: transparent;
    border: none;
    color: #ecf0f1;
    font-weight: 500;
    transition: var(--transition);
    border-radius: 8px;
    margin: 4px 8px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    position: relative;
    overflow: hidden;
}

#sidebar-wrapper .list-group-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    height: 70%;
    width: 4px;
    background-color: var(--sidebar-active);
    transform: scaleY(0) translateY(-50%);
    transition: var(--transition);
    border-radius: 0 4px 4px 0;
}

#sidebar-wrapper .list-group-item:hover {
    background-color: var(--sidebar-hover);
    color: #fff;
    transform: translateX(5px);
}

#sidebar-wrapper .list-group-item:hover::before {
    transform: scaleY(1) translateY(-50%);
}

#sidebar-wrapper .list-group-item.active {
    background-color: var(--sidebar-hover);
    color: #fff;
    font-weight: 600;
}

#sidebar-wrapper .list-group-item.active::before {
    transform: scaleY(1) translateY(-50%);
}

#sidebar-wrapper .list-group-item i {
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
}

/* Page Content */
#page-content-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: var(--transition);
}

/* Navbar */
.navbar {
    border-radius: 0 0 15px 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    flex-shrink: 0;
    background-color: white;
    padding: 0.75rem 1.5rem;
}

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
    background-color: #f8f9fa;
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: var(--sidebar-bg);
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

/* Scrollable content */
#main-content {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background-color: #f8f9fa;
}

.content-card {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: none;
    margin-bottom: 20px;
    transition: var(--transition);
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}

.content-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.content-card .card-header {
    background-color: white;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.25rem 1.5rem;
    border-radius: 12px 12px 0 0 !important;
    font-weight: 600;
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
    margin-left: -250px;
}

#wrapper.toggled #page-content-wrapper {
    margin-left: 0;
}

/* Animations */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

.fade-in-up { animation: fadeInUp 0.5s ease forwards; }
.slide-in-left { animation: slideInLeft 0.4s ease forwards; }

.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }
.delay-4 { animation-delay: 0.4s; }
</style>
</head>
<body>

<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">SMKN 1 TALAGA</div>
        <div class="list-group list-group-flush">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action slide-in-left 
                {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('barang.index') }}" class="list-group-item list-group-item-action slide-in-left delay-1
                {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Data Barang
            </a>
            <a href="#" class="list-group-item list-group-item-action slide-in-left delay-2">
                <i class="bi bi-arrow-left-right"></i> Transaksi
            </a>
            <a href="#" class="list-group-item list-group-item-action slide-in-left delay-3">
                <i class="bi bi-file-earmark-text"></i> Laporan
            </a>
            <a href="#" class="list-group-item list-group-item-action slide-in-left delay-4">
                <i class="bi bi-people"></i> Data User
            </a>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-2">
            <div class="container-fluid">
                <button class="btn btn-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>
                <h4 class="ms-3 mb-0">@yield('title')</h4>
                
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
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person-circle"></i> Profil
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
            &copy; {{ date('Y') }} SMKN 1 TALAGA - Sistem Inventori Barang. All rights reserved.
        </footer>
    </div>
</div>

<!-- ✅ FIXED Logout Form (POST + CSRF) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const wrapper = document.getElementById('wrapper');
    const overlay = document.getElementById('overlay');
    
    sidebarToggle.addEventListener('click', () => {
        wrapper.classList.toggle('toggled');
    });
    
    overlay.addEventListener('click', () => {
        wrapper.classList.toggle('toggled');
    });
});
</script>

</body>
</html>
