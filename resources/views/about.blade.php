@extends('layouts.app')

@section('title', 'Tentang ' . ($siteSettings['village_name'] ?? 'Desa Tetembomua'))

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold mb-4">Tentang {{ $siteSettings['village_name'] ?? 'Desa Tetembomua' }}</h1>
                    <p class="lead mb-4">{{ $siteSettings['village_description'] ?? 'Desa yang maju dan berbudaya dengan masyarakat yang ramah, produktif, dan komitmen untuk mengembangkan desa secara berkelanjutan' }}</p>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-home fa-6x text-white opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section">
    <div class="container">
        <!-- Gambaran Umum Desa -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-info-circle fa-3x text-primary mb-3"></i>
                            <h2 class="text-primary fw-bold">GAMBARAN UMUM DESA</h2>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <h5 class="text-primary">Lokasi</h5>
                                        <p>{{ $siteSettings['contact_address'] ?? ('Desa ' . ($siteSettings['village_name'] ?? 'Tetembomua') . ', Kecamatan ' . ($siteSettings['district'] ?? 'Lambuya') . ', Kabupaten ' . ($siteSettings['regency'] ?? 'Konawe') . ', Provinsi ' . ($siteSettings['province'] ?? 'Sulawesi Tenggara')) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="fas fa-ruler-combined fa-2x text-success"></i>
                                    </div>
                                    <div class="info-content">
                                        <h5 class="text-success">Luas Wilayah</h5>
                                        <p>{{ $siteSettings['area'] ?? '10,54 km² dengan jarak 62 km dari ibu kota Kabupaten Konawe' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="fas fa-users fa-2x text-warning"></i>
                                    </div>
                                    <div class="info-content">
                                        <h5 class="text-warning">Penduduk</h5>
                                        <p>402 jiwa (222 laki-laki, 178 perempuan) tersebar di 6 RT dengan 118 KK</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="fas fa-seedling fa-2x text-info"></i>
                                    </div>
                                    <div class="info-content">
                                        <h5 class="text-info">Mata Pencaharian</h5>
                                        <p>Mayoritas petani (51%) dengan komoditas utama sawit, kakao, dan lada</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sejarah Desa -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-history fa-3x text-success mb-3"></i>
                            <h2 class="text-success fw-bold">SEJARAH TERBENTUKNYA DESA</h2>
                        </div>

                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h5 class="text-primary">Sebelum 1999</h5>
                                    <p>Daerah ini termasuk dalam Desa Awuliti yang wilayah Kecamatan Lambuya Kabupaten Konawe.</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h5 class="text-success">Tahun 1999</h5>
                                    <p>Terjadi pemekaran Desa menjadi 2 Desa yaitu Awuliti dan Desa Amberi.</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h5 class="text-warning">Tahun 2007</h5>
                                    <p>Sebelum terbentuknya Desa Tetembomua adalah salah satu Dusun III pada saat bergabung dengan Desa Amberi, kemudian dimekarkan menjadi Desa Persiapan.</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h5 class="text-info">Tahun 2008</h5>
                                    <p>Desa Tetembomua menjadi Desa Definitif sesuai dengan Peraturan Pemerintah yang berlaku.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asal Usul Nama Desa -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-landmark fa-3x text-warning mb-3"></i>
                            <h2 class="text-warning fw-bold">ASAL USUL NAMA DESA</h2>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-6 text-center">
                                <i class="fas fa-bridge fa-4x text-primary mb-3"></i>
                                <h4 class="text-primary">{{ $siteSettings['village_name'] ?? 'Tetembomua' }}</h4>
                            </div>
                            <div class="col-md-6">
                                <p class="lead">
                                    Menurut Mantan Kepala Desa Almarhum Asrin dan penjelasan tokoh-tokoh masyarakat, 
                                    nama "Tetembomua" berasal dari Bahasa Tolaki yang artinya <strong>"Titian atau Jembatan yang Mendaki menyebrang Kali"</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kepemimpinan Saat Ini -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-tie fa-3x text-success mb-3"></i>
                            <h2 class="text-success fw-bold">KEPEMIMPINAN SAAT INI</h2>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="leadership-card">
                                    <div class="leadership-avatar">
                                        <span role="button" class="open-image" data-src="{{ isset($struktur['kades']['photo']) && $struktur['kades']['photo'] ? $struktur['kades']['photo'] : asset('FOTO/DSC_0596.JPG') }}">
                                            <img src="{{ isset($struktur['kades']['photo']) && $struktur['kades']['photo'] ? $struktur['kades']['photo'] : asset('FOTO/DSC_0596.JPG') }}" alt="Kepala Desa" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                        </span>
                                    </div>
                                    <div class="leadership-info">
                                        <h4 class="text-primary">{{ $struktur['kades']['name'] ?? 'Abdullah, SP' }}</h4>
                                        <p class="text-muted">Kepala Desa</p>
                                        <p><strong>Masa Jabatan:</strong> {{ $struktur['kades']['info'] ?? '2024 - Sekarang' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="leadership-card">
                                    <div class="leadership-avatar">
                                        @php
                                            $sekretaris = collect($struktur['entries']['perangkat'] ?? [])->firstWhere('role_type', 'sekretaris') ?? 
                                                        collect($struktur['entries']['perangkat'] ?? [])->firstWhere('role_text', 'Sekretaris Desa');
                                        @endphp
                                        @if($sekretaris && !empty($sekretaris['photo']))
                                            <span role="button" class="open-image" data-src="{{ $sekretaris['photo'] }}">
                                                <img src="{{ $sekretaris['photo'] }}" alt="Sekretaris Desa" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                            </span>
                                        @else
                                            <i class="fas fa-user fa-4x text-muted"></i>
                                        @endif
                                    </div>
                                    <div class="leadership-info">
                                        <h4 class="text-success">{{ $sekretaris['name'] ?? 'Sekretaris Desa' }}</h4>
                                        <p class="text-muted">Sekretaris Desa</p>
                                        <p><strong>Periode:</strong> {{ $sekretaris['info'] ?? '2024 - Sekarang' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visi Desa -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-bullseye fa-3x text-danger mb-3"></i>
                            <h2 class="text-danger fw-bold">VISI DESA</h2>
                        </div>

                        <div class="vision-box">
                            <blockquote class="blockquote text-center">
                                <p class="mb-0 lead fw-bold">
                                    "MEWUJUDKAN PEMERINTAH DESA YANG JUJUR, TRANSPARAN, ADIL, PARTISIPATIF, 
                                    DAN MENJADIKAN DESA AGRO WISATA BERBASIS PADA EKONOMI KREATIF, 
                                    MENUJU MASYARAKAT YANG BERIMAN, BERTAQWA, NYAMAN, INOVATIF, MAJU, SEJAHTERA, MANDIRI, DAN BERADAB"
                                </p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Potensi Unggulan -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                            <h2 class="text-info fw-bold">POTENSI UNGGULAN</h2>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="potential-card">
                                    <div class="potential-icon">
                                        <i class="fas fa-seedling fa-3x text-success"></i>
                                    </div>
                                    <h5 class="text-success">Pertanian & Perkebunan</h5>
                                    <p>Komoditas utama: Kelapa Sawit, Kakao, dan Lada dengan total lahan pertanian yang luas.</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="potential-card">
                                    <div class="potential-icon">
                                        <i class="fas fa-road fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="text-primary">Lokasi Strategis</h5>
                                    <p>Berada di jalan provinsi penghubung antar kabupaten dan provinsi, potensial untuk perdagangan.</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="potential-card">
                                    <div class="potential-icon">
                                        <i class="fas fa-users fa-3x text-warning"></i>
                                    </div>
                                    <h5 class="text-warning">SDM Berkualitas</h5>
                                    <p>Mayoritas penduduk adalah petani berpengalaman dengan semangat gotong royong yang tinggi.</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="potential-card">
                                    <div class="potential-icon">
                                        <i class="fas fa-leaf fa-3x text-success"></i>
                                    </div>
                                    <h5 class="text-success">Agro Wisata</h5>
                                    <p>Potensi pengembangan desa agro wisata dengan keindahan alam dan pertanian yang menarik.</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="potential-card">
                                    <div class="potential-icon">
                                        <i class="fas fa-handshake fa-3x text-info"></i>
                                    </div>
                                    <h5 class="text-info">Gotong Royong</h5>
                                    <p>Semangat kebersamaan dan gotong royong masyarakat yang kuat dalam membangun desa.</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="potential-card">
                                    <div class="potential-icon">
                                        <i class="fas fa-mosque fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="text-primary">Religius</h5>
                                    <p>Masyarakat yang religius dengan kegiatan keagamaan yang aktif dan harmonis.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Program SDGs Desa -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-globe fa-3x text-info mb-3"></i>
                            <h2 class="text-info fw-bold">PROGRAM SDGs DESA</h2>
                            <p class="text-muted">Sustainable Development Goals untuk pembangunan berkelanjutan</p>
                        </div>

                        <!-- SDGs Program Cards -->
                        <div class="row g-4">
                            <!-- SDG 1: No Poverty -->
                            <div class="col-lg-3 col-md-6">
                                <div class="sdgs-card sdgs-1">
                                    <div class="sdgs-number">1</div>
                                    <h5>Tanpa Kemiskinan</h5>
                                    <p>Program pemberdayaan ekonomi masyarakat miskin</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check"></i>Bantuan UMKM</li>
                                        <li><i class="fas fa-check"></i>Pelatihan Wirausaha</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- SDG 2: Zero Hunger -->
                            <div class="col-lg-3 col-md-6">
                                <div class="sdgs-card sdgs-2">
                                    <div class="sdgs-number">2</div>
                                    <h5>Tanpa Kelaparan</h5>
                                    <p>Program ketahanan pangan dan pertanian berkelanjutan</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check"></i>Diversifikasi Pangan</li>
                                        <li><i class="fas fa-check"></i>Pertanian Organik</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- SDG 3: Good Health -->
                            <div class="col-lg-3 col-md-6">
                                <div class="sdgs-card sdgs-3">
                                    <div class="sdgs-number">3</div>
                                    <h5>Kehidupan Sehat</h5>
                                    <p>Program kesehatan dan kesejahteraan masyarakat</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check"></i>Posyandu Lansia</li>
                                        <li><i class="fas fa-check"></i>Sanitasi Lingkungan</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- SDG 4: Quality Education -->
                            <div class="col-lg-3 col-md-6">
                                <div class="sdgs-card sdgs-4">
                                    <div class="sdgs-number">4</div>
                                    <h5>Pendidikan Berkualitas</h5>
                                    <p>Program pendidikan yang inklusif dan berkualitas</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check"></i>Beasiswa Anak</li>
                                        <li><i class="fas fa-check"></i>Perpustakaan Desa</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.info-box {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(46, 139, 87, 0.05), rgba(60, 179, 113, 0.02));
    border-radius: 15px;
    border-left: 4px solid var(--primary-green);
}

.info-icon {
    margin-right: 1rem;
    flex-shrink: 0;
}

.info-content h5 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.info-content p {
    margin-bottom: 0;
    color: var(--text-dark);
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, var(--primary-green), var(--accent-teal));
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.2);
}

.timeline-content {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-green);
}

.timeline-content h5 {
    margin-bottom: 10px;
    font-weight: 600;
}

.timeline-content p {
    margin-bottom: 0;
    color: var(--text-light);
}

.vision-box {
    background: linear-gradient(135deg, rgba(46, 139, 87, 0.1), rgba(60, 179, 113, 0.05));
    border: 2px solid var(--primary-green);
    border-radius: 20px;
    padding: 3rem;
    position: relative;
    overflow: hidden;
}

.vision-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    animation: shine 3s ease-in-out infinite;
}

@keyframes shine {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

.potential-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-green);
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
}

.potential-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(46, 139, 87, 0.2);
}

.potential-icon {
    margin-bottom: 1.5rem;
}

.potential-card h5 {
    margin-bottom: 1rem;
    font-weight: 600;
}

.potential-card p {
    color: var(--text-light);
    margin-bottom: 0;
}

.leadership-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-green);
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
}

.leadership-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(46, 139, 87, 0.2);
}

.leadership-avatar {
    margin-bottom: 1.5rem;
}

.leadership-info h4 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.leadership-info p {
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.leadership-info p:last-child {
    margin-bottom: 0;
}

.open-image {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.open-image:hover {
    transform: scale(1.05);
}

/* ========================================
   SDGs CARDS STYLING
   ======================================== */

.sdgs-card {
    background: white;
    color: #333;
    padding: 1.5rem;
    border-radius: 12px;
    text-align: left;
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-left: 4px solid;
}

.sdgs-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* SDGs Number */
.sdgs-number {
    font-size: 2.5rem;
    font-weight: 700;
    opacity: 0.3;
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: #333;
    line-height: 1;
}

/* SDGs Card Content */
.sdgs-card h5 {
    font-weight: 600;
    margin-bottom: 0.75rem;
    position: relative;
    z-index: 1;
    color: #333;
    padding-right: 3rem;
    font-size: 1.1rem;
}

.sdgs-card p {
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
    color: #666;
    font-size: 0.85rem;
    line-height: 1.4;
}

/* SDGs List */
.sdgs-card ul {
    margin: 0;
    padding: 0;
}

.sdgs-card ul li {
    margin-bottom: 0.4rem;
    position: relative;
    z-index: 1;
    color: #555;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
}

.sdgs-card .fas.fa-check {
    color: #28a745;
    margin-right: 0.5rem;
    font-size: 0.7rem;
}

/* SDGs Color Themes */
.sdgs-1 { border-left-color: #E5243B; } /* SDG 1 - Red */
.sdgs-2 { border-left-color: #DDA63A; } /* SDG 2 - Yellow/Orange */
.sdgs-3 { border-left-color: #4C9F38; } /* SDG 3 - Green */
.sdgs-4 { border-left-color: #C5192D; } /* SDG 4 - Red/Pink */
</style>

<!-- Image Preview Modal -->
<div class="modal fade" id="aboutImagePreviewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content" style="background: transparent; border: none;">
      <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
      <img id="aboutImagePreviewModalImg" src="" alt="Preview" style="width:100%; height:auto; border-radius:12px; box-shadow:0 20px 40px rgba(0,0,0,.4);">
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewModal = document.getElementById('aboutImagePreviewModal');
    const previewImg = document.getElementById('aboutImagePreviewModalImg');
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

@endsection
