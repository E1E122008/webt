@extends('layouts.app')

@section('title', 'Sarana & Prasarana Desa')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 mt-5">Daftar Sarana & Prasarana Desa</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
        <i class="fas fa-plus"></i> Tambah Sarana/Prasarana
    </button>

    @forelse($facilitiesByBidang as $bidang => $facilities)
        <h4 class="mt-4 mb-3 text-uppercase">{{ $bidang ?? 'Lainnya' }}</h4>
        <div class="row">
            @forelse($facilities as $facility)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($facility->gambar)
                            <img src="{{ asset('storage/' . $facility->gambar) }}" class="card-img-top" alt="{{ $facility->nama }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $facility->nama }}</h5>
                            <span class="badge bg-info">{{ ucfirst($facility->jenis) }}</span>
                            <span class="badge bg-success">{{ ucfirst($facility->status) }}</span>
                            <p class="card-text mt-2">{{ Str::limit($facility->deskripsi, 100) }}</p>
                            <a href="{{ route('facilities.show', $facility->id) }}" class="btn btn-outline-primary btn-sm">Detail</a>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editFacilityModal{{ $facility->id }}"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Facility -->
                <div class="modal fade" id="editFacilityModal{{ $facility->id }}" tabindex="-1" aria-labelledby="editFacilityModalLabel{{ $facility->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editFacilityModalLabel{{ $facility->id }}">Edit Sarana/Prasarana</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="{{ $facility->nama }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Bidang</label>
                                        <input type="text" name="bidang" class="form-control" value="{{ $facility->bidang }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Jenis</label>
                                        <select name="jenis" class="form-control" required>
                                            <option value="sarana" {{ $facility->jenis == 'sarana' ? 'selected' : '' }}>Sarana</option>
                                            <option value="prasarana" {{ $facility->jenis == 'prasarana' ? 'selected' : '' }}>Prasarana</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control" required>{{ $facility->deskripsi }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label>Gambar (biarkan kosong jika tidak diubah)</label>
                                        <input type="file" name="gambar" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="aktif" {{ $facility->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ $facility->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Belum ada data sarana atau prasarana.</p>
                </div>
            @endforelse
        </div>
    @empty
        <div class="col-12">
            <p class="text-center">Belum ada data sarana atau prasarana.</p>
        </div>
    @endforelse
</div>

<!-- Modal Tambah Facility -->
<div class="modal fade" id="addFacilityModal" tabindex="-1" aria-labelledby="addFacilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('facilities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFacilityModalLabel">Tambah Sarana/Prasarana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Bidang</label>
                        <input type="text" name="bidang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control" required>
                            <option value="sarana">Sarana</option>
                            <option value="prasarana">Prasarana</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
