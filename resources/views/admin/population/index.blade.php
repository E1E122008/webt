@extends('admin.layouts.app')

@section('title', 'Kelola Data Penduduk')

@section('content')
<!-- Content Header -->
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-users me-2"></i>Kelola Data Penduduk</h2>
            <p class="text-muted mb-0">Manajemen data penduduk Desa Tetembomua per dusun</p>
        </div>
        <div>
            <button class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                <i class="fas fa-file-csv me-2"></i>Import CSV
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPopulationModal">
                <i class="fas fa-plus me-2"></i>Tambah Data
            </button>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#2E8B57'
            });
        });
    </script>
@endif
@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#2E8B57'
            });
        });
    </script>
@endif

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card slide-in">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 text-primary">{{ $populations->count() }}</h3>
                    <small class="text-muted">Total Penduduk</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card success slide-in">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 text-success">{{ $populations->where('dusun_id', 1)->count() }}</h3>
                    <small class="text-muted">Dusun 1</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-map-marker-alt text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card warning slide-in">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 text-warning">{{ $populations->where('dusun_id', 2)->count() }}</h3>
                    <small class="text-muted">Dusun 2</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-map-marker-alt text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card info slide-in">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 text-info">{{ $populations->where('dusun_id', 3)->count() }}</h3>
                    <small class="text-muted">Dusun 3</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-map-marker-alt text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search -->
<div class="card mb-4 fade-in">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <label class="form-label">Cari Data</label>
                <input type="text" class="form-control" id="searchInput" placeholder="Nama, NIK, atau No. KK...">
            </div>
        </div>
    </div>
</div>

<!-- Tab Navigation -->
<ul class="nav nav-tabs mb-4" id="populationTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
            <i class="fas fa-list me-2"></i>Semua Data
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="dusun1-tab" data-bs-toggle="tab" data-bs-target="#dusun1" type="button" role="tab">
            <i class="fas fa-map-marker-alt me-2"></i>Dusun 1
            <span class="badge bg-success ms-2">{{ $populations->where('dusun_id', 1)->count() }}</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="dusun2-tab" data-bs-toggle="tab" data-bs-target="#dusun2" type="button" role="tab">
            <i class="fas fa-map-marker-alt me-2"></i>Dusun 2
            <span class="badge bg-warning ms-2">{{ $populations->where('dusun_id', 2)->count() }}</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="dusun3-tab" data-bs-toggle="tab" data-bs-target="#dusun3" type="button" role="tab">
            <i class="fas fa-map-marker-alt me-2"></i>Dusun 3
            <span class="badge bg-info ms-2">{{ $populations->where('dusun_id', 3)->count() }}</span>
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="populationTabsContent">
    <!-- All Data Tab -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        <div class="card fade-in">
            <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0" id="populationTable">
            <thead class="table-dark sticky-top">
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Data Pribadi</th>
                    <th width="15%">Alamat & KK</th>
                    <th width="15%">Status Sosial</th>
                    <th width="15%">Data Pertanian</th>
                    <th width="10%">Dusun</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sorted = $populations->sortBy(function($p){
                        $rel = strtoupper(trim($p->hubungan_kepala_keluarga ?? ''));
                        $priorityMap = [
                            'KK' => 0,
                            'KEPALA KELUARGA' => 0,
                            'ISTRI' => 1,
                            'ANAK' => 2,
                            'CUCU' => 3,
                            'ORANG TUA' => 4,
                        ];
                        $prio = $priorityMap[$rel] ?? 99;
                        $noKk = (string)($p->no_kk ?? '');
                        $name = strtoupper((string)($p->nama ?? ''));
                        return sprintf('%s-%02d-%s', $noKk, $prio, $name);
                    });
                @endphp
                @forelse($sorted as $item)
                <tr data-dusun="{{ $item->dusun_id }}" data-gender="{{ $item->jenis_kelamin }}" data-search="{{ strtolower(
                    ($item->nama ?? '') . ' ' .
                    ($item->nik ?? '') . ' ' .
                    ($item->no_kk ?? '') . ' ' .
                    ($item->alamat_kk ?? '') . ' ' .
                    ($item->hubungan_kepala_keluarga ?? '') . ' ' .
                    ($item->status_perkawinan ?? '') . ' ' .
                    ($item->suku ?? '') . ' ' .
                    ($item->pendidikan_terakhir ?? '') . ' ' .
                    ($item->mata_pencaharian ?? '') . ' ' .
                    ($item->pekerjaan_tambahan ?? '') . ' ' .
                    ($item->komoditas_utama ?? '') . ' ' .
                    ($item->komoditas_buah_sayur ?? '') . ' ' .
                    ($item->bantuan ?? '') . ' ' .
                    ($item->status_kepemilikan_rumah ?? '') . ' ' .
                    ($item->status_dinding ?? '') . ' ' .
                    ($item->status_atap ?? '') . ' ' .
                    ($item->penggunaan_listrik ?? '') . ' ' .
                    ($item->mck ?? '') . ' ' .
                    ($item->tempat_lahir ?? '') . ' Dusun ' . ($item->dusun_id ?? '')
                ) }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-bold">{{ $item->nama }}</div>
                        <small class="text-muted">{{ $item->nik }}</small>
                        <br>
                        <span class="badge bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }}">
                            {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <br>
                        @php
                            $dobDisplay = '-';
                            $tgl = (string)($item->tanggal_lahir ?? '');
                            $bln = (string)($item->bulan_lahir ?? '');
                            $thn = (string)($item->tahun_lahir ?? '');
                            if (!empty($tgl) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
                                try { $dobDisplay = \Carbon\Carbon::parse($tgl)->format('d/m/Y'); } catch (Exception $e) { $dobDisplay = '-'; }
                            } elseif ($tgl || $bln || $thn) {
                                $d = $tgl !== '' && is_numeric($tgl) ? str_pad($tgl, 2, '0', STR_PAD_LEFT) : ($tgl ?: '');
                                $m = $bln !== '' ? str_pad((string)$bln, 2, '0', STR_PAD_LEFT) : '';
                                $y = $thn ?: '';
                                $dobDisplay = trim(implode('/', array_filter([$d, $m, $y], fn($v)=>$v!=='')));
                            }
                        @endphp
                        <small class="text-muted">{{ $item->tempat_lahir }}, {{ $dobDisplay }}</small>
                    </td>
                    <td>
                        <div class="small">{{ $item->alamat_kk }}</div>
                        <div class="text-muted">KK: {{ $item->no_kk }}</div>
                        <div class="text-muted">Hub: {{ $item->hubungan_kepala_keluarga }}</div>
                        @if($item->kk_dikeluarkan)
                            <div class="text-muted">Tgl: {{ \Carbon\Carbon::parse($item->kk_dikeluarkan)->format('d/m/Y') }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="small">{{ $item->status_perkawinan }}</div>
                        <div class="text-muted">{{ $item->suku }}</div>
                        <div class="text-muted">{{ $item->pendidikan_terakhir }}</div>
                        <div class="text-muted">{{ $item->mata_pencaharian }}</div>
                    </td>
                    <td>
                        <div class="small">Lahan: {{ number_format((float)($item->luas_lahan_pertanian ?? 0), 2) }} ha</div>
                        <div class="text-muted">{{ $item->komoditas_utama }}</div>
                        <div class="text-muted">{{ $item->komoditas_buah_sayur }}</div>
                        <div class="text-muted">{{ $item->bantuan }}</div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $item->dusun_id == 1 ? 'success' : ($item->dusun_id == 2 ? 'warning' : 'info') }}">
                            Dusun {{ $item->dusun_id }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group-vertical" role="group">
                            <button class="btn btn-sm btn-outline-info" title="Detail" onclick="showDetail({{ $item->id }})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary" title="Edit" onclick="editPopulation({{ $item->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" title="Hapus" onclick="deletePopulation({{ $item->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data penduduk</p>
                    </td>
                </tr>
                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dusun 1 Tab -->
    <div class="tab-pane fade" id="dusun1" role="tabpanel">
        <div class="card fade-in">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="dusun1Table">
                        <thead class="table-dark">
                            <tr data-dusun="1" data-gender="{{ $item->jenis_kelamin }}" data-search="{{ strtolower(
                                ($item->nama ?? '') . ' ' .
                                ($item->nik ?? '') . ' ' .
                                ($item->no_kk ?? '') . ' ' .
                                ($item->alamat_kk ?? '') . ' ' .
                                ($item->hubungan_kepala_keluarga ?? '') . ' ' .
                                ($item->status_perkawinan ?? '') . ' ' .
                                ($item->suku ?? '') . ' ' .
                                ($item->pendidikan_terakhir ?? '') . ' ' .
                                ($item->mata_pencaharian ?? '') . ' ' .
                                ($item->pekerjaan_tambahan ?? '') . ' ' .
                                ($item->komoditas_utama ?? '') . ' ' .
                                ($item->komoditas_buah_sayur ?? '') . ' ' .
                                ($item->bantuan ?? '') . ' ' .
                                ($item->status_kepemilikan_rumah ?? '') . ' ' .
                                ($item->status_dinding ?? '') . ' ' .
                                ($item->status_atap ?? '') . ' ' .
                                ($item->penggunaan_listrik ?? '') . ' ' .
                                ($item->mck ?? '') . ' ' .
                                ($item->tempat_lahir ?? '') . ' Dusun 1'
                            ) }}">
                                <th width="5%">No</th>
                                <th width="20%">Data Pribadi</th>
                                <th width="15%">Alamat & KK</th>
                                <th width="15%">Status Sosial</th>
                                <th width="15%">Data Pertanian</th>
                                <th width="10%">Dusun</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dusun1Data = $populations->where('dusun_id', 1)->sortBy(function($p){
                                    $rel = strtoupper(trim($p->hubungan_kepala_keluarga ?? ''));
                                    $priorityMap = [
                                        'KK' => 0,
                                        'KEPALA KELUARGA' => 0,
                                        'ISTRI' => 1,
                                        'ANAK' => 2,
                                        'CUCU' => 3,
                                        'ORANG TUA' => 4,
                                    ];
                                    $prio = $priorityMap[$rel] ?? 99;
                                    $noKk = (string)($p->no_kk ?? '');
                                    $name = strtoupper((string)($p->nama ?? ''));
                                    return sprintf('%s-%02d-%s', $noKk, $prio, $name);
                                });
                            @endphp
                            @forelse($dusun1Data as $item)
                            <tr data-dusun="2" data-gender="{{ $item->jenis_kelamin }}" data-search="{{ strtolower(
                                ($item->nama ?? '') . ' ' .
                                ($item->nik ?? '') . ' ' .
                                ($item->no_kk ?? '') . ' ' .
                                ($item->alamat_kk ?? '') . ' ' .
                                ($item->hubungan_kepala_keluarga ?? '') . ' ' .
                                ($item->status_perkawinan ?? '') . ' ' .
                                ($item->suku ?? '') . ' ' .
                                ($item->pendidikan_terakhir ?? '') . ' ' .
                                ($item->mata_pencaharian ?? '') . ' ' .
                                ($item->pekerjaan_tambahan ?? '') . ' ' .
                                ($item->komoditas_utama ?? '') . ' ' .
                                ($item->komoditas_buah_sayur ?? '') . ' ' .
                                ($item->bantuan ?? '') . ' ' .
                                ($item->status_kepemilikan_rumah ?? '') . ' ' .
                                ($item->status_dinding ?? '') . ' ' .
                                ($item->status_atap ?? '') . ' ' .
                                ($item->penggunaan_listrik ?? '') . ' ' .
                                ($item->mck ?? '') . ' ' .
                                ($item->tempat_lahir ?? '') . ' Dusun 2'
                            ) }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $item->nama }}</div>
                                    <small class="text-muted">{{ $item->nik }}</small>
                                    <br>
                                    <span class="badge bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }}">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    <br>
                                    @php
                                        $dobDisplay = '-';
                                        $tgl = (string)($item->tanggal_lahir ?? '');
                                        $bln = (string)($item->bulan_lahir ?? '');
                                        $thn = (string)($item->tahun_lahir ?? '');
                                        if (!empty($tgl) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
                                            try { $dobDisplay = \Carbon\Carbon::parse($tgl)->format('d/m/Y'); } catch (Exception $e) { $dobDisplay = '-'; }
                                        } elseif ($tgl || $bln || $thn) {
                                            $d = $tgl !== '' && is_numeric($tgl) ? str_pad($tgl, 2, '0', STR_PAD_LEFT) : ($tgl ?: '');
                                            $m = $bln !== '' ? str_pad((string)$bln, 2, '0', STR_PAD_LEFT) : '';
                                            $y = $thn ?: '';
                                            $dobDisplay = trim(implode('/', array_filter([$d, $m, $y], fn($v)=>$v!=='')));
                                        }
                                    @endphp
                                    <small class="text-muted">{{ $item->tempat_lahir }}, {{ $dobDisplay }}</small>
                                </td>
                                <td>
                                    <div class="small">{{ $item->alamat_kk }}</div>
                                    <div class="text-muted">KK: {{ $item->no_kk }}</div>
                                    <div class="text-muted">Hub: {{ $item->hubungan_kepala_keluarga }}</div>
                                    @if($item->kk_dikeluarkan)
                                        <div class="text-muted">Tgl: {{ \Carbon\Carbon::parse($item->kk_dikeluarkan)->format('d/m/Y') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">{{ $item->status_perkawinan }}</div>
                                    <div class="text-muted">{{ $item->suku }}</div>
                                    <div class="text-muted">{{ $item->pendidikan_terakhir }}</div>
                                    <div class="text-muted">{{ $item->mata_pencaharian }}</div>
                                </td>
                                <td>
                                    <div class="small">Lahan: {{ number_format((float)($item->luas_lahan_pertanian ?? 0), 2) }} ha</div>
                                    <div class="text-muted">{{ $item->komoditas_utama }}</div>
                                    <div class="text-muted">{{ $item->komoditas_buah_sayur }}</div>
                                    <div class="text-muted">{{ $item->bantuan }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-success">Dusun 1</span>
                                </td>
                                <td>
                                    <div class="btn-group-vertical" role="group">
                                        <button class="btn btn-sm btn-outline-info" title="Detail" onclick="showDetail({{ $item->id }})"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit" onclick="editPopulation({{ $item->id }})"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus" onclick="deletePopulation({{ $item->id }})"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr data-dusun="3" data-gender="{{ $item->jenis_kelamin }}" data-search="{{ strtolower(
                                ($item->nama ?? '') . ' ' .
                                ($item->nik ?? '') . ' ' .
                                ($item->no_kk ?? '') . ' ' .
                                ($item->alamat_kk ?? '') . ' ' .
                                ($item->hubungan_kepala_keluarga ?? '') . ' ' .
                                ($item->status_perkawinan ?? '') . ' ' .
                                ($item->suku ?? '') . ' ' .
                                ($item->pendidikan_terakhir ?? '') . ' ' .
                                ($item->mata_pencaharian ?? '') . ' ' .
                                ($item->pekerjaan_tambahan ?? '') . ' ' .
                                ($item->komoditas_utama ?? '') . ' ' .
                                ($item->komoditas_buah_sayur ?? '') . ' ' .
                                ($item->bantuan ?? '') . ' ' .
                                ($item->status_kepemilikan_rumah ?? '') . ' ' .
                                ($item->status_dinding ?? '') . ' ' .
                                ($item->status_atap ?? '') . ' ' .
                                ($item->penggunaan_listrik ?? '') . ' ' .
                                ($item->mck ?? '') . ' ' .
                                ($item->tempat_lahir ?? '') . ' Dusun 3'
                            ) }}">
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data penduduk di Dusun 1</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dusun 2 Tab -->
    <div class="tab-pane fade" id="dusun2" role="tabpanel">
        <div class="card fade-in">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="dusun2Table">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Data Pribadi</th>
                                <th width="15%">Alamat & KK</th>
                                <th width="15%">Status Sosial</th>
                                <th width="15%">Data Pertanian</th>
                                <th width="10%">Dusun</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dusun2Data = $populations->where('dusun_id', 2)->sortBy(function($p){
                                    $rel = strtoupper(trim($p->hubungan_kepala_keluarga ?? ''));
                                    $priorityMap = [
                                        'KK' => 0,
                                        'KEPALA KELUARGA' => 0,
                                        'ISTRI' => 1,
                                        'ANAK' => 2,
                                        'CUCU' => 3,
                                        'ORANG TUA' => 4,
                                    ];
                                    $prio = $priorityMap[$rel] ?? 99;
                                    $noKk = (string)($p->no_kk ?? '');
                                    $name = strtoupper((string)($p->nama ?? ''));
                                    return sprintf('%s-%02d-%s', $noKk, $prio, $name);
                                });
                            @endphp
                            @forelse($dusun2Data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $item->nama }}</div>
                                    <small class="text-muted">{{ $item->nik }}</small>
                                    <br>
                                    <span class="badge bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }}">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    <br>
                                    @php
                                        $dobDisplay = '-';
                                        $tgl = (string)($item->tanggal_lahir ?? '');
                                        $bln = (string)($item->bulan_lahir ?? '');
                                        $thn = (string)($item->tahun_lahir ?? '');
                                        if (!empty($tgl) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
                                            try { $dobDisplay = \Carbon\Carbon::parse($tgl)->format('d/m/Y'); } catch (Exception $e) { $dobDisplay = '-'; }
                                        } elseif ($tgl || $bln || $thn) {
                                            $d = $tgl !== '' && is_numeric($tgl) ? str_pad($tgl, 2, '0', STR_PAD_LEFT) : ($tgl ?: '');
                                            $m = $bln !== '' ? str_pad((string)$bln, 2, '0', STR_PAD_LEFT) : '';
                                            $y = $thn ?: '';
                                            $dobDisplay = trim(implode('/', array_filter([$d, $m, $y], fn($v)=>$v!=='')));
                                        }
                                    @endphp
                                    <small class="text-muted">{{ $item->tempat_lahir }}, {{ $dobDisplay }}</small>
                                </td>
                                <td>
                                    <div class="small">{{ $item->alamat_kk }}</div>
                                    <div class="text-muted">KK: {{ $item->no_kk }}</div>
                                    <div class="text-muted">Hub: {{ $item->hubungan_kepala_keluarga }}</div>
                                    @if($item->kk_dikeluarkan)
                                        <div class="text-muted">Tgl: {{ \Carbon\Carbon::parse($item->kk_dikeluarkan)->format('d/m/Y') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">{{ $item->status_perkawinan }}</div>
                                    <div class="text-muted">{{ $item->suku }}</div>
                                    <div class="text-muted">{{ $item->pendidikan_terakhir }}</div>
                                    <div class="text-muted">{{ $item->mata_pencaharian }}</div>
                                </td>
                                <td>
                                    <div class="small">Lahan: {{ number_format((float)($item->luas_lahan_pertanian ?? 0), 2) }} ha</div>
                                    <div class="text-muted">{{ $item->komoditas_utama }}</div>
                                    <div class="text-muted">{{ $item->komoditas_buah_sayur }}</div>
                                    <div class="text-muted">{{ $item->bantuan }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-warning">Dusun 2</span>
                                </td>
                                <td>
                                    <div class="btn-group-vertical" role="group">
                                        <button class="btn btn-sm btn-outline-info" title="Detail" onclick="showDetail({{ $item->id }})"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit" onclick="editPopulation({{ $item->id }})"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus" onclick="deletePopulation({{ $item->id }})"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data penduduk di Dusun 2</p>
                    </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dusun 3 Tab -->
    <div class="tab-pane fade" id="dusun3" role="tabpanel">
        <div class="card fade-in">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="dusun3Table">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Data Pribadi</th>
                                <th width="15%">Alamat & KK</th>
                                <th width="15%">Status Sosial</th>
                                <th width="15%">Data Pertanian</th>
                                <th width="10%">Dusun</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dusun3Data = $populations->where('dusun_id', 3)->sortBy(function($p){
                                    $rel = strtoupper(trim($p->hubungan_kepala_keluarga ?? ''));
                                    $priorityMap = [
                                        'KK' => 0,
                                        'KEPALA KELUARGA' => 0,
                                        'ISTRI' => 1,
                                        'ANAK' => 2,
                                        'CUCU' => 3,
                                        'ORANG TUA' => 4,
                                    ];
                                    $prio = $priorityMap[$rel] ?? 99;
                                    $noKk = (string)($p->no_kk ?? '');
                                    $name = strtoupper((string)($p->nama ?? ''));
                                    return sprintf('%s-%02d-%s', $noKk, $prio, $name);
                                });
                            @endphp
                            @forelse($dusun3Data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $item->nama }}</div>
                                    <small class="text-muted">{{ $item->nik }}</small>
                                    <br>
                                    <span class="badge bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }}">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    <br>
                                    @php
                                        $dobDisplay = '-';
                                        $tgl = (string)($item->tanggal_lahir ?? '');
                                        $bln = (string)($item->bulan_lahir ?? '');
                                        $thn = (string)($item->tahun_lahir ?? '');
                                        if (!empty($tgl) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
                                            try { $dobDisplay = \Carbon\Carbon::parse($tgl)->format('d/m/Y'); } catch (Exception $e) { $dobDisplay = '-'; }
                                        } elseif ($tgl || $bln || $thn) {
                                            $d = $tgl !== '' && is_numeric($tgl) ? str_pad($tgl, 2, '0', STR_PAD_LEFT) : ($tgl ?: '');
                                            $m = $bln !== '' ? str_pad((string)$bln, 2, '0', STR_PAD_LEFT) : '';
                                            $y = $thn ?: '';
                                            $dobDisplay = trim(implode('/', array_filter([$d, $m, $y], fn($v)=>$v!=='')));
                                        }
                                    @endphp
                                    <small class="text-muted">{{ $item->tempat_lahir }}, {{ $dobDisplay }}</small>
                                </td>
                                <td>
                                    <div class="small">{{ $item->alamat_kk }}</div>
                                    <div class="text-muted">KK: {{ $item->no_kk }}</div>
                                    <div class="text-muted">Hub: {{ $item->hubungan_kepala_keluarga }}</div>
                                    @if($item->kk_dikeluarkan)
                                        <div class="text-muted">Tgl: {{ \Carbon\Carbon::parse($item->kk_dikeluarkan)->format('d/m/Y') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">{{ $item->status_perkawinan }}</div>
                                    <div class="text-muted">{{ $item->suku }}</div>
                                    <div class="text-muted">{{ $item->pendidikan_terakhir }}</div>
                                    <div class="text-muted">{{ $item->mata_pencaharian }}</div>
                                </td>
                                <td>
                                    <div class="small">Lahan: {{ number_format((float)($item->luas_lahan_pertanian ?? 0), 2) }} ha</div>
                                    <div class="text-muted">{{ $item->komoditas_utama }}</div>
                                    <div class="text-muted">{{ $item->komoditas_buah_sayur }}</div>
                                    <div class="text-muted">{{ $item->bantuan }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-info">Dusun 3</span>
                                </td>
                                <td>
                                    <div class="btn-group-vertical" role="group">
                                        <button class="btn btn-sm btn-outline-info" title="Detail" onclick="showDetail({{ $item->id }})"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit" onclick="editPopulation({{ $item->id }})"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus" onclick="deletePopulation({{ $item->id }})"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                @empty
                <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data penduduk di Dusun 3</p>
                                </td>
                </tr>
                @endforelse
            </tbody>
        </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Import CSV -->
<div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.population.import-csv') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importCsvModalLabel">
                    <i class="fas fa-file-csv me-2"></i>Import Data Penduduk dari CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Format CSV yang Diperlukan:</strong>
                    <ul class="mb-2 mt-2">
                        <li>File harus dalam format .csv (maksimal 10MB)</li>
                        <li>Gunakan koma (,) sebagai pemisah kolom</li>
                        <li>Baris pertama harus berisi header kolom</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Template Kolom CSV:</strong>
                    <div class="mt-2">
                        <small class="text-muted">Urutan kolom yang benar (sesuai format asli):</small>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <small>
                                    <strong>Kolom Wajib:</strong><br>
                                    • No (urutan)<br>
                                    • Nama (nama lengkap)<br>
                                    • Alamat (alamat)<br>
                                    • KK di keluarkan pada tanggal<br>
                                    • No. KK (nomor kartu keluarga)<br>
                                    • NIK (16 digit)<br>
                                    • L (1 untuk laki-laki, kosong jika tidak)<br>
                                    • P (1 untuk perempuan, kosong jika tidak)<br>
                                    • Hubungan Kepala Keluarga<br>
                                    • Tempat (tempat lahir)<br>
                                    • Tggl (tanggal lahir)<br>
                                    • Bulan (bulan lahir)<br>
                                    • Tahun (tahun lahir)
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small>
                                    <strong>Kolom Opsional:</strong><br>
                                    • Status (status perkawinan)<br>
                                    • Suku<br>
                                    • Pendidikan Teralhir<br>
                                    • Mata Pencaharian<br>
                                    • Pekerjaan Tambahan<br>
                                    • Mobil, Motor, Sepeda (kendaraan)<br>
                                    • Sapi, Kambing, Ayam, Ikan (ternak)<br>
                                    • Pertanian, Peternakan (luas lahan)<br>
                                    • Utama, Buah & sayur (komoditas)<br>
                                    • Bantuan<br>
                                    • Kepemilikan, Dinding, Atap (status rumah)
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="alert alert-light border">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Tips Penting:</strong>
                    <ul class="mb-0 mt-2">
                        <li><strong>Jenis Kelamin:</strong> Isi kolom "L" dengan 1 untuk Laki-laki, kosongkan untuk Perempuan. Isi kolom "P" dengan 1 untuk Perempuan, kosongkan untuk Laki-laki</li>
                        <li><strong>Tanggal Lahir:</strong> Pisahkan menjadi 3 kolom: Tggl (tanggal), Bulan, Tahun (contoh: 15, 05, 1990)</li>
                        <li><strong>KK Dikeluarkan:</strong> Gunakan format YYYY-MM-DD (contoh: 2023-11-28)</li>
                        <li><strong>Hubungan KK:</strong> KEPALA KELUARGA, ISTRI, ANAK, CUCU, ORANG TUA, dll.</li>
                        <li><strong>NIK & No KK:</strong> Harus 16 digit angka</li>
                        <li><strong>Kendaraan & Ternak:</strong> Isi dengan angka (jumlah), kosongkan jika 0</li>
                        <li><strong>Luas Lahan:</strong> Pertanian dan Peternakan dalam meter persegi (m²)</li>
                        <li><strong>Status Rumah:</strong> MILIK SENDIRI, CAMPURAN, PAPAN, SENG, dll.</li>
                    </ul>
                </div>
                
                
                <div class="alert alert-success">
                    <i class="fas fa-download me-2"></i>
                    <strong>Download Template:</strong>
                    <a href="#" class="btn btn-sm btn-outline-success ms-2" onclick="downloadTemplate()">
                        <i class="fas fa-file-download me-1"></i>Download Template CSV
                    </a>
                </div>
                <div class="mb-3">
                    <label for="csvFile" class="form-label">Pilih File CSV</label>
                    <input type="file" class="form-control" name="file" id="csvFile" accept=".csv" required>
                    <div class="form-text">Maksimal 10MB</div>
                </div>
                <div class="mb-3">
                    <label for="csvDusun" class="form-label">Dusun</label>
                    <select class="form-select" id="csvDusun" name="dusun_id" required>
                        <option value="">Pilih Dusun</option>
                        <option value="1">Dusun 1</option>
                        <option value="2">Dusun 2</option>
                        <option value="3">Dusun 3</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-upload me-1"></i>Import CSV
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Data Penduduk -->
<div class="modal fade" id="addPopulationModal" tabindex="-1" aria-labelledby="addPopulationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('admin.population.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addPopulationModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Tambah Data Penduduk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Data Pribadi -->
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2">
                            <i class="fas fa-user me-2"></i>Data Pribadi
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nik" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dusun <span class="text-danger">*</span></label>
                        <select class="form-select" name="dusun" required>
                            <option value="">Pilih Dusun</option>
                            <option value="Dusun 1">Dusun 1</option>
                            <option value="Dusun 2">Dusun 2</option>
                            <option value="Dusun 3">Dusun 3</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tanggal</label>
                        <input type="number" class="form-control" name="tanggal_lahir" min="1" max="31">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Bulan</label>
                        <input type="number" class="form-control" name="bulan_lahir" min="1" max="12">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tahun</label>
                        <input type="number" class="form-control" name="tahun_lahir" min="1900" max="2024">
                    </div>

                    <!-- Data KK -->
                    <div class="col-12 mt-4">
                        <h6 class="text-primary border-bottom pb-2">
                            <i class="fas fa-home me-2"></i>Data Kartu Keluarga
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. KK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_kk" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hubungan Kepala Keluarga</label>
                        <select class="form-select" name="hubungan_kepala_keluarga">
                            <option value="">Pilih Hubungan</option>
                            <option value="KK">Kepala Keluarga</option>
                            <option value="ISTRI">Istri</option>
                            <option value="ANAK">Anak</option>
                            <option value="ORANG TUA">Orang Tua</option>
                            <option value="LAINNYA">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat KK</label>
                        <textarea class="form-control" name="alamat_kk" rows="2"></textarea>
                    </div>

                    <!-- Status Sosial -->
                    <div class="col-12 mt-4">
                        <h6 class="text-primary border-bottom pb-2">
                            <i class="fas fa-info-circle me-2"></i>Status Sosial
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status Perkawinan</label>
                        <select class="form-select" name="status_perkawinan">
                            <option value="">Pilih Status</option>
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Suku</label>
                        <input type="text" class="form-control" name="suku">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <select class="form-select" name="pendidikan_terakhir">
                            <option value="">Pilih Pendidikan</option>
                            <option value="Tidak Sekolah">Tidak Sekolah</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="Diploma">Diploma</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mata Pencaharian</label>
                        <input type="text" class="form-control" name="mata_pencaharian">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan Tambahan</label>
                        <input type="text" class="form-control" name="pekerjaan_tambahan">
                    </div>

                    <!-- Kepemilikan -->
                    <div class="col-12 mt-4">
                        <h6 class="text-primary border-bottom pb-2">
                            <i class="fas fa-car me-2"></i>Kepemilikan
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kendaraan</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="number" class="form-control" name="mobil" placeholder="Mobil" min="0">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control" name="motor" placeholder="Motor" min="0">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control" name="sepeda" placeholder="Sepeda" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ternak</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="number" class="form-control" name="sapi" placeholder="Sapi" min="0">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control" name="kambing" placeholder="Kambing" min="0">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control" name="ayam" placeholder="Ayam" min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Data Pertanian -->
                    <div class="col-12 mt-4">
                        <h6 class="text-primary border-bottom pb-2">
                            <i class="fas fa-seedling me-2"></i>Data Pertanian
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Luas Lahan Pertanian (Hektar)</label>
                        <input type="number" class="form-control" name="luas_lahan_pertanian" step="0.01" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Komoditas Utama</label>
                        <input type="text" class="form-control" name="komoditas_utama">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Komoditas Buah & Sayur</label>
                        <input type="text" class="form-control" name="komoditas_buah_sayur">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bantuan yang Diterima</label>
                        <textarea class="form-control" name="bantuan" rows="2"></textarea>
                    </div>
        </div>
      </div>
      <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i>Simpan Data
                </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Detail Data Penduduk -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-user me-2"></i>Detail Data Penduduk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" id="editFromDetail">
                    <i class="fas fa-edit me-1"></i>Edit Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data Penduduk -->
<div class="modal fade" id="editPopulationModal" tabindex="-1" aria-labelledby="editPopulationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPopulationModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Data Penduduk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPopulationForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editNama" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editNik" name="nik" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. KK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editNoKk" name="no_kk" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select" id="editJenisKelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dusun <span class="text-danger">*</span></label>
                            <select class="form-select" id="editDusun" name="dusun" required>
                                <option value="">Pilih Dusun</option>
                                <option value="Dusun 1">Dusun 1</option>
                                <option value="Dusun 2">Dusun 2</option>
                                <option value="Dusun 3">Dusun 3</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="editTempatLahir" name="tempat_lahir">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal</label>
                            <input type="number" class="form-control" id="editTanggalLahir" name="tanggal_lahir" min="1" max="31">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Bulan</label>
                            <input type="number" class="form-control" id="editBulanLahir" name="bulan_lahir" min="1" max="12">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tahun</label>
                            <input type="number" class="form-control" id="editTahunLahir" name="tahun_lahir" min="1900" max="2024">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hubungan Kepala Keluarga</label>
                            <input type="text" class="form-control" id="editHubunganKepalaKeluarga" name="hubungan_kepala_keluarga">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat KK</label>
                            <textarea class="form-control" id="editAlamatKk" name="alamat_kk" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Perkawinan</label>
                            <input type="text" class="form-control" id="editStatusPerkawinan" name="status_perkawinan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Suku</label>
                            <input type="text" class="form-control" id="editSuku" name="suku">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <input type="text" class="form-control" id="editPendidikanTerakhir" name="pendidikan_terakhir">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mata Pencaharian</label>
                            <input type="text" class="form-control" id="editMataPencaharian" name="mata_pencaharian">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Tambahan</label>
                            <input type="text" class="form-control" id="editPekerjaanTambahan" name="pekerjaan_tambahan">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mobil</label>
                            <input type="number" class="form-control" id="editMobil" name="mobil" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Motor</label>
                            <input type="number" class="form-control" id="editMotor" name="motor" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sepeda</label>
                            <input type="number" class="form-control" id="editSepeda" name="sepeda" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sapi</label>
                            <input type="number" class="form-control" id="editSapi" name="sapi" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kambing</label>
                            <input type="number" class="form-control" id="editKambing" name="kambing" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Ayam</label>
                            <input type="number" class="form-control" id="editAyam" name="ayam" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Luas Lahan Pertanian (ha)</label>
                            <input type="number" class="form-control" id="editLuasLahanPertanian" name="luas_lahan_pertanian" step="0.01" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Komoditas Utama</label>
                            <input type="text" class="form-control" id="editKomoditasUtama" name="komoditas_utama">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Komoditas Buah & Sayur</label>
                            <input type="text" class="form-control" id="editKomoditasBuahSayur" name="komoditas_buah_sayur">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bantuan</label>
                            <textarea class="form-control" id="editBantuan" name="bantuan" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
.stat-card {
    transition: transform 0.2s ease-in-out;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.stat-icon {
    font-size: 2rem;
    opacity: 0.7;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
}

.btn-group-vertical .btn {
    margin-bottom: 2px;
}

.btn-group-vertical .btn:last-child {
    margin-bottom: 0;
}

.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.slide-in {
    animation: slideIn 0.6s ease-out;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom-color: #0d6efd;
    background: none;
}

.nav-tabs .nav-link:hover {
    border-color: transparent;
    border-bottom-color: #dee2e6;
}

.table-responsive {
    border-radius: 0.375rem;
    overflow: hidden;
}

.sticky-top {
    position: sticky;
    top: 0;
    z-index: 10;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.is-invalid {
    border-color: #dc3545;
}

.alert {
    border: none;
    border-radius: 0.5rem;
}

.modal-xl {
    max-width: 90%;
}

.detail-card {
    transition: transform 0.2s ease-in-out;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.detail-card .card-header {
    border-radius: 0.375rem 0.375rem 0 0;
    font-weight: 600;
}

.detail-card .card-body {
    padding: 1.5rem;
}

.detail-card .form-label {
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.detail-card p {
    color: #212529;
    font-size: 0.95rem;
    line-height: 1.4;
}

.detail-card .badge {
    font-size: 0.8rem;
    padding: 0.4em 0.8em;
}

.detail-card .fw-bold {
    color: #495057;
}

.detail-card .text-muted {
    color: #6c757d !important;
    font-size: 0.8rem;
}

#detailModal .modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

#detailModal .modal-body::-webkit-scrollbar {
    width: 6px;
}

#detailModal .modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#detailModal .modal-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

#detailModal .modal-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.75rem;
    }
    
    .btn-group-vertical .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .stat-card .card-body {
        padding: 1rem;
    }
    
    .stat-icon {
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tables = [
        document.getElementById('populationTable'),
        document.getElementById('dusun1Table'),
        document.getElementById('dusun2Table'),
        document.getElementById('dusun3Table')
    ];

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        
        tables.forEach(table => {
            if (table) {
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const searchData = row.getAttribute('data-search') || '';
                    const matchesSearch = searchData.toLowerCase().includes(searchTerm);
                    
                    if (matchesSearch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    }

    // Event listeners
    searchInput.addEventListener('input', filterTable);

    // Auto-resize textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });

    // Form validation
    const form = document.querySelector('#addPopulationModal form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Mohon lengkapi semua field yang wajib diisi!',
                    confirmButtonColor: '#2E8B57'
                });
            }
        });
    }


    // Edit from detail modal
    document.getElementById('editFromDetail').addEventListener('click', function() {
        // Close detail modal
        const detailModal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
        detailModal.hide();
        
        // Get the population ID from the current detail session
        const populationId = window.currentDetailId;
        if (populationId) {
            editPopulation(populationId);
        }
    });

    // Generate detail content
    function generateDetailContent(population) {
        const formatDate = (date) => {
            if (!date) return '-';
            return new Date(date).toLocaleDateString('id-ID');
        };

        const formatNumber = (num) => {
            return num ? Number(num).toLocaleString('id-ID') : '0';
        };

        return `
            <div class="row g-4">
                <!-- Data Pribadi -->
                <div class="col-md-6">
                    <div class="card h-100 detail-card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <p class="mb-0">${population.nama || '-'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">NIK</label>
                                    <p class="mb-0">${population.nik || '-'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kelamin</label>
                                    <p class="mb-0">
                                        <span class="badge bg-${population.jenis_kelamin === 'L' ? 'primary' : 'danger'}">
                                            ${population.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Tempat, Tanggal Lahir</label>
                                    <p class="mb-0">${population.tempat_lahir || '-'}, ${formatDate(population.tanggal_lahir) || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Dusun</label>
                                    <p class="mb-0">
                                        <span class="badge bg-${population.dusun_id == 1 ? 'success' : (population.dusun_id == 2 ? 'warning' : 'info')}">
                                            Dusun ${population.dusun_id || '-'}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Kartu Keluarga -->
                <div class="col-md-6">
                    <div class="card h-100 detail-card">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-home me-2"></i>Data Kartu Keluarga</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">No. KK</label>
                                    <p class="mb-0">${population.no_kk || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat KK</label>
                                    <p class="mb-0">${population.alamat_kk || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Hubungan Kepala Keluarga</label>
                                    <p class="mb-0">${population.hubungan_kepala_keluarga || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">KK Dikeluarkan</label>
                                    <p class="mb-0">${formatDate(population.kk_dikeluarkan)}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Sosial -->
                <div class="col-md-6">
                    <div class="card h-100 detail-card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Status Sosial</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Status Perkawinan</label>
                                    <p class="mb-0">${population.status_perkawinan || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Suku</label>
                                    <p class="mb-0">${population.suku || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Pendidikan Terakhir</label>
                                    <p class="mb-0">${population.pendidikan_terakhir || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Mata Pencaharian</label>
                                    <p class="mb-0">${population.mata_pencaharian || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Pekerjaan Tambahan</label>
                                    <p class="mb-0">${population.pekerjaan_tambahan || '-'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kepemilikan -->
                <div class="col-md-6">
                    <div class="card h-100 detail-card">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0"><i class="fas fa-car me-2"></i>Kepemilikan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <h6 class="text-muted">Kendaraan</h6>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <small class="text-muted">Mobil:</small>
                                            <div class="fw-bold">${formatNumber(population.mobil)}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Motor:</small>
                                            <div class="fw-bold">${formatNumber(population.motor)}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Sepeda:</small>
                                            <div class="fw-bold">${formatNumber(population.sepeda)}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted">Ternak</h6>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <small class="text-muted">Sapi:</small>
                                            <div class="fw-bold">${formatNumber(population.sapi)}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Kambing:</small>
                                            <div class="fw-bold">${formatNumber(population.kambing)}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Ayam:</small>
                                            <div class="fw-bold">${formatNumber(population.ayam)}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kondisi Rumah -->
                <div class="col-md-6">
                    <div class="card h-100 detail-card">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="fas fa-home me-2"></i>Kondisi Rumah</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Status Kepemilikan</label>
                                    <p class="mb-0">${population.status_kepemilikan_rumah || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Dinding</label>
                                    <p class="mb-0">${population.status_dinding || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Atap</label>
                                    <p class="mb-0">${population.status_atap || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Penggunaan Listrik</label>
                                    <p class="mb-0">${population.penggunaan_listrik || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">MCk</label>
                                    <p class="mb-0">${population.mck || '-'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pertanian -->
                <div class="col-md-6">
                    <div class="card h-100 detail-card">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-seedling me-2"></i>Data Pertanian</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Luas Lahan Pertanian</label>
                                    <p class="mb-0">${population.luas_lahan_pertanian ? Number(population.luas_lahan_pertanian).toFixed(2) + ' ha' : '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Komoditas Utama</label>
                                    <p class="mb-0">${population.komoditas_utama || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Komoditas Buah & Sayur</label>
                                    <p class="mb-0">${population.komoditas_buah_sayur || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Bantuan yang Diterima</label>
                                    <p class="mb-0">${population.bantuan || '-'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to show detail
    window.showDetail = function(id) {
        console.log('showDetail called with id:', id);
        window.currentDetailId = id; // Store the current detail ID
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        const modalBody = document.getElementById('detailModalBody');
        
        // Show loading state
        modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat data...</p>
            </div>
        `;
        
        modal.show();
        
        // Fetch data
        fetch(`/admin/population/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modalBody.innerHTML = generateDetailContent(data.population);
                } else {
                    modalBody.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Gagal memuat data: ${data.message || 'Terjadi kesalahan'}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                modalBody.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Terjadi kesalahan saat memuat data
                    </div>
                `;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memuat data detail',
                    confirmButtonColor: '#2E8B57'
                });
            });
    };

    // Function to download CSV template
    window.downloadTemplate = function() {
        const csvContent = `No,Nama,Alamat ,KK di keluarkan pada tanggal,No. KK,NIK,L,P,Hubungan Kepala Keluarga,Kelahiran,,,,Status,Suku,Pendidikan Teralhir,Mata Pencaharian,Pekerjaan Tambahan,Kendaraan,,,Ternak,,,,Luas Lahan,,Komoditas,,Bantuan,Status Rumah,,,,
,,,,,,,,,Tempat,Tggl,Bulan,Tahun,,,,,,Mobil,Motor,Sepeda,Sapi,Kambing,Ayam,Ikan,Pertanian ,Peternakan,Utama,Buah & sayur,,Kepemilikan,Dinding,Atap,Penggunaan Listrik,MCK
1,CONTOH NAMA,TETEMBOMUA,2023-11-28,7402010403080015,7402010101690006,1,,KEPALA KELUARGA,MAKASSAR,01,01,1966,KAWIN,BUGIS,SMP,PETANI,TERNAK SAPI,1,2,,,3,,,,25000,,SAWIT,,PKI,MILIK SENDIRI,CAMPURAN,SENG,,
2,CONTOH NAMA 2,TETEMBOMUA,2019-07-26,7402012505100004,7402015310700001,,1,ISTRI,TETEMBOMUA,13,10,1970,KAWIN,BUGIS,SD,PETANI,,,,,,,,,10000,,KELAPA LADA DAN KAKAO,,,MILIK SENDIRI,PAPAN,SENG,,`;

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'template_data_penduduk.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    // Function to edit population
    window.editPopulation = function(id) {
        console.log('editPopulation called with id:', id);
        window.currentEditId = id; // Store the current edit ID
        
        fetch(`/admin/population/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate edit form with data
                document.getElementById('editNama').value = data.nama || '';
                document.getElementById('editNik').value = data.nik || '';
                document.getElementById('editNoKk').value = data.no_kk || '';
                document.getElementById('editJenisKelamin').value = data.jenis_kelamin || '';
                document.getElementById('editDusun').value = data.dusun_id == 1 ? 'Dusun 1' : (data.dusun_id == 2 ? 'Dusun 2' : 'Dusun 3');
                document.getElementById('editTempatLahir').value = data.tempat_lahir || '';
                document.getElementById('editTanggalLahir').value = data.tanggal_lahir ? data.tanggal_lahir.split('-')[2] : '';
                document.getElementById('editBulanLahir').value = data.bulan_lahir || '';
                document.getElementById('editTahunLahir').value = data.tahun_lahir || '';
                document.getElementById('editHubunganKepalaKeluarga').value = data.hubungan_kepala_keluarga || '';
                document.getElementById('editAlamatKk').value = data.alamat_kk || '';
                document.getElementById('editStatusPerkawinan').value = data.status_perkawinan || '';
                document.getElementById('editSuku').value = data.suku || '';
                document.getElementById('editPendidikanTerakhir').value = data.pendidikan_terakhir || '';
                document.getElementById('editMataPencaharian').value = data.mata_pencaharian || '';
                document.getElementById('editPekerjaanTambahan').value = data.pekerjaan_tambahan || '';
                document.getElementById('editMobil').value = data.mobil || 0;
                document.getElementById('editMotor').value = data.motor || 0;
                document.getElementById('editSepeda').value = data.sepeda || 0;
                document.getElementById('editSapi').value = data.sapi || 0;
                document.getElementById('editKambing').value = data.kambing || 0;
                document.getElementById('editAyam').value = data.ayam || 0;
                document.getElementById('editLuasLahanPertanian').value = data.luas_lahan_pertanian || 0;
                document.getElementById('editKomoditasUtama').value = data.komoditas_utama || '';
                document.getElementById('editKomoditasBuahSayur').value = data.komoditas_buah_sayur || '';
                document.getElementById('editBantuan').value = data.bantuan || '';
                
                // Show edit modal
                new bootstrap.Modal(document.getElementById('editPopulationModal')).show();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data untuk diedit',
                    confirmButtonColor: '#2E8B57'
                });
            });
    };

    // Function to delete population
    window.deletePopulation = function(id) {
        console.log('deletePopulation called with id:', id);
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data penduduk ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/population/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonColor: '#2E8B57'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menghapus data',
                            confirmButtonColor: '#2E8B57'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal menghapus data',
                        confirmButtonColor: '#2E8B57'
                    });
                });
            }
        });
    };

    // Edit form submission
    document.getElementById('editPopulationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        // Get the population ID from the current edit session
        const populationId = window.currentEditId;
        
        fetch(`/admin/population/${populationId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#2E8B57'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memperbarui data',
                    confirmButtonColor: '#2E8B57'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal memperbarui data',
                confirmButtonColor: '#2E8B57'
            });
        });
    });
});
</script>
@endsection