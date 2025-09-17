@extends('layouts.app')

@section('title', 'Pengumuman - Desa Tetembomua')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content">
                    <h1>Pengumuman & Informasi Penting</h1>
                    <p>Informasi terkini dan pengumuman resmi dari Pemerintah Desa Tetembomua</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Announcements Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Daftar Pengumuman</h2>
            <p>Semua pengumuman dan informasi penting desa</p>
        </div>
        
        <!-- Search -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <form method="GET" action="{{ route('announcements') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari pengumuman..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Announcements List -->
        <div class="row">
            @forelse($announcements as $announcement)
            <div class="col-lg-6 mb-4">
                <div class="card h-100 announcement-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <h5 class="card-title mb-2">{{ $announcement->title }}</h5>
                            <div class="announcement-meta">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ $announcement->formatted_date }}
                                    @if($announcement->formatted_time)
                                        <span class="ms-3">
                                            <i class="fas fa-clock me-1"></i>{{ $announcement->formatted_time }} WITA
                                        </span>
                                    @endif
                                </small>
                            </div>
                            @if($announcement->location)
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $announcement->location }}
                                    </small>
                                </div>
                            @endif
                        </div>
                        
                        @if($announcement->description)
                            <p class="card-text">{{ Str::limit($announcement->description, 150) }}</p>
                        @endif
                        
                        @if($announcement->content)
                            <div class="announcement-content">
                                <p class="card-text">{{ Str::limit(strip_tags($announcement->content), 200) }}</p>
                            </div>
                        @endif
                        
                        @if($announcement->attachment_path)
                            <div class="mt-3">
                                <a href="{{ Storage::url($announcement->attachment_path) }}" 
                                   class="btn btn-outline-secondary btn-sm" 
                                   target="_blank">
                                    <i class="fas fa-download me-1"></i>Download Lampiran
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak ada pengumuman ditemukan</h4>
                    <p class="text-muted">Coba gunakan kata kunci lain atau pilih prioritas yang berbeda.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($announcements->hasPages())
        <nav aria-label="Announcements pagination" class="mt-5">
            {{ $announcements->appends(request()->query())->links() }}
        </nav>
        @endif
    </div>
</section>

<style>
.announcement-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.announcement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.announcement-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.announcement-content {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

/* Custom color classes for consistency */
.text-primary {
    color: var(--primary-green) !important;
}

.btn-outline-primary {
    border-color: var(--primary-green);
    color: var(--primary-green);
}

.btn-outline-primary:hover {
    background-color: var(--primary-green);
    border-color: var(--primary-green);
}

.btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
}
</style>

@endsection
