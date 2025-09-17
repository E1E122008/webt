@extends('layouts.app')

@section('title', 'Berita & Informasi - Desa Tetembomua')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content">
                    <h1>Berita & Pengumuman Terkini</h1>
                    <p>Dapatkan informasi terbaru seputar kegiatan, program, dan perkembangan Desa Tetembomua</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Berita Terbaru</h2>
            <p>Informasi terkini seputar kegiatan dan program desa</p>
        </div>
        
        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <form method="GET" action="{{ route('news') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari berita..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
        </div>
        
        <!-- Featured News -->
        @if($featuredNews)
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="card featured-news">
                    <span role="button" class="open-image" data-src="{{ $featuredNews->image_url }}">
                        <img src="{{ $featuredNews->image_url }}" 
                             class="card-img-top" alt="{{ $featuredNews->title }}">
                    </span>
                    <div class="card-body">
                        <div class="news-meta mb-3">
                            <span class="badge bg-primary">{{ ucfirst($featuredNews->category) }}</span>
                            <small class="text-muted ms-3">
                                <i class="fas fa-calendar me-1"></i>{{ $featuredNews->published_at->format('d F Y') }}
                            </small>
                        </div>
                        <h3 class="card-title">{{ $featuredNews->title }}</h3>
                        <p class="card-text">{{ $featuredNews->excerpt }}</p>
                        <a href="{{ route('news.detail', $featuredNews->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-bullhorn text-primary me-2"></i>
                            Pengumuman Terbaru
                        </h5>
                        <div class="announcement-list">
                            @forelse($announcements as $announcement)
                            <div class="announcement-item mb-3">
                                <div>
                                    <h6>{{ $announcement->title }}</h6>
                                    <p class="text-muted mb-1">{{ $announcement->formatted_date }}</p>
                                    @if($announcement->formatted_time)
                                        <small class="text-muted">Pukul {{ $announcement->formatted_time }} WITA</small>
                                    @endif
                                    @if($announcement->location)
                                        <br><small class="text-muted">Lokasi: {{ $announcement->location }}</small>
                                    @endif
                                    @if($announcement->description)
                                        <br><small class="text-muted">{{ Str::limit($announcement->description, 80) }}</small>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-3">
                                <i class="fas fa-bullhorn fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Tidak ada pengumuman</p>
                            </div>
                            @endforelse
                            
                            <!-- View All Button -->
                            <div class="text-center mt-3">
                                <a href="{{ route('announcements') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-list me-1"></i>Lihat Semua Pengumuman
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- News Grid -->
        <div class="row">
            @forelse($news as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <span role="button" class="open-image" data-src="{{ $item->image_url }}">
                        <img src="{{ $item->image_url }}" 
                             class="card-img-top" alt="{{ $item->title }}">
                    </span>
                    <div class="card-body">
                        <div class="news-meta mb-2">
                            <span class="badge bg-{{ $item->category == 'umum' ? 'primary' : ($item->category == 'pertanian' ? 'success' : ($item->category == 'sosial' ? 'info' : ($item->category == 'ekonomi' ? 'warning' : 'secondary'))) }}">
                                {{ ucfirst($item->category) }}
                            </span>
                            <small class="text-muted ms-2">
                                <i class="fas fa-calendar me-1"></i>{{ $item->published_at->format('d F Y') }}
                            </small>
                        </div>
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ $item->excerpt }}</p>
                        <a href="{{ route('news.detail', $item->slug) }}" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak ada berita ditemukan</h4>
                    <p class="text-muted">Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
        <nav aria-label="News pagination" class="mt-5">
            {{ $news->appends(request()->query())->links() }}
        </nav>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3>Dapatkan Informasi Terbaru</h3>
                <p class="mb-4">Berlangganan newsletter untuk mendapatkan informasi terbaru seputar kegiatan dan program desa langsung ke email Anda.</p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Masukkan email Anda" required>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-paper-plane me-2"></i>Berlangganan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.featured-news {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.featured-news .card-img-top {
    height: 300px;
    object-fit: cover;
}

.news-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.announcement-item {
    padding: 1rem 0;
    border-bottom: 1px solid #eee;
}

.announcement-item:last-child {
    border-bottom: none;
}

.newsletter-form .input-group {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-radius: 25px;
    overflow: hidden;
}

.newsletter-form .form-control {
    border: none;
    padding: 15px 20px;
}

.newsletter-form .btn {
    border-radius: 0 25px 25px 0;
    padding: 15px 25px;
}

.card-img-top {
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.news-card:hover .card-img-top {
    transform: scale(1.05);
}

/* Featured News Image */
.featured-news .card-img-top {
    height: 300px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.featured-news:hover .card-img-top {
    transform: scale(1.03);
}

/* Custom color classes for consistency */
.text-primary {
    color: var(--primary-green) !important;
}

.text-success {
    color: var(--secondary-green) !important;
}

.text-warning {
    color: var(--light-brown) !important;
}

.text-info {
    color: var(--accent-brown) !important;
}

.text-danger {
    color: #e74c3c !important;
}

.text-secondary {
    color: var(--dark-green) !important;
}

.bg-primary {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)) !important;
}

.bg-success {
    background-color: var(--secondary-green) !important;
}

.bg-info {
    background-color: var(--accent-brown) !important;
}

.bg-warning {
    background-color: var(--light-brown) !important;
}

.bg-danger {
    background-color: #e74c3c !important;
}

.bg-secondary {
    background-color: var(--dark-green) !important;
}

.bg-dark {
    background-color: var(--dark-green) !important;
}

.btn-outline-primary {
    border-color: var(--primary-green);
    color: var(--primary-green);
}

.btn-outline-primary:hover {
    background-color: var(--primary-green);
    border-color: var(--primary-green);
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
