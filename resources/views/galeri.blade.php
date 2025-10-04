@extends('layouts.app')

@section('title', 'Galeri - Desa Tetembomua')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/FOTO/upacara.jpeg') center/cover;">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold text-white mb-4">Galeri Desa Tetembomua</h1>
                <p class="lead text-white mb-0">Dokumentasi Kegiatan, Pembangunan, dan Potensi Desa</p>
            </div>
        </div>
    </div>
</section>



@php
    $images = [];
    $videos = [];
    if (isset($media) && is_array($media)) {
        foreach ($media as $m) {
            if (($m['type'] ?? 'image') === 'video') { $videos[] = $m; } else { $images[] = $m; }
        }
    }
@endphp

<!-- Foto/Gambar -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="section-title">Foto Kegiatan</h2>
                <p class="text-muted">Foto kegiatan Desa Tetembomua</p>
                <div class="title-underline"></div>
            </div>
        </div>
        <div class="row g-4" id="gallery-grid">
            @if(count($images) > 0)
                @foreach($images as $item)
                <div class="col-lg-4 col-md-6 gallery-item" data-category="{{ $item['category'] ?? 'kegiatan' }}">
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <span role="button" class="open-image" data-src="{{ $item['path'] }}">
                                <img src="{{ $item['path'] }}" alt="{{ $item['name'] }}" class="img-fluid">
                            </span>
                            <div class="gallery-overlay">
                                <div class="overlay-content">
                                    <p>{{ $item['description'] ?? 'Kegiatan Desa Tetembomua' }}</p>
                                    <span class="gallery-date">{{ !empty($item['image_date']) ? date('d F Y', strtotime($item['image_date'])) : date('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <i class="fas fa-images fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada foto</h5>
                </div>
            @endif
        </div>
    </div>
    </section>

<!-- Video Section (from media list) -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="section-title">Video Dokumentasi</h2>
                <div class="title-underline"></div>
                <p class="text-muted">Video dokumentasi kegiatan Desa Tetembomua</p>
            </div>
        </div>
        <div class="row g-4">
            @if(count($videos) > 0)
                @foreach($videos as $item)
                <div class="col-lg-6">
                    <div class="video-card">
                        <video controls preload="metadata" style="width:100%; height:360px; background:#000; object-fit:cover;">
                            <source src="{{ $item['path'] }}" type="video/mp4">
                            <source src="{{ $item['path'] }}" type="video/webm">
                            <source src="{{ $item['path'] }}" type="video/ogg">
                            Browser Anda tidak mendukung tag video.
                        </video>
                        <div class="p-3">
                            <h5 class="text-muted">{{ $item['description'] ?? 'Video dokumentasi desa' }}</h5>
                            <span class="gallery-date">{{ !empty($item['image_date']) ? date('d F Y', strtotime($item['image_date'])) : date('d F Y') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <i class="fas fa-video fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada video</h5>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: var(--primary-gradient);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h3 class="text-white mb-4">Bagikan Momen Indah Desa</h3>
                <p class="text-white mb-4">Kirim foto dan video kegiatan desa untuk ditampilkan di galeri</p>
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">Kirim Dokumentasi</a>
            </div>
        </div>
    </div>
</section>

<style>
.filter-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid var(--primary-green);
    background: transparent;
    color: var(--primary-green);
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-green);
    color: white;
}

.gallery-card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.gallery-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.gallery-image {
    position: relative;
    overflow: hidden;
    aspect-ratio: 4/3;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-card:hover .gallery-image img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.9));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
    padding: 1rem;
}

.overlay-content h5 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.overlay-content p {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    opacity: 0.9;
}

.gallery-date {
    font-size: 0.8rem;
    opacity: 0.7;
    font-style: italic;
}

/* Video Cards */
.video-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.video-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.video-placeholder {
    padding: 3rem 2rem;
    text-align: center;
    background: var(--bg-light);
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.video-placeholder i {
    font-size: 4rem;
    color: var(--primary-green);
    margin-bottom: 1rem;
}

.video-placeholder h5 {
    color: var(--primary-green);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.video-placeholder p {
    color: var(--text-light);
    margin-bottom: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-buttons {
        gap: 0.5rem;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
}
</style>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content" style="background: transparent; border: none;">
      <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
      <img id="imagePreviewModalImg" src="" alt="Preview" style="width:100%; height:auto; border-radius:12px; box-shadow:0 20px 40px rgba(0,0,0,.4);">
    </div>
  </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const previewModal = document.getElementById('imagePreviewModal');
    const previewImg = document.getElementById('imagePreviewModalImg');
    const bsModal = previewModal ? new bootstrap.Modal(previewModal) : null;
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            galleryItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    // Open image in modal (lightbox)
    document.querySelectorAll('.open-image').forEach(el => {
        el.addEventListener('click', () => {
            if (!bsModal) return;
            previewImg.src = el.getAttribute('data-src');
            bsModal.show();
        });
    });
});
</script>
@endsection
