@extends('admin.layouts.app')

@section('title', 'Edit Pengumuman - Admin Panel')

@section('content')
<!-- Content Header -->
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-edit me-2"></i>Edit Pengumuman</h2>
            <p class="text-muted mb-0">Perbarui informasi pengumuman</p>
        </div>
        <div>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<!-- Form -->
<div class="card fade-in">
    <div class="card-body">
        <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $announcement->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $announcement->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="announcement_date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('announcement_date') is-invalid @enderror" 
                               id="announcement_date" name="announcement_date" 
                               value="{{ old('announcement_date', optional($announcement->announcement_date)->format('Y-m-d')) }}" required>
                        @error('announcement_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="announcement_time" class="form-label">Waktu</label>
                        <input type="time" class="form-control @error('announcement_time') is-invalid @enderror" 
                               id="announcement_time" name="announcement_time" 
                               value="{{ old('announcement_time', $announcement->announcement_time ? substr($announcement->announcement_time, 0, 5) : '') }}">
                        @error('announcement_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                               id="location" name="location" value="{{ old('location', $announcement->location) }}" 
                               placeholder="Contoh: Balai Desa, Aula Pertemuan">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                        <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                            <option value="">Pilih Prioritas</option>
                            <option value="low" {{ old('priority', $announcement->priority) == 'low' ? 'selected' : '' }}>Rendah</option>
                            <option value="medium" {{ old('priority', $announcement->priority) == 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="high" {{ old('priority', $announcement->priority) == 'high' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" name="sort_order" value="{{ old('sort_order', $announcement->sort_order) }}" min="0">
                        <small class="text-muted">Angka lebih kecil akan ditampilkan lebih atas</small>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="attachment" class="form-label">Lampiran (opsional)</label>
                        <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                        @error('attachment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($announcement->attachment_path)
                            <small class="d-block mt-1">Lampiran saat ini: <a href="{{ asset('storage/'.$announcement->attachment_path) }}" target="_blank">Unduh</a></small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan pengumuman
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Pengumuman
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
