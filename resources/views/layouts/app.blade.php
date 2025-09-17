<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Tetembomua - Profil Desa Pertanian')</title>
    
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
            line-height: 1.6;
            color: var(--text-dark);
        }

        /* Navbar Styles dengan Gradasi Modern */
        .navbar {
            background: var(--primary-gradient);
            box-shadow: 0 4px 20px rgba(46, 139, 87, 0.3);
            padding: 1rem 0;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.95) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        .navbar-toggler {
            border: none;
            color: white;
        }

        /* Dropdown Menu Styles */
        .dropdown-menu {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            color: var(--text-dark);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 0;
        }

        .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateX(5px);
        }

        .dropdown-toggle::after {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        .dropdown.show .dropdown-toggle::after {
            transform: rotate(180deg);
        }

        /* Hero Section dengan Gradasi Modern */
        .hero-section {
            background: linear-gradient(135deg, 
                rgba(46, 139, 87, 0.9), 
                rgba(60, 179, 113, 0.8), 
                rgba(32, 178, 170, 0.7)), 
                url('https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 80vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                rgba(46, 139, 87, 0.3), 
                rgba(60, 179, 113, 0.2), 
                rgba(32, 178, 170, 0.3));
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 8px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #FFFFFF, #F0F8FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Section Styles */
        .section {
            padding: 5rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
        }

        /* Card Styles dengan Efek Modern */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            overflow: hidden;
            position: relative;
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

        /* Button Styles dengan Gradasi */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 30px;
            padding: 15px 35px;
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

        .btn-outline-primary {
            border: 2px solid;
            border-image: var(--primary-gradient) 1;
            color: var(--primary-green);
            border-radius: 30px;
            padding: 15px 35px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(46, 139, 87, 0.3);
        }

        /* Stats Cards dengan Gradasi */
        .stats-card {
            background: linear-gradient(135deg, var(--bg-light), white);
            border-left: 4px solid;
            border-image: var(--primary-gradient) 1;
            position: relative;
            overflow: hidden;
        }

        .stats-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 30px 30px 0;
            border-color: transparent var(--accent-teal) transparent transparent;
            opacity: 0.3;
        }

        .stats-card .card-body {
            padding: 2rem;
        }

        /* Footer dengan Gradasi Modern */
        .footer {
            background: linear-gradient(135deg, 
                var(--text-dark), 
                var(--primary-green), 
                var(--accent-teal));
            color: white;
            padding: 3rem 0 1rem;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .footer h5 {
            color: var(--light-green);
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .footer a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .social-links a {
            display: inline-block;
            width: 45px;
            height: 45px;
            background: var(--primary-gradient);
            color: white;
            text-align: center;
            line-height: 45px;
            border-radius: 50%;
            margin-right: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
        }

        .social-links a:hover {
            background: var(--brown-gradient);
            transform: translateY(-5px) rotate(360deg);
            box-shadow: 0 8px 25px rgba(139, 69, 19, 0.4);
        }

        /* Breadcrumb dengan Gradasi */
        .breadcrumb {
            background: linear-gradient(135deg, var(--bg-light), white);
            padding: 1.5rem 0;
            margin-bottom: 0;
            border-bottom: 3px solid;
            border-image: var(--primary-gradient) 1;
        }

        .breadcrumb-item a {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: var(--text-light);
        }

        /* Custom Animations */
        .fade-in {
            animation: fadeIn 1s ease-in;
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

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }

            /* Mobile Navbar Adjustments */
            .navbar-nav {
                text-align: center;
            }

            .navbar-nav .nav-link {
                padding: 1rem 0;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }

            .navbar-nav .nav-link:last-child {
                border-bottom: none;
            }

            .dropdown-menu {
                background: rgba(255,255,255,0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
                margin-top: 0;
            }

            .dropdown-item {
                color: white;
                text-align: center;
            }

            .dropdown-item:hover {
                background: rgba(255,255,255,0.2);
                color: white;
                transform: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('FOTO/LOGO-removebg-preview.png') }}" alt="Logo Desa Tetembomua" height="50" class="me-2">
                <div>
                    <span class="fw-bold text-white">Desa Tetembomua</span>
                    <small class="d-block text-white-50">Kecamatan Lambuya</small>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Profil Desa
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.visi-misi') }}">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.struktur') }}">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.demografi') }}">Demografi</a></li>
                            <li><a class="dropdown-item" href="{{ route('pertanian.komoditas') }}">Komoditas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news') }}">Informasi Terkini</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('galeri') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Kontak</a>
                    </li>
                    
                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-section">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('FOTO/LOGO-removebg-preview.png') }}" alt="Logo Desa Tetembomua" height="40" class="me-2">
                            <div>
                                <h5 class="text-white mb-0">Desa Tetembomua</h5>
                                <small class="text-white-50">Kecamatan Lambuya</small>
                            </div>
                        </div>
                        <p class="text-white-50">Desa yang maju dan berbudaya dengan masyarakat yang ramah, produktif, dan komitmen untuk mengembangkan desa secara berkelanjutan.</p>
                        <div class="social-links">
                            @php($social = \App\Helpers\SettingsHelper::get('social_media', []))
                            <a href="{{ $social['facebook'] ?? '#' }}" target="_blank" rel="noopener" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $social['instagram'] ?? '#' }}" target="_blank" rel="noopener" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $social['youtube'] ?? '#' }}" target="_blank" rel="noopener" title="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="{{ $social['whatsapp'] ?? '#' }}" target="_blank" rel="noopener" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Profil Desa</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('profile.visi-misi') }}">Visi & Misi</a></li>
                        <li><a href="{{ route('profile.struktur') }}">Struktur</a></li>
                        <li><a href="{{ route('profile.demografi') }}">Demografi</a></li>
                        <li><a href="{{ route('pertanian.komoditas') }}">Komoditas</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Informasi Desa</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('potensi') }}">Potensi Desa</a></li>
                        <li><a href="{{ route('program') }}">Program Desa</a></li>
                        <li><a href="{{ route('statistik') }}">Statistik</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Media</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('galeri') }}">Galeri</a></li>
                        <li><a href="{{ route('news') }}">Berita</a></li>
                        <li><a href="{{ route('announcements') }}">Pengumuman</a></li>
                        <li><a href="{{ route('about') }}">Tentang</a></li>
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>Kontak</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Desa Tetembomua, Kecamatan Lambuya</p>
                    <p><i class="fas fa-phone me-2"></i>+62 812-3456-7890</p>
                    <p><i class="fas fa-envelope me-2"></i>info@desatetembomua.id</p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2024 Desa Tetembomua. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk Desa Tetembomua</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

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

        document.querySelectorAll('.card, .section-title').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
