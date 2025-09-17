@extends('admin.layouts.app')

@section('title', 'Detail Pengumuman - Admin Panel')

@section('content')
<!-- Content Header -->
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-eye me-2"></i>Detail Pengumuman</h2>
            <p class="text-muted mb-0">Lihat detail pengumuman</p>
        </div>
        <div>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<!-- Announcement Detail -->
<div class="card fade-in">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="announcement-detail">
                    <div class="announcement-header mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h1 class="announcement-title">{{ $announcement->title }}</h1>
                            <span class="badge bg-{{ $announcement->priority_color }} fs-6">
                                {{ ucfirst($announcement->priority) }}
                            </span>
                        </div>
                        
                        <div class="announcement-meta mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <strong>Tanggal:</strong> {{ $announcement->formatted_date }}
                                    </p>
                                    @if($announcement->formatted_time)
                                    <p class="mb-2">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <strong>Waktu:</strong> {{ $announcement->formatted_time }} WITA
                                    </p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($announcement->location)
                                    <p class="mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <strong>Lokasi:</strong> {{ $announcement->location }}
                                    </p>
                                    @endif
                                    <p class="mb-2">
                                        <i class="fas fa-sort text-primary me-2"></i>
                                        <strong>Urutan:</strong> {{ $announcement->sort_order }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="announcement-status mb-3">
                            @if($announcement->is_active)
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times-circle me-1"></i>Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($announcement->description)
                    <div class="announcement-content">
                        <h5 class="mb-3">Deskripsi:</h5>
                        <div class="content-text">
                            {{ $announcement->description }}
                        </div>
                    </div>
                    @endif

                    @if($announcement->content)
                    <div class="announcement-content mt-4">
                        <h5 class="mb-3">Konten Lengkap:</h5>
                        <div class="content-text">
                            {!! nl2br(e($announcement->content)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="announcement-sidebar">
                    <!-- Action Buttons -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-cogs me-2"></i>Aksi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Pengumuman
                                </a>
                                <button type="button" class="btn btn-{{ $announcement->is_active ? 'warning' : 'success' }}" 
                                        onclick="toggleStatus({{ $announcement->id }})">
                                    <i class="fas fa-{{ $announcement->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                                    {{ $announcement->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                                <button type="button" class="btn btn-danger" onclick="deleteAnnouncement({{ $announcement->id }})">
                                    <i class="fas fa-trash me-2"></i>Hapus Pengumuman
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Information -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>Informasi
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Dibuat:</strong><br>
                                {{ $announcement->created_at->format('d F Y, H:i') }} WITA
                            </p>
                            <p class="mb-2">
                                <strong>Diperbarui:</strong><br>
                                {{ $announcement->updated_at->format('d F Y, H:i') }} WITA
                            </p>
                            <p class="mb-0">
                                <strong>ID:</strong> {{ $announcement->id }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Forms -->
<form id="deleteAnnouncementForm{{ $announcement->id }}" action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function toggleStatus(id) {
    if (confirm('Apakah Anda yakin ingin mengubah status pengumuman ini?')) {
        fetch(`/admin/announcements/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        }).then(() => {
            location.reload();
        });
    }
}

function deleteAnnouncement(id) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus pengumuman ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteAnnouncementForm' + id).submit();
        }
    });
}
</script>

<style>
.announcement-detail {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.announcement-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-green);
    line-height: 1.2;
}

.announcement-meta p {
    margin-bottom: 0.5rem;
    color: #666;
}

.content-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
    white-space: pre-line;
}

.announcement-sidebar .card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.announcement-sidebar .card-header {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
    color: white;
    border-radius: 10px 10px 0 0 !important;
    border: none;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
    transform: translateY(-2px);
}
</style>
@endsection
