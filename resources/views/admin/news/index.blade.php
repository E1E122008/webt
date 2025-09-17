@extends('admin.layouts.app')

@section('title', 'Manajemen Berita - Admin Panel')

@section('content')
<!-- Content Header -->
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-newspaper me-2"></i>Manajemen Berita</h2>
            <p class="text-muted mb-0">Kelola berita dan informasi desa</p>
        </div>
        <div>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Berita
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

<!-- News Categories Filter -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card fade-in">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2 text-primary"></i>
                    Filter Berdasarkan Kategori
                </h5>
            </div>
            <div class="card-body">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" data-filter="all">Semua</button>
                    <button type="button" class="btn btn-outline-success" data-filter="umum">Umum</button>
                    <button type="button" class="btn btn-outline-info" data-filter="pertanian">Pertanian</button>
                    <button type="button" class="btn btn-outline-warning" data-filter="sosial">Sosial</button>
                    <button type="button" class="btn btn-outline-secondary" data-filter="ekonomi">Ekonomi</button>
                    <button type="button" class="btn btn-outline-danger" data-filter="pemerintahan">Pemerintahan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- News Table -->
<div class="card fade-in">
    <div class="card-header bg-transparent border-0">
        <h5 class="mb-0">
            <i class="fas fa-list me-2 text-primary"></i>
            Daftar Berita
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $index => $item)
                    <tr class="news-item" data-category="{{ $item->category }}">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span role="button" class="open-image" data-src="{{ $item->image_url }}">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" 
                                     style="width: 60px; height: 40px; object-fit: cover; border-radius: 5px;">
                            </span>
                        </td>
                        <td>
                            <strong>{{ $item->title }}</strong>
                            <br>
                            <small class="text-muted">{{ Str::limit($item->content, 100) }}</small>
                        </td>
                        <td>{{ $item->author->name ?? '-' }}</td>
                        <td>{{ $item->published_at ? $item->published_at->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($item->status == 'published')
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.news.show', $item->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteNews({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="deleteNewsForm{{ $item->id }}" action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display: none;">
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
                <i class="fas fa-newspaper fa-3x text-primary mb-3"></i>
                <h3 class="mb-0">{{ $news->total() ?? $news->count() }}</h3>
                <small>Total Berita</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card success slide-in">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h3 class="mb-0">{{ $news->where('status', 'published')->count() }}</h3>
                <small>Published</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card warning slide-in">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                <h3 class="mb-0">{{ $news->where('status', 'draft')->count() }}</h3>
                <small>Draft</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card info slide-in">
            <div class="card-body text-center">
                <i class="fas fa-calendar fa-3x text-info mb-3"></i>
                <h3 class="mb-0">{{ $news->filter(function($item){ return $item->published_at && $item->published_at->format('Y-m') == now()->format('Y-m'); })->count() }}</h3>
                <small>Bulan Ini</small>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Image Preview Modal -->
<div class="modal fade" id="newsImagePreviewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content" style="background: transparent; border: none;">
      <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
      <img id="newsImagePreviewModalImg" src="" alt="Preview" style="width:100%; height:auto; border-radius:12px; box-shadow:0 20px 40px rgba(0,0,0,.4);">
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterBtns = document.querySelectorAll('[data-filter]');
    const newsItems = document.querySelectorAll('.news-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            newsItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'table-row';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Add click event to all open-image elements
    document.querySelectorAll('.open-image').forEach(function(element) {
        element.addEventListener('click', function() {
            const src = this.getAttribute('data-src');
            if (src) {
                // Use the existing adminImagePreviewModal from gallery
                const modal = document.getElementById('adminImagePreviewModal');
                const modalImg = document.getElementById('adminImagePreviewModalImg');
                if (modal && modalImg) {
                    modalImg.src = src;
                    new bootstrap.Modal(modal).show();
                }
            }
        });
    });
});

function deleteNews(id) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus berita ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'swal-popup-custom',
            title: 'swal-title-custom',
            content: 'swal-content-custom',
            confirmButton: 'swal-confirm-custom',
            cancelButton: 'swal-cancel-custom'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Sedang menghapus berita',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Get form data
            const form = document.getElementById('deleteNewsForm' + id);
            const formData = new FormData(form);
            
            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'swal-popup-custom',
                            title: 'swal-title-custom',
                            content: 'swal-content-custom',
                            confirmButton: 'swal-success-custom'
                        }
                    }).then(() => {
                        // Reload page to update the list
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'swal-popup-custom',
                            title: 'swal-title-custom',
                            content: 'swal-content-custom',
                            confirmButton: 'swal-confirm-custom'
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus berita',
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal-popup-custom',
                        title: 'swal-title-custom',
                        content: 'swal-content-custom',
                        confirmButton: 'swal-confirm-custom'
                    }
                });
            });
        }
    });
}
</script>

<style>
/* SweetAlert Custom Styling */
.swal-popup-custom {
    border-radius: 15px !important;
    font-family: 'Poppins', sans-serif !important;
}

.swal-title-custom {
    color: var(--text-dark) !important;
    font-weight: 600 !important;
    font-size: 1.5rem !important;
}

.swal-content-custom {
    color: var(--text-light) !important;
    font-size: 1rem !important;
}

.swal-confirm-custom {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    border-radius: 8px !important;
    font-weight: 500 !important;
    padding: 0.75rem 1.5rem !important;
    font-size: 0.9rem !important;
}

.swal-confirm-custom:hover {
    background-color: #c82333 !important;
    border-color: #bd2130 !important;
}

.swal-cancel-custom {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    border-radius: 8px !important;
    font-weight: 500 !important;
    padding: 0.75rem 1.5rem !important;
    font-size: 0.9rem !important;
}

.swal-cancel-custom:hover {
    background-color: #5a6268 !important;
    border-color: #545b62 !important;
}

.swal-success-custom {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    border-radius: 8px !important;
    font-weight: 500 !important;
    padding: 0.75rem 1.5rem !important;
    font-size: 0.9rem !important;
}

.swal-success-custom:hover {
    background-color: #218838 !important;
    border-color: #1e7e34 !important;
}

/* SweetAlert Loading */
.swal2-loader {
    border-color: var(--primary-green) transparent var(--primary-green) transparent !important;
}

/* Filter Styles */
.news-item {
    transition: all 0.3s ease;
}

.btn-group .btn {
    border-radius: 20px;
    margin-right: 5px;
}

.btn-group .btn.active {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}
</style>
