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
                    <tr>
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
    const previewModal = document.getElementById('newsImagePreviewModal');
    const previewImg = document.getElementById('newsImagePreviewModalImg');
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
