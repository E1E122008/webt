<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Desa Tetembomua')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Warna Utama - Gradasi Hijau Modern */
            --primary-gradient: linear-gradient(135deg, #2E8B57, #3CB371, #20B2AA);
            --primary-green: #2E8B57;
            --secondary-green: #3CB371;
            --accent-teal: #20B2AA;
            --light-green: #90EE90;
            --dark-green: #006400;
            
            /* Warna Aksen - Gradasi Coklat Tanah */
            --brown-gradient: linear-gradient(135deg, #8B4513, #A0522D, #CD853F);
            --accent-brown: #8B4513;
            --light-brown: #DEB887;
            --warm-brown: #D2691E;
            
            /* Warna Netral Modern */
            --text-dark: #2C3E50;
            --text-light: #7F8C8D;
            --bg-light: #F8F9FA;
            --bg-warm: #FFF8DC;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--bg-warm) 100%);
            min-height: 100vh;
        }

        /* Sidebar Styles dengan Gradasi Modern */
        .sidebar {
            background: var(--primary-gradient);
            height: 100vh;
            color: white;
            box-shadow: 4px 0 20px rgba(46, 139, 87, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .sidebar-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #FFFFFF, #F0F8FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-header h5 {
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .sidebar-header small {
            opacity: 0.9;
            font-weight: 300;
        }

        .sidebar .nav {
            padding: 1.5rem 1rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            margin: 0.5rem 0;
            padding: 1rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .sidebar .nav-link:hover::before {
            left: 100%;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(10px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .sidebar .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
        }

        .content-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 5px solid;
            border-image: var(--primary-gradient) 1;
        }

        .content-header h2 {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        /* Card Styles dengan Efek Modern */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            overflow: hidden;
            position: relative;
            background: white;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(46, 139, 87, 0.2);
        }

        /* Button Styles */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 15px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(46, 139, 87, 0.4);
        }

        /* Table Styles */
        .table {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(46, 139, 87, 0.05);
            transform: scale(1.01);
        }

        /* Form Styles */
        .form-control {
            border: 2px solid #E9ECEF;
            border-radius: 15px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(46, 139, 87, 0.25);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        /* Badge Styles */
        .badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        /* Custom Animations */
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        .slide-in {
            animation: slideIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(30px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateX(-30px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 80vw;
                max-width: 320px;
                z-index: 2000;
                box-shadow: 4px 0 20px rgba(46, 139, 87, 0.3);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-backdrop {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.3);
                z-index: 1500;
            }
            .sidebar-backdrop.hide {
                display: none;
            }
            .sidebar-toggle-btn {
                display: block;
            }
        }
        @media (min-width: 769px) {
            .sidebar-toggle-btn {
                display: none;
            }
            .sidebar-backdrop {
                display: none;
            }
        }

        /* Breadcrumb */
        .breadcrumb {
            background: linear-gradient(135deg, var(--bg-light), white);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid;
            border-image: var(--primary-gradient) 1;
        }

        .breadcrumb-item a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: var(--text-light);
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="sidebar-backdrop hide" id="sidebar-backdrop"></div>
    <button class="btn btn-primary sidebar-toggle-btn" id="sidebar-toggle" style="position:fixed;top:20px;left:20px;z-index:2100;display:none;"><i class="fas fa-bars"></i></button>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-auto">
                <div class="sidebar" id="sidebar">
                    <div class="sidebar-header">
                        <img src="{{ asset('FOTO/LOGO-removebg-preview.png') }}" alt="Logo Desa Tetembomua" height="50" class="mb-3">
                        <h5>Admin Panel</h5>
                        <small>Desa Tetembomua</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        <a class="nav-link" data-bs-toggle="collapse" href="#mediaMenu" role="button" aria-expanded="false" aria-controls="mediaMenu">
                            <i class="fas fa-images"></i> Media <i class="fas fa-chevron-down float-end"></i>
                        </a>
                        <div class="collapse ms-3" id="mediaMenu">
                            <a class="nav-link {{ request()->is('admin/news*') ? 'active' : '' }}" href="{{ route('admin.news') }}">
                                <i class="fas fa-newspaper"></i>
                                Berita
                            </a>
                            <a class="nav-link {{ request()->is('admin/announcements*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}">
                                <i class="fas fa-bullhorn"></i>
                                Pengumuman
                            </a>
                            <a class="nav-link {{ request()->is('admin/gallery*') ? 'active' : '' }}" href="{{ route('admin.gallery') }}">
                                <i class="fas fa-images"></i> Galeri
                            </a>
                        </div>
                        <!-- Data Master Dropdown -->
                        <a class="nav-link" data-bs-toggle="collapse" href="#dataMasterMenu" role="button" aria-expanded="false" aria-controls="dataMasterMenu">
                            <i class="fas fa-database"></i> Data Master <i class="fas fa-chevron-down float-end"></i>
                        </a>
                        <div class="collapse ms-3" id="dataMasterMenu">
                            <a class="nav-link {{ request()->is('admin/population*') ? 'active' : '' }}" href="{{ route('admin.population.index') }}">
                                <i class="fas fa-users"></i> Kelola Penduduk
                            </a>
                            <a class="nav-link {{ request()->is('admin/agricultural*') ? 'active' : '' }}" href="{{ route('admin.agricultural') }}">
                                <i class="fas fa-seedling"></i> Data Pertanian
                            </a>
                            
                            <a class="nav-link {{ request()->is('admin/structure*') ? 'active' : '' }}" href="{{ route('admin.structure') }}">
                                <i class="fas fa-sitemap"></i> Struktur Organisasi
                            </a>
                            <a class="nav-link {{ request()->is('admin/facilities*') ? 'active' : '' }}" href="{{ route('admin.facilities') }}">
                                <i class="fas fa-building"></i> Sarana & Prasarana
                            </a>
                        </div>
                        <!-- Manajemen Dropdown -->
                        
                        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                            <i class="fas fa-user-cog"></i> Manajemen User
                        </a>
                        <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                            <i class="fas fa-cog"></i> Pengaturan
                        </a>
                        <!-- Lainnya Dropdown -->
                        
                        <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home"></i>
                            Kembali ke Website
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;" onsubmit="return confirmLogout()">
                            @csrf
                            <button type="submit" class="nav-link" style="background: none; border: none; width: 100%; text-align: left; color: rgba(255, 255, 255, 0.9); border-radius: 15px; margin: 0.5rem 0; padding: 1rem 1.5rem; font-weight: 500; transition: all 0.3s ease; position: relative; overflow: hidden; text-decoration: none; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='none'">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col">
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom JS -->
    <script>
        // Add fade-in animation to elements
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.card, .content-header').forEach(el => {
            observer.observe(el);
        });

        // Add slide-in animation to stat cards
        document.querySelectorAll('.stat-card').forEach((el, index) => {
            setTimeout(() => {
                el.classList.add('slide-in');
            }, index * 100);
        });

        // Logout confirmation function
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari admin panel?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2E8B57',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    document.querySelector('form[action="{{ route('logout') }}"]').submit();
                }
            });
            return false; // Prevent form submission until confirmed
        }

        // Sidebar toggle for mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');
        function showSidebar() {
            sidebar.classList.add('show');
            sidebarBackdrop.classList.remove('hide');
        }
        function hideSidebar() {
            sidebar.classList.remove('show');
            sidebarBackdrop.classList.add('hide');
        }
        sidebarToggle && sidebarToggle.addEventListener('click', showSidebar);
        sidebarBackdrop && sidebarBackdrop.addEventListener('click', hideSidebar);
        // Show toggle button only on mobile
        function handleResize() {
            if(window.innerWidth <= 768) {
                sidebarToggle.style.display = 'block';
            } else {
                sidebarToggle.style.display = 'none';
                sidebar.classList.remove('show');
                sidebarBackdrop.classList.add('hide');
            }
        }
        window.addEventListener('resize', handleResize);
        document.addEventListener('DOMContentLoaded', handleResize);
    </script>

    @yield('scripts')
</body>
</html>