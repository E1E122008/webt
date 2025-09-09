@extends('admin.layouts.app')

@section('title', 'Detail Berita - Admin Panel')

@section('content')

<!-- Content Header -->
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-eye me-2"></i>Detail Berita</h2>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.news') }}">Berita</a></li>
        <li class="breadcrumb-item active">Detail Berita</li>
    </ol>
</nav>

<!-- Detail Berita -->
<div class="card fade-in">
    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-eye me-2 text-primary"></i>
            Informasi Berita
        </h5>
        <a href="{{ route('admin.news') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kiri -->
            <div class="col-lg-8">
                <!-- Judul -->
                <div class="mb-3">
                    <h3 class="fw-bold">{{ $news->title }}</h3>
                </div>

                <!-- Isi Berita -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Berita</label>
                    <div class="border rounded p-3" style="background: #f9f9f9;">
                        {!! $news->content !!}
                    </div>
                </div>

                <!-- Ringkasan -->
                @if($news->excerpt)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ringkasan</label>
                        <p>{{ $news->excerpt }}</p>
                    </div>
                @endif
            </div>

            <!-- Kanan -->
            <div class="col-lg-4">
                <!-- Gambar -->
                @if($news->image_url)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar</label>
                        <div>
                            <img src="{{ $news->image_url }}" alt="Image" 
                                 class="img-fluid rounded shadow-sm" style="width:100%; max-height:250px; object-fit:cover;">
                        </div>
                    </div>
                @endif

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <p>
                        <span class="badge {{ $news->status == 'published' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($news->status) }}
                        </span>
                    </p>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <p>{{ ucfirst($news->category) }}</p>
                </div>

                <!-- Penulis -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Penulis</label>
                    <p>{{ $news->author->name ?? '-' }}</p>
                </div>

                <!-- Tanggal -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Publikasi</label>
                    <p>{{ $news->published_at ? $news->published_at->format('d M Y H:i') : '-' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Dibuat</label>
                    <p>{{ $news->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Diperbarui</label>
                    <p>{{ $news->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
