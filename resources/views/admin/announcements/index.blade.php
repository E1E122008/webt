@extends('admin.layouts.app')

@section('title', 'Manajemen Pengumuman - Admin Panel')

@section('content')
<!-- Content Header -->
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-bullhorn me-2"></i>Manajemen Pengumuman</h2>
            <p class="text-muted mb-0">Kelola pengumuman dan informasi penting desa</p>
        </div>
        <div>
            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Pengumuman
            </a>
        </div>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Announcements Table -->
<div class="card fade-in">
    <div class="card-header bg-transparent border-0">
        <h5 class="mb-0">
            <i class="fas fa-list me-2 text-primary"></i>
            Daftar Pengumuman
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Lampiran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($announcements as $index => $announcement)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        
                        <td>
                            <strong>{{ $announcement->title }}</strong>
                            @if($announcement->description)
                                <br>
                                <small class="text-muted">{{ Str::limit($announcement->description, 100) }}</small>
                            @endif
                        </td>
                        <td>{{ $announcement->formatted_date }}</td>
                        <td>{{ $announcement->formatted_time ?? '-' }}</td>
                        <td>{{ $announcement->location ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $announcement->priority_color }}">
                                {{ ucfirst($announcement->priority) }}
                            </span>
                        </td>
                        <td>
                            @if($announcement->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            @if($announcement->attachment_path)
                                <a href="{{ asset('storage/'.$announcement->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download"></i>
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-{{ $announcement->is_active ? 'warning' : 'success' }}" 
                                        onclick="toggleStatus({{ $announcement->id }})">
                                    <i class="fas fa-{{ $announcement->is_active ? 'eye-slash' : 'eye' }}"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteAnnouncement({{ $announcement->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="deleteAnnouncementForm{{ $announcement->id }}" action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card slide-in">
            <div class="card-body text-center">
                <i class="fas fa-bullhorn fa-3x text-primary mb-3"></i>
                <h3 class="mb-0">{{ $announcements->total() ?? $announcements->count() }}</h3>
                <small>Total Pengumuman</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card success slide-in">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h3 class="mb-0">{{ $announcements->where('is_active', true)->count() }}</h3>
                <small>Aktif</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card warning slide-in">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h3 class="mb-0">{{ $announcements->where('priority', 'high')->count() }}</h3>
                <small>Prioritas Tinggi</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card info slide-in">
            <div class="card-body text-center">
                <i class="fas fa-calendar fa-3x text-info mb-3"></i>
                <h3 class="mb-0">{{ $announcements->filter(function($item){ return $item->announcement_date >= now()->toDateString(); })->count() }}</h3>
                <small>Mendatang</small>
            </div>
        </div>
    </div>
</div>
@endsection

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
.stat-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.btn-group .btn {
    border-radius: 5px;
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
 
