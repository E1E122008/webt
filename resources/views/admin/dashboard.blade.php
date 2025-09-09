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
        <div class="card stat-card slide-in">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">402</h3>
                        <small>Total Penduduk</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card success slide-in">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">118</h3>
                        <small>Total KK</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card warning slide-in">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">206</h3>
                        <small>Petani</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-seedling"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card info slide-in">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">6</h3>
                        <small>RT</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Cards -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card fade-in">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-newspaper me-2 text-primary"></i>
                    Berita Terbaru
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold">Panen Kelapa Sawit Berhasil</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Admin
                                <i class="fas fa-calendar ms-2 me-1"></i>15 Des 2024
                            </small>
                        </div>
                        <span class="badge bg-success">Published</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold">Pelatihan Teknologi Pertanian</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Admin
                                <i class="fas fa-calendar ms-2 me-1"></i>14 Des 2024
                            </small>
                        </div>
                        <span class="badge bg-success">Published</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold">Update Data Kependudukan</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Admin
                                <i class="fas fa-calendar ms-2 me-1"></i>13 Des 2024
                            </small>
                        </div>
                        <span class="badge bg-warning">Draft</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold">Festival Kakao Desa Tetembomua</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Admin
                                <i class="fas fa-calendar ms-2 me-1"></i>12 Des 2024
                            </small>
                        </div>
                        <span class="badge bg-success">Published</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card fade-in">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>
                    Statistik Desa
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3 class="text-primary fw-bold">402</h3>
                    <p class="text-muted mb-0">Total Penduduk</p>
                </div>
                <div class="row text-center mb-3">
                    <div class="col-6">
                        <h6 class="text-info fw-bold">222</h6>
                        <small class="text-muted">Laki-laki</small>
                    </div>
                    <div class="col-6">
                        <h6 class="text-danger fw-bold">178</h6>
                        <small class="text-muted">Perempuan</small>
                    </div>
                </div>
                <hr>
                <div class="text-center mb-3">
                    <h6 class="text-success fw-bold">10.54 km²</h6>
                    <small class="text-muted">Luas Wilayah</small>
                </div>
                <div class="row text-center">
                    <div class="col-4">
                        <h6 class="text-warning fw-bold">206</h6>
                        <small class="text-muted">Petani</small>
                    </div>
                    <div class="col-4">
                        <h6 class="text-info fw-bold">57</h6>
                        <small class="text-muted">Pedagang</small>
                    </div>
                    <div class="col-4">
                        <h6 class="text-danger fw-bold">102</h6>
                        <small class="text-muted">Pelajar</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2 text-primary"></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Berita
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-success w-100">
                            <i class="fas fa-users me-2"></i>
                            Update Data Penduduk
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-warning w-100">
                            <i class="fas fa-seedling me-2"></i>
                            Update Data Pertanian
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-info w-100">
                            <i class="fas fa-user-plus me-2"></i>
                            Tambah User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Desa -->
<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="card fade-in">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Informasi Desa
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        <span role="button" class="open-image" data-src="{{ asset('FOTO/DSC_0596.JPG') }}">
                            <img src="{{ asset('FOTO/DSC_0596.JPG') }}" alt="Kepala Desa Abdullah, SP" class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                        </span>
                        <h6 class="text-primary fw-bold">Abdullah, SP</h6>
                        <small class="text-muted">Kepala Desa</small>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Masa Jabatan:</strong><br>2024 - Sekarang</p>
                                <p><strong>Kecamatan:</strong><br>Lambuya</p>
                            </div>
                            <div class="col-6">
                                <p><strong>Kabupaten:</strong><br>Konawe</p>
                                <p><strong>Provinsi:</strong><br>Sulawesi Tenggara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card fade-in">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-map-marked-alt me-2 text-primary"></i>
                    Batas Wilayah
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-arrow-up text-danger me-2"></i><strong>Utara:</strong> Kecamatan Onembute</li>
                    <li><i class="fas fa-arrow-right text-primary me-2"></i><strong>Timur:</strong> Kecamatan Onembute</li>
                    <li><i class="fas fa-arrow-down text-success me-2"></i><strong>Selatan:</strong> Desa Wonua Hoa dan Asaki</li>
                    <li><i class="fas fa-arrow-left text-warning me-2"></i><strong>Barat:</strong> Desa Amberi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Image Preview Modal -->
<div class="modal fade" id="dashboardImagePreviewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content" style="background: transparent; border: none;">
      <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
      <img id="dashboardImagePreviewModalImg" src="" alt="Preview" style="width:100%; height:auto; border-radius:12px; box-shadow:0 20px 40px rgba(0,0,0,.4);">
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
