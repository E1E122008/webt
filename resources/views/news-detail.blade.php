@extends('layouts.app')

@section('title', $news->title . ' - Desa Tetembomua')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news') }}">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $news->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- News Detail Section -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="news-detail">
                    <!-- News Header -->
                    <div class="news-header mb-4">
                        <div class="news-meta mb-3">
                            <span class="badge bg-{{ $news->category == 'umum' ? 'primary' : ($news->category == 'pertanian' ? 'success' : ($news->category == 'sosial' ? 'info' : ($news->category == 'ekonomi' ? 'warning' : 'secondary'))) }}">
                                {{ ucfirst($news->category) }}
                            </span>
                            <small class="text-muted ms-3">
                                <i class="fas fa-calendar me-1"></i>{{ $news->published_at->format('d F Y') }}
                            </small>
                            <small class="text-muted ms-3">
                                <i class="fas fa-user me-1"></i>{{ $news->author->name ?? 'Admin' }}
                            </small>
                        </div>
                        <h1 class="news-title">{{ $news->title }}</h1>
                    </div>

                    <!-- News Image -->
                    @if($news->image)
                    <div class="news-image mb-4">
                        <span role="button" class="open-image" data-src="{{ $news->image_url }}">
                            <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="img-fluid rounded">
                        </span>
                    </div>
                    @endif

                    <!-- News Content -->
                    <div class="news-content">
                        {!! $news->content !!}
                    </div>

                    <!-- News Footer -->
                    <div class="news-footer mt-5 pt-4 border-top">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Dipublikasikan pada {{ $news->published_at->format('d F Y, H:i') }} WITA
                                </small>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="social-share">
                                    <span class="text-muted me-2">Bagikan:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                                       target="_blank" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->title) }}" 
                                       target="_blank" class="btn btn-outline-info btn-sm me-1">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . request()->fullUrl()) }}" 
                                       target="_blank" class="btn btn-outline-success btn-sm">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <!-- Related News -->
                    @if($relatedNews->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-newspaper me-2 text-primary"></i>
                                Berita Terkait
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach($relatedNews as $related)
                            <div class="related-news-item mb-3">
                                <div class="row">
                                    <div class="col-4">
                                        <span role="button" class="open-image" data-src="{{ $related->image_url }}">
                                            <img src="{{ $related->image_url }}" alt="{{ $related->title }}" 
                                                 class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                                        </span>
                                    </div>
                                    <div class="col-8">
                                        <h6 class="mb-1">
                                            <a href="{{ route('news.detail', $related->slug) }}" class="text-decoration-none">
                                                {{ Str::limit($related->title, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>{{ $related->published_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Back to News -->
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{ route('news') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Berita
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.breadcrumb-section {
    background-color: #f8f9fa;
    padding: 1rem 0;
}

.news-detail {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.news-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark-green);
    line-height: 1.2;
}

.news-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 10px;
}

.news-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.news-content h1,
.news-content h2,
.news-content h3,
.news-content h4,
.news-content h5,
.news-content h6 {
    color: var(--dark-green);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.news-content p {
    margin-bottom: 1.5rem;
}

.news-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.related-news-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 1rem;
}

.related-news-item:last-child {
    border-bottom: none;
    margin-bottom: 0 !important;
}

.sidebar .card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.sidebar .card-header {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
    color: white;
    border-radius: 10px 10px 0 0 !important;
    border: none;
}

.open-image {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.open-image:hover {
    transform: scale(1.02);
}

.social-share .btn {
    border-radius: 20px;
    padding: 0.5rem 0.75rem;
}

/* Custom color classes for consistency */
.text-primary {
    color: var(--primary-green) !important;
}

.bg-primary {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)) !important;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
    transform: translateY(-2px);
}

.btn-outline-primary {
    border-color: var(--primary-green);
    color: var(--primary-green);
}

.btn-outline-primary:hover {
    background-color: var(--primary-green);
    border-color: var(--primary-green);
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
