@extends('layouts.app')

@section('title', 'Beranda - ' . ($siteSettings['village_name'] ?? 'Desa Tetembomua'))

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    
                    <h1 class="display-4 fw-bold mb-4">Selamat Datang di {{ $siteSettings['village_name'] ?? 'Desa Tetembomua' }}</h1>
                    <p class="lead mb-4">{{ $siteSettings['village_description'] ?? 'Desa yang maju dan berbudaya dengan masyarakat yang ramah, produktif, dan komitmen untuk mengembangkan desa secara berkelanjutan' }}</p>
                    <div class="hero-buttons">
                        <a href="{{ route('about') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-info-circle me-2"></i>Tentang Desa
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-envelope me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <div class="hero-image-container">
                        <span role="button" class="open-image" data-src="{{ asset('FOTO/upacara.jpeg') }}">
                            <img src="{{ asset('FOTO/upacara.jpeg') }}" 
                                 alt="{{ $siteSettings['village_name'] ?? 'Desa Tetembomua' }}" class="img-fluid hero-image">
                        </span>
                        <div class="hero-image-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-4 mb-4">
                <div class="card text-center h-100 stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-home fa-3x"></i>
                        </div>
                        <h4 class="card-title stats-number">850+</h4>
                        <p class="card-text">Kepala Keluarga</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4">
                <div class="card text-center h-100 stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-graduation-cap fa-3x"></i>
                        </div>
                        <h4 class="card-title stats-number">3</h4>
                        <p class="card-text">Sekolah</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4">
                <div class="card text-center h-100 stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-heartbeat fa-3x"></i>
                        </div>
                        <h4 class="card-title stats-number">1</h4>
                        <p class="card-text">Posyandu</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4">
                <div class="card text-center h-100 stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-seedling fa-3x"></i>
                        </div>
                        <h4 class="card-title stats-number">500+</h4>
                        <p class="card-text">Petani</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4">
                <div class="card text-center h-100 stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-industry fa-3x"></i>
                        </div>
                        <h4 class="card-title stats-number">25+</h4>
                        <p class="card-text">UMKM</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4">
                <div class="card text-center h-100 stats-card">
                    <div class="card-body">
                        <div class="stats-icon">
                            <i class="fas fa-mosque fa-3x"></i>
                        </div>
                        <h4 class="card-title stats-number">5</h4>
                        <p class="card-text">Tempat Ibadah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru Section -->
<section class="section">
    <div class="container">
        <div class="section-title mb-4">
            <h2>Berita Terbaru</h2>
            <p>Informasi dan kabar terbaru dari desa</p>
        </div>
        <div class="row">
            @forelse($latestNews as $news)
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="card news-card h-100">
                        <div class="news-image-container">
                            <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="card-img-top">
                            <div class="news-overlay">
                                <span class="badge">{{ ucfirst($news->status) }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{ $news->title }}</h5>
                            <div class="news-meta mb-2">
                                <small><i class="fas fa-calendar-alt me-1"></i> {{ $news->published_at ? $news->published_at->format('d M Y') : '-' }}</small>
                                <span class="mx-2">|</span>
                                <small><i class="fas fa-user me-1"></i> {{ $news->author->name ?? '-' }}</small>
                            </div>
                            <p class="card-text">{{ $news->excerpt }}</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Belum ada berita terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Tentang {{ $siteSettings['village_name'] ?? 'Desa Tetembomua' }}</h2>
            <p>Mengenal lebih dekat desa kami yang kaya akan budaya dan potensi</p>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <div class="about-image-container">
                    <span role="button" class="open-image" data-src="https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
                        <img src="https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?ixbl=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             alt="{{ $siteSettings['village_name'] ?? 'Desa Tetembomua' }}" class="img-fluid about-image">
                    </span>
                    <div class="about-image-overlay"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="mb-4">{{ $siteSettings['village_name'] ?? 'Desa Tetembomua' }} yang Maju dan Berbudaya</h3>
                <p class="mb-4">{{ $siteSettings['village_description'] ?? 'Desa Tetembomua adalah desa yang terletak di Kecamatan Lambuya, Kabupaten Konawe, Sulawesi Tenggara. Desa kami memiliki masyarakat yang beragam dengan berbagai profesi dan potensi. Selain terkenal dengan sektor pertanian yang maju, desa kami juga memiliki tradisi budaya yang kaya, pendidikan yang berkembang, dan semangat gotong royong yang tinggi dalam membangun desa.' }}</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Masyarakat yang Beragam</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Pendidikan Berkualitas</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Pertanian Maju</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>UMKM Berkembang</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="btn btn-primary">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Layanan & Program Desa</h2>
            <p>Berbagai layanan dan program yang disediakan untuk masyarakat desa</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center h-100 service-card">
                    <div class="card-body">
                        <div class="service-icon">
                            <i class="fas fa-file-alt fa-3x"></i>
                        </div>
                        <h5 class="card-title">Layanan Administrasi</h5>
                        <p class="card-text">Layanan pengurusan dokumen kependudukan, surat-menyurat, dan administrasi desa lainnya.</p>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary">Hubungi Kami</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center h-100 service-card">
                    <div class="card-body">
                        <div class="service-icon">
                            <i class="fas fa-hands-helping fa-3x"></i>
                        </div>
                        <h5 class="card-title">Program Pemberdayaan</h5>
                        <p class="card-text">Program pemberdayaan masyarakat dalam berbagai aspek kehidupan dan ekonomi.</p>
                        <a href="{{ route('news') }}" class="btn btn-outline-success">Lihat Program</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center h-100 service-card">
                    <div class="card-body">
                        <div class="service-icon">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                        <h5 class="card-title">Pelayanan Masyarakat</h5>
                        <p class="card-text">Pelayanan kesehatan, pendidikan, dan sosial untuk meningkatkan kesejahteraan masyarakat.</p>
                        <a href="{{ route('contact') }}" class="btn btn-outline-info">Informasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="section bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Statistik Desa</h2>
            <p>Data terkini perkembangan desa dalam berbagai aspek</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">2,847</h3>
                        <p class="stat-label">Total Penduduk</p>
                        <span class="stat-change positive">+2.3% dari tahun lalu</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">89.5%</h3>
                        <p class="stat-label">Angka Melek Huruf</p>
                        <span class="stat-change positive">+1.2% dari tahun lalu</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">Rp 2.8M</h3>
                        <p class="stat-label">PAD Desa</p>
                        <span class="stat-change positive">+15.3% dari tahun lalu</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">685</h3>
                        <p class="stat-label">Kepala Keluarga</p>
                        <span class="stat-change positive">+1.8% dari tahun lalu</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('statistik') }}" class="btn btn-primary">
                <i class="fas fa-chart-bar me-2"></i>Lihat Statistik Lengkap
            </a>
        </div>
    </div>
</section>



<!-- CTA Section -->
<section class="section bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Butuh Informasi Lebih Lanjut?</h3>
                <p class="mb-0">Hubungi kami untuk mendapatkan informasi detail seputar layanan dan program desa.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Image Styles */
.hero-image-container {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(46, 139, 87, 0.3);
}

.hero-image {
    border-radius: 20px;
    transition: transform 0.5s ease;
}

.hero-image-container:hover .hero-image {
    transform: scale(1.05);
}

.hero-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, 
        rgba(46, 139, 87, 0.2), 
        rgba(60, 179, 113, 0.1), 
        rgba(32, 178, 170, 0.2));
    border-radius: 20px;
}

/* Stats Cards Modern Styles */
.stats-icon {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
    transition: transform 0.3s ease;
}

.stats-card:hover .stats-icon {
    transform: scale(1.1);
}

.stats-number {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

/* About Section Styles */
.about-image-container {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(46, 139, 87, 0.2);
}

.about-image {
    border-radius: 20px;
    transition: transform 0.5s ease;
}

.about-image-container:hover .about-image {
    transform: scale(1.03);
}

.about-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, 
        rgba(46, 139, 87, 0.1), 
        rgba(60, 179, 113, 0.05), 
        rgba(32, 178, 170, 0.1));
    border-radius: 20px;
}

/* Feature Items */
.feature-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
}

.feature-item i {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-right: 1rem;
    font-size: 1.2rem;
}

/* Service Cards */
.service-card {
    transition: all 0.4s ease;
}

.service-icon {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
    transition: transform 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.1) rotate(5deg);
}

/* News Cards */
.news-card {
    transition: all 0.4s ease;
}

.news-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 20px 20px 0 0;
}

.news-image-container img {
    transition: transform 0.5s ease;
}

.news-card:hover .news-image-container img {
    transform: scale(1.1);
}

.news-overlay {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.news-overlay .badge {
    background: var(--primary-gradient);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
}

.news-meta {
    margin-bottom: 1rem;
}

/* Custom color classes for better balance */
.text-primary {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.text-success {
    color: var(--secondary-green) !important;
}

.text-info {
    color: var(--accent-teal) !important;
}

.text-warning {
    color: var(--warm-brown) !important;
}

.text-danger {
    color: #e74c3c !important;
}

.text-secondary {
    color: var(--dark-green) !important;
}

.bg-primary {
    background: var(--primary-gradient) !important;
}

.bg-success {
    background: var(--secondary-green) !important;
}

.bg-info {
    background: var(--accent-teal) !important;
}

.bg-warning {
    background: var(--warm-brown) !important;
}

.bg-danger {
    background: #e74c3c !important;
}

.bg-secondary {
    background: var(--dark-green) !important;
}

.btn-outline-success {
    border-color: var(--secondary-green);
    color: var(--secondary-green);
}

.btn-outline-success:hover {
    background: var(--secondary-green);
    border-color: var(--secondary-green);
}

.btn-outline-info {
    border-color: var(--accent-teal);
    color: var(--accent-teal);
}

.btn-outline-info:hover {
    background: var(--accent-teal);
    border-color: var(--accent-teal);
}

/* Stat Card Styles */
.stat-card {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 80px;
    height: 80px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.5rem;
}

.stat-icon i {
    font-size: 2rem;
    color: white;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-green);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.stat-change {
    font-size: 0.9rem;
    font-weight: 500;
}

.stat-change.positive {
    color: #28a745;
}

.stat-change.negative {
    color: #dc3545;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-image-container {
        margin-top: 2rem;
    }
    
    .stats-card {
        margin-bottom: 1rem;
    }
}

/* Image Preview Modal */
.image-preview-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.9);
    backdrop-filter: blur(5px);
}

.image-preview-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 70%;
    max-height: 70%;
}

.image-preview-content img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
}

.image-preview-close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10000;
}

.image-preview-close:hover {
    color: #ccc;
}

.open-image {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.open-image:hover {
    transform: scale(1.02);
}
</style>

<!-- Image Preview Modal -->
<div class="image-preview-modal" id="imagePreviewModal">
    <span class="image-preview-close" onclick="closeImagePreview()">&times;</span>
    <div class="image-preview-content">
        <img id="imagePreviewImg" src="" alt="Preview">
    </div>
</div>

<script>
function openImagePreview(src) {
    document.getElementById('imagePreviewImg').src = src;
    document.getElementById('imagePreviewModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeImagePreview() {
    document.getElementById('imagePreviewModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the image
document.getElementById('imagePreviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImagePreview();
    }
});

// Add click event to all open-image elements
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.open-image').forEach(function(element) {
        element.addEventListener('click', function() {
            const src = this.getAttribute('data-src');
            if (src) {
                openImagePreview(src);
            }
        });
    });
});
</script>

@endsection
