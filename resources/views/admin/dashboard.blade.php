@extends('admin.layouts.app')

@section('title', 'Dashboard Admin - Desa Tetembomua')

@section('content')
<!-- Content Header -->
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
            <p class="text-muted mb-0">Selamat datang di Admin Panel Desa Tetembomua</p>
        </div>
        <div class="text-end">
            <div class="text-muted">
                <i class="fas fa-calendar me-1"></i>
                {{ date('d F Y') }}
            </div>
            <small class="text-muted">
                <i class="fas fa-clock me-1"></i>
                {{ date('H:i') }} WITA
            </small>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card slide-in h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                    <h3 class="mb-1 text-primary">{{ number_format($populationStats['total_population']) }}</h3>
                    <small class="text-muted">Total Penduduk</small>
                    </div>
                <div class="stat-icon">
                    <i class="fas fa-users text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card success slide-in h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                    <h3 class="mb-1 text-success">{{ number_format($populationStats['total_kk']) }}</h3>
                    <small class="text-muted">Total KK</small>
                    </div>
                <div class="stat-icon">
                    <i class="fas fa-home text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card warning slide-in h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                    <h3 class="mb-1 text-warning">{{ number_format($populationStats['farmer_count']) }}</h3>
                    <small class="text-muted">Petani</small>
                    </div>
                <div class="stat-icon">
                    <i class="fas fa-seedling text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card info slide-in h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                    <h3 class="mb-1 text-info">{{ number_format($populationStats['rt_count']) }}</h3>
                    <small class="text-muted">RT</small>
                    </div>
                <div class="stat-icon">
                    <i class="fas fa-map-marker-alt text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Cards -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="card fade-in h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-newspaper me-2 text-primary"></i>
                    Berita Terbaru
                </h5>
                    <a href="{{ route('admin.news') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($latestNews as $news)
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ Str::limit($news->title, 50) }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>{{ $news->author->name ?? 'Admin' }}
                                <i class="fas fa-calendar ms-2 me-1"></i>{{ $news->published_at ? $news->published_at->format('d M Y') : $news->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $news->status == 'published' ? 'success' : 'warning' }} ms-2">
                            {{ ucfirst($news->status) }}
                        </span>
                    </div>
                    @empty
                    <div class="list-group-item text-center py-4">
                        <i class="fas fa-newspaper fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada berita</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card fade-in h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-bullhorn me-2 text-primary"></i>
                    Pengumuman Terbaru
                </h5>
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($latestAnnouncements as $announcement)
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ Str::limit($announcement->title, 50) }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $announcement->formatted_date }}
                                @if($announcement->location)
                                    <i class="fas fa-map-marker-alt ms-2 me-1"></i>{{ Str::limit($announcement->location, 20) }}
                                @endif
                            </small>
                        </div>
                        <span class="badge bg-{{ $announcement->priority == 'high' ? 'danger' : ($announcement->priority == 'medium' ? 'warning' : 'info') }} ms-2">
                            {{ ucfirst($announcement->priority) }}
                        </span>
                    </div>
                    @empty
                    <div class="list-group-item text-center py-4">
                        <i class="fas fa-bullhorn fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada pengumuman</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Statistics -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>
                    Statistik Detail Desa
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 text-center mb-3">
                        <div class="p-3 border rounded">
                            <h6 class="text-info fw-bold mb-1">{{ number_format($populationStats['male_count']) }}</h6>
                            <small class="text-muted">Laki-laki</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center mb-3">
                        <div class="p-3 border rounded">
                            <h6 class="text-danger fw-bold mb-1">{{ number_format($populationStats['female_count']) }}</h6>
                        <small class="text-muted">Perempuan</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center mb-3">
                        <div class="p-3 border rounded">
                            <h6 class="text-success fw-bold mb-1">10.54 km²</h6>
                        <small class="text-muted">Luas Wilayah</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center mb-3">
                        <div class="p-3 border rounded">
                            <h6 class="text-info fw-bold mb-1">{{ number_format($stats['total_news']) }}</h6>
                            <small class="text-muted">Total Berita</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2 text-primary"></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary w-100 h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-plus fa-2x mb-2"></i>
                            <span>Tambah Berita</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.population.index') }}" class="btn btn-success w-100 h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <span>Data Penduduk</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.announcements.create') }}" class="btn btn-warning w-100 h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-bullhorn fa-2x mb-2"></i>
                            <span>Tambah Pengumuman</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.gallery') }}" class="btn btn-info w-100 h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-images fa-2x mb-2"></i>
                            <span>Galeri Media</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Desa -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card fade-in h-100">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Informasi Desa
                </h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center mb-3">
                        <span role="button" class="open-image" data-src="{{ asset('FOTO/DSC_0596.JPG') }}">
                            <img src="{{ asset('FOTO/DSC_0596.JPG') }}" alt="Kepala Desa Abdullah, SP" class="rounded-circle mb-2 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                        </span>
                        <h6 class="text-primary fw-bold mb-1">Abdullah, SP</h6>
                        <small class="text-muted">Kepala Desa</small>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-2 border rounded">
                                    <small class="text-muted">Masa Jabatan</small>
                                    <div class="fw-bold">2024 - Sekarang</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded">
                                    <small class="text-muted">Kecamatan</small>
                                    <div class="fw-bold">Lambuya</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded">
                                    <small class="text-muted">Kabupaten</small>
                                    <div class="fw-bold">Konawe</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded">
                                    <small class="text-muted">Provinsi</small>
                                    <div class="fw-bold">Sulawesi Tenggara</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card fade-in h-100">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-map-marked-alt me-2 text-primary"></i>
                    Batas Wilayah
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <div class="p-3 border rounded text-center">
                            <i class="fas fa-arrow-up text-danger fa-2x mb-2"></i>
                            <div class="fw-bold">Utara</div>
                            <small class="text-muted">Kecamatan Onembute</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded text-center">
                            <i class="fas fa-arrow-right text-primary fa-2x mb-2"></i>
                            <div class="fw-bold">Timur</div>
                            <small class="text-muted">Kecamatan Onembute</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded text-center">
                            <i class="fas fa-arrow-down text-success fa-2x mb-2"></i>
                            <div class="fw-bold">Selatan</div>
                            <small class="text-muted">Desa Wonua Hoa dan Asaki</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded text-center">
                            <i class="fas fa-arrow-left text-warning fa-2x mb-2"></i>
                            <div class="fw-bold">Barat</div>
                            <small class="text-muted">Desa Amberi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Image Preview Modal -->
<div class="modal fade" id="dashboardImagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="dashboardImagePreviewModalImg" src="" alt="Preview" class="img-fluid rounded shadow-lg">
            </div>
        </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewModal = document.getElementById('dashboardImagePreviewModal');
    const previewImg = document.getElementById('dashboardImagePreviewModalImg');
    const bsModal = previewModal ? new bootstrap.Modal(previewModal) : null;
    
    // Open image preview modal
    document.querySelectorAll('.open-image').forEach(el => {
        el.addEventListener('click', () => {
            if (!bsModal) return;
            previewImg.src = el.getAttribute('data-src');
            bsModal.show();
        });
    });
});
</script>
