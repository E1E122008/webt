@extends('layouts.app')

@section('title', 'Demografi Desa - Desa Tetembomua')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Profil Desa</a></li>
            <li class="breadcrumb-item active">Demografi</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold mb-4">Demografi Desa Tetembomua</h1>
                    <p class="lead mb-4">Data kependudukan dan kondisi sosial ekonomi masyarakat Desa Tetembomua tahun 2024</p>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-chart-pie fa-6x text-white opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<!-- Demografi Section -->
<section class="section">
    <div class="container">
        <!-- Demografi Penduduk: Diagram Usia & Jenis Kelamin -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <i class="fas fa-people-arrows fa-4x text-primary mb-3"></i>
                            <h2 class="text-primary fw-bold">DEMOGRAFI PENDUDUK</h2>
                            <p class="text-muted">Distribusi usia dan rasio jenis kelamin</p>
                        </div>

                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="chart-container">
                                    <h5 class="mb-3">Distribusi Usia</h5>
                                    <canvas id="ageChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="chart-container">
                                    <h5 class="mb-3">Rasio Jenis Kelamin</h5>
                                    <canvas id="genderChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kondisi Geografis -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <i class="fas fa-map-marked-alt fa-4x text-primary mb-3"></i>
                            <h2 class="text-primary fw-bold">KONDISI GEOGRAFIS</h2>
                        </div>

                        <div class="row">
            <div class="col-lg-6 mb-4">
                                <div class="info-card">
                                    <div class="info-header">
                                        <i class="fas fa-location-arrow fa-2x text-success"></i>
                                        <h5 class="text-success">Letak dan Luas Wilayah</h5>
                                    </div>
                                    <div class="info-body">
                                        <p><strong>Jarak dari Ibu Kota Kabupaten:</strong> 62 km</p>
                                        <p><strong>Luas Wilayah:</strong> 10,54 km²</p>
                                        <p><strong>Kode Pos:</strong> 93464</p>
                                    </div>
                </div>
            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="info-card">
                                    <div class="info-header">
                                        <i class="fas fa-border-all fa-2x text-warning"></i>
                                        <h5 class="text-warning">Batas Wilayah</h5>
                                    </div>
                                    <div class="info-body">
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

                        <div class="row">
                            <div class="col-12">
                                <div class="info-card">
                                    <div class="info-header">
                                        <i class="fas fa-road fa-2x text-info"></i>
                                        <h5 class="text-info">Lokasi Strategis</h5>
                                    </div>
                                    <div class="info-body">
                                        <p>Desa Tetembomua berada di jalan provinsi penghubung antara Kabupaten Konawe Utara dan Kabupaten Konawe serta jalan utama menuju Provinsi Sulawesi Selatan dan Tengah. Hal ini membuat potensi di bidang perdagangan sangat berpeluang tumbuh pesat.</p>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Data Kependudukan -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <i class="fas fa-users fa-4x text-success mb-3"></i>
                            <h2 class="text-success fw-bold">DATA KEPENDUDUKAN</h2>
                            <p class="text-muted">Tahun 2024</p>
                        </div>

                        <!-- Statistik Utama -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-users fa-3x text-primary"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3 class="text-primary fw-bold">402</h3>
                                        <p class="text-muted">Total Penduduk</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-home fa-3x text-success"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3 class="text-success fw-bold">118</h3>
                                        <p class="text-muted">Total KK</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-male fa-3x text-info"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3 class="text-info fw-bold">222</h3>
                                        <p class="text-muted">Laki-laki</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-female fa-3x text-warning"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3 class="text-warning fw-bold">178</h3>
                                        <p class="text-muted">Perempuan</p>
        </div>
                    </div>
                </div>
            </div>

                        <!-- Tabel Data per RT -->
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-center mb-4">
                                    <i class="fas fa-table me-2 text-primary"></i>
                                    DATA PENDUDUK PER RT
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>RT</th>
                                                <th>KK</th>
                                                <th>KK (Laki-laki)</th>
                                                <th>KK (Perempuan)</th>
                                                <th>Laki-laki (Jiwa)</th>
                                                <th>Perempuan (Jiwa)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>01</strong></td>
                                                <td>11</td>
                                                <td>10</td>
                                                <td>1</td>
                                                <td>30</td>
                                                <td>18</td>
                                            </tr>
                                            <tr>
                                                <td><strong>02</strong></td>
                                                <td>14</td>
                                                <td>11</td>
                                                <td>3</td>
                                                <td>25</td>
                                                <td>21</td>
                                            </tr>
                                            <tr>
                                                <td><strong>03</strong></td>
                                                <td>13</td>
                                                <td>12</td>
                                                <td>1</td>
                                                <td>29</td>
                                                <td>22</td>
                                            </tr>
                                            <tr>
                                                <td><strong>04</strong></td>
                                                <td>25</td>
                                                <td>19</td>
                                                <td>6</td>
                                                <td>35</td>
                                                <td>28</td>
                                            </tr>
                                            <tr>
                                                <td><strong>05</strong></td>
                                                <td>22</td>
                                                <td>21</td>
                                                <td>1</td>
                                                <td>50</td>
                                                <td>40</td>
                                            </tr>
                                            <tr>
                                                <td><strong>06</strong></td>
                                                <td>33</td>
                                                <td>27</td>
                                                <td>6</td>
                                                <td>62</td>
                                                <td>49</td>
                                            </tr>
                                            <tr class="table-active">
                                                <td><strong>Total</strong></td>
                                                <td><strong>118</strong></td>
                                                <td><strong>100</strong></td>
                                                <td><strong>18</strong></td>
                                                <td><strong>222</strong></td>
                                                <td><strong>178</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-5">
                                    <h4 class="text-center mb-4">
                                        <i class="fas fa-table me-2 text-success"></i>
                                        DATA PENDUDUK PER DUSUN
                                    </h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Dusun</th>
                                                    <th>Laki-laki</th>
                                                    <th>Perempuan</th>
                                                    <th>Total</th>
                                                    <th>KK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Dusun I</td>
                                                    <td>485</td>
                                                    <td>512</td>
                                                    <td>997</td>
                                                    <td>245</td>
                                                </tr>
                                                <tr>
                                                    <td>Dusun II</td>
                                                    <td>423</td>
                                                    <td>456</td>
                                                    <td>879</td>
                                                    <td>198</td>
                                                </tr>
                                                <tr>
                                                    <td>Dusun III</td>
                                                    <td>467</td>
                                                    <td>504</td>
                                                    <td>971</td>
                                                    <td>242</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>

        <!-- Mata Pencaharian -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <i class="fas fa-briefcase fa-4x text-warning mb-3"></i>
                            <h2 class="text-warning fw-bold">MATA PENCAHARIAN PENDUDUK</h2>
                            <p class="text-muted">Tahun 2024</p>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>No.</th>
                                                <th>Pekerjaan</th>
                                                <th>Jumlah</th>
                                                <th>Persentase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><strong>Tani</strong></td>
                                                <td>206</td>
                                                <td>51.0%</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><strong>Pedagang</strong></td>
                                                <td>57</td>
                                                <td>14.1%</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><strong>Pelajar/Mahasiswa</strong></td>
                                                <td>102</td>
                                                <td>25.2%</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td><strong>Ibu Rumah Tangga</strong></td>
                                                <td>96</td>
                                                <td>23.8%</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td><strong>Wiraswasta</strong></td>
                                                <td>28</td>
                                                <td>6.9%</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td><strong>Karyawan</strong></td>
                                                <td>25</td>
                                                <td>6.2%</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td><strong>Jasa</strong></td>
                                                <td>7</td>
                                                <td>1.7%</td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td><strong>Buruh Batu</strong></td>
                                                <td>5</td>
                                                <td>1.2%</td>
                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td><strong>Buruh Kayu</strong></td>
                                                <td>4</td>
                                                <td>1.0%</td>
                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td><strong>ASN/TNI/POLRI</strong></td>
                                                <td>1</td>
                                                <td>0.2%</td>
                                            </tr>
                                            <tr>
                                                <td>11</td>
                                                <td><strong>Belum/Tidak Bekerja</strong></td>
                                                <td>19</td>
                                                <td>4.7%</td>
                                            </tr>
                                            <tr>
                                                <td>12</td>
                                                <td><strong>Lain lain</strong></td>
                                                <td>2</td>
                                                <td>0.5%</td>
                                            </tr>
                                            <tr class="table-active">
                                                <td colspan="2"><strong>Total</strong></td>
                                                <td><strong>404</strong></td>
                                                <td><strong>100%</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="chart-container">
                                    <canvas id="occupationChart" width="400" height="400"></canvas>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- UMKM -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-store fa-3x text-warning mb-3"></i>
                            <h3 class="text-warning fw-bold">DATA UMKM DESA</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-warning">
                                    <tr>
                                        <th>Jenis Usaha</th>
                                        <th>Jumlah Unit</th>
                                        <th>Tenaga Kerja</th>
                                        <th>Omset (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Warung Makan</td>
                                        <td>15</td>
                                        <td>45</td>
                                        <td>150.000.000</td>
                                    </tr>
                                    <tr>
                                        <td>Kerajinan Tangan</td>
                                        <td>8</td>
                                        <td>24</td>
                                        <td>75.000.000</td>
                                    </tr>
                                    <tr>
                                        <td>Konveksi</td>
                                        <td>5</td>
                                        <td>20</td>
                                        <td>120.000.000</td>
                                    </tr>
                                    <tr>
                                        <td>Jasa</td>
                                        <td>12</td>
                                        <td>36</td>
                                        <td>90.000.000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $facilitiesByBidang = isset($facilities) ? $facilities->groupBy('bidang') : collect();
        @endphp
        <!-- Sarana Prasarana -->
        <div class="row">
            <div class="col-12">
                <div class="card fade-in">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <i class="fas fa-building fa-4x text-info mb-3"></i>
                            <h2 class="text-info fw-bold">SARANA PRASARANA</h2>
                        </div>
                        <div class="row justify-content-center">
                            @if($facilitiesByBidang->count() > 0)
                                @foreach($facilitiesByBidang as $bidang => $items)
                                    @if($items->count() > 0)
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="facility-category-card">
                                                <div class="facility-category-header">
                                                    @php
                                                        $categoryIcons = [
                                                            'Kesehatan' => 'fas fa-heartbeat',
                                                            'Pendidikan' => 'fas fa-graduation-cap', 
                                                            'Keagamaan' => 'fas fa-mosque',
                                                            'Infrastruktur' => 'fas fa-tools',
                                                            'Air & Sanitasi' => 'fas fa-tint',
                                                            'Olahraga & Rekreasi' => 'fas fa-dumbbell',
                                                            'Lainnya' => 'fas fa-building'
                                                        ];
                                                        $categoryColors = [
                                                            'Kesehatan' => 'text-danger',
                                                            'Pendidikan' => 'text-primary',
                                                            'Keagamaan' => 'text-success',
                                                            'Infrastruktur' => 'text-warning',
                                                            'Air & Sanitasi' => 'text-info',
                                                            'Olahraga & Rekreasi' => 'text-success',
                                                            'Lainnya' => 'text-secondary'
                                                        ];
                                                        $icon = $categoryIcons[$bidang] ?? 'fas fa-building';
                                                        $color = $categoryColors[$bidang] ?? 'text-secondary';
                                                    @endphp
                                                    <i class="{{ $icon }} fa-2x {{ $color }}"></i>
                                                    <h5 class="{{ $color }}">{{ $bidang ?? 'Lainnya' }}</h5>
                                                </div>
                                                <div class="facility-category-body">
                                                    @php
                                                        $totalUnits = $items->sum('jumlah_unit');
                                                    @endphp
                                                    @foreach($items as $facility)
                                                            <div class="facility-item-content">
                                                                <div class="facility-info">
                                                                    <span class="facility-name" 
                                                                          title="{{ $facility->nama }}"
                                                                          data-bs-toggle="tooltip" 
                                                                          data-bs-placement="top">
                                                                        {{ $facility->nama }}
                                                                    </span>
                                                                    <span class="facility-count">{{ $facility->jumlah_unit }} unit</span>
                                                                </div>
                                                                <div class="facility-status">
                                                                    @if($facility->status == 'aktif')
                                                                        <span class="text-success" title="Status: Aktif">
                                                                            <i class="fas fa-check"></i>
                                                                        </span>
                                                                    @else
                                                                        <span class="text-danger" title="Status: Nonaktif">
                                                                            <i class="fas fa-times"></i>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if($facility->deskripsi)
                                                                <div class="facility-description" 
                                                                     title="{{ $facility->deskripsi }}"
                                                                     data-bs-toggle="tooltip" 
                                                                     data-bs-placement="bottom">
                                                                    <small class="text-muted">
                                                                        {{ Str::limit($facility->deskripsi, 50) }}
                                                                        @if(strlen($facility->deskripsi) > 50)
                                                                            <span class="text-primary">...lihat selengkapnya</span>
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                    @if($totalUnits > 0)
                                                        <div class="facility-total text-center mt-3">
                                                            <small class="text-muted">(jumlah {{ $totalUnits }})</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <i class="fas fa-building fa-4x text-muted mb-4"></i>
                                        <h4 class="text-muted">Belum ada data sarana atau prasarana</h4>
                                        <p class="text-muted">Data sarana dan prasarana akan ditampilkan di sini.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.info-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-green);
    height: 100%;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(46, 139, 87, 0.2);
}

.info-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(46, 139, 87, 0.1);
}

.info-header i {
    margin-right: 1rem;
}

.info-header h5 {
    margin-bottom: 0;
    font-weight: 600;
}

.info-body p, .info-body li {
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-green);
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(46, 139, 87, 0.2);
}

.stat-icon {
    margin-bottom: 1rem;
}

.stat-content h3 {
    margin-bottom: 0.5rem;
}

.facility-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-green);
    height: 100%;
    transition: all 0.3s ease;
}

.facility-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(46, 139, 87, 0.2);
}

.facility-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(46, 139, 87, 0.1);
}

.facility-header i {
    margin-right: 1rem;
}

.facility-header h5 {
    margin-bottom: 0;
    font-weight: 600;
}

.facility-body li {
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.chart-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    text-align: center;
}

.facility-category-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-green);
    height: 100%;
    transition: all 0.3s ease;
    margin: 0 auto;
    max-width: 500px;
}

.facility-category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(46, 139, 87, 0.2);
}

.facility-category-header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(46, 139, 87, 0.1);
    text-align: center;
}

.facility-category-header h5 {
    text-align: center;
    width: 100%;
}

.facility-category-header i {
    margin-right: 1rem;
}

.facility-category-header h5 {
    margin-bottom: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.facility-category-body {
    margin-bottom: 1.5rem;
    text-align: center;
}

.facility-total {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(46, 139, 87, 0.1);
}

.facility-item {
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: rgba(46, 139, 87, 0.05);
    border-radius: 8px;
    border-left: 3px solid var(--primary-green);
}

.facility-item:last-child {
    margin-bottom: 0;
}

.facility-item {
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: rgba(46, 139, 87, 0.05);
    border-radius: 8px;
    border-left: 3px solid var(--primary-green);
    transition: all 0.3s ease;
}

.facility-item:hover {
    background: rgba(46, 139, 87, 0.1);
    transform: translateX(2px);
}

.facility-item:last-child {
    margin-bottom: 0;
}

.facility-item-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.25rem;
}

.facility-info {
    display: flex;
    align-items: center;
    flex-grow: 1;
    gap: 1rem;
    min-width: 0; /* Allow text truncation */
}

.facility-name {
    font-weight: 500;
    color: var(--text-dark);
    flex-grow: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
    cursor: help;
}

.facility-count {
    font-size: 0.9rem;
    color: var(--text-light);
    white-space: nowrap;
    flex-shrink: 0;
}

.facility-status {
    font-size: 1.1rem;
    flex-shrink: 0;
    margin-left: 0.5rem;
}

.facility-description {
    font-size: 0.8rem;
    display: block;
    margin-top: 0.25rem;
    cursor: help;
    word-wrap: break-word;
    line-height: 1.3;
}

.facility-description:hover {
    color: var(--primary-green) !important;
}

/* Tooltip customization */
.tooltip {
    font-size: 0.875rem;
}

.tooltip .tooltip-inner {
    max-width: 300px;
    text-align: left;
    background-color: rgba(0, 0, 0, 0.9);
    border-radius: 8px;
    padding: 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .facility-category-card {
        max-width: 100%;
        margin: 0 1rem;
    }
    
    .facility-name {
        max-width: 150px;
    }
    
    .facility-info {
        gap: 0.5rem;
    }
    
    .facility-item-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .facility-status {
        margin-left: 0;
        align-self: flex-end;
    }
}

/* Empty state styling */
.facility-item.empty {
    background: rgba(108, 117, 125, 0.05);
    border-left-color: #6c757d;
}

.facility-item.empty .facility-name {
    color: #6c757d;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart distribusi usia
    const ageEl = document.getElementById('ageChart');
    if (ageEl) {
        const ageCtx = ageEl.getContext('2d');
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60+'],
                datasets: [{
                    label: 'Laki-laki',
                    data: [89, 95, 102, 98, 85, 92, 88, 76, 68, 62, 58, 52, 78],
                    backgroundColor: '#2E8B57',
                    borderColor: '#2E8B57',
                    borderWidth: 1
                }, {
                    label: 'Perempuan',
                    data: [92, 98, 105, 102, 88, 95, 92, 78, 72, 65, 60, 55, 82],
                    backgroundColor: '#3CB371',
                    borderColor: '#3CB371',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Chart rasio gender
    const genderEl = document.getElementById('genderChart');
    if (genderEl) {
        const genderCtx = genderEl.getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [1375, 1472],
                    backgroundColor: ['#2E8B57', '#3CB371'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
});
// Chart untuk mata pencaharian
const ctx = document.getElementById('occupationChart').getContext('2d');
const occupationChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Tani', 'Pedagang', 'Pelajar/Mahasiswa', 'Ibu Rumah Tangga', 'Wiraswasta', 'Karyawan', 'Lainnya'],
        datasets: [{
            data: [206, 57, 102, 96, 28, 25, 30],
            backgroundColor: [
                '#2E8B57',
                '#3CB371',
                '#20B2AA',
                '#FFD700',
                '#FFA500',
                '#FF6347',
                '#9370DB'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            },
            title: {
                display: true,
                text: 'Mata Pencaharian Penduduk',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            }
        }
    }
});

// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            delay: { show: 500, hide: 100 },
            html: true
        });
    });
    
    // Add click to copy functionality for facility names
    document.querySelectorAll('.facility-name').forEach(function(element) {
        element.addEventListener('click', function() {
            // Copy text to clipboard
            navigator.clipboard.writeText(this.textContent).then(function() {
                // Show temporary success message
                var originalText = element.textContent;
                element.textContent = 'Copied!';
                element.style.color = 'var(--primary-green)';
                
                setTimeout(function() {
                    element.textContent = originalText;
                    element.style.color = '';
                }, 1000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        });
    });
});
</script>
@endsection
