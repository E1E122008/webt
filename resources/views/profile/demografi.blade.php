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
                        @forelse($facilitiesByBidang as $bidang => $items)
                            <h4 class="mt-4 mb-3 text-uppercase">{{ $bidang ?? 'Lainnya' }}</h4>
                            <div class="row">
                                @foreach($items as $facility)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="facility-card">
                                            <div class="facility-header">
                                                <i class="fas fa-tools fa-2x text-info"></i>
                                                <h5 class="text-info">{{ $facility->nama }}</h5>
                                            </div>
                                            <div class="facility-body">
                                                @if($facility->gambar)
                                                    <img src="{{ asset('storage/' . $facility->gambar) }}" alt="{{ $facility->nama }}" class="img-fluid mb-2" style="max-height:100px;">
                                                @endif
                                                <p>{{ $facility->deskripsi }}</p>
                                                <span class="badge bg-secondary">{{ ucfirst($facility->jenis) }}</span>
                                                <span class="badge bg-success">{{ ucfirst($facility->status) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center">Belum ada data sarana atau prasarana.</p>
                            </div>
                        @endforelse
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
</script>
@endsection
