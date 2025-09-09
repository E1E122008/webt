@extends('admin.layouts.app')

@section('title', 'Edit Berita - Admin Panel')

@section('content')

<!-- Content Header -->
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-edit me-2"></i>Edit Berita</h2>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.news') }}">Berita</a></li>
        <li class="breadcrumb-item active">Edit Berita</li>
    </ol>
</nav>

<!-- Form Card -->
<div class="card fade-in">
    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-3">
            <i class="fas fa-edit me-2 text-primary"></i>
            Form Edit Berita
        </h5>
        <a href="{{ route('admin.news') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ $news->title }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10" required>{{ $news->content }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Gunakan format HTML untuk formatting teks</small>
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Ringkasan</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" name="excerpt" rows="3">{{ $news->excerpt }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Ringkasan singkat berita (opsional)</small>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Berita</label>
                        <div class="image-upload-container">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <div class="image-preview mt-2" id="imagePreview" style="display: none;">
                                <img id="previewImg" src="{{ $news->image_url }}" alt="Preview" 
                                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">
                            </div>
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="draft" {{ $news->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $news->status == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                            <option value="umum" {{ $news->category == 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="pembangunan" {{ $news->category == 'pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                            <option value="pertanian" {{ $news->category == 'pertanian' ? 'selected' : '' }}>Pertanian</option>
                            <option value="sosial" {{ $news->category == 'sosial' ? 'selected' : '' }}>Sosial</option>
                            <option value="pendidikan" {{ $news->category == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tags -->
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                               id="tags" name="tags" value="{{ $news->tags }}" 
                               placeholder="Pisahkan dengan koma">
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Contoh: desa, pertanian, pembangunan</small>
                    </div>

                    <!-- Publish Date -->
                    <div class="mb-3">
                        <label for="publish_date" class="form-label">Tanggal Publikasi</label>
                        <input type="datetime-local" class="form-control @error('publish_date') is-invalid @enderror" 
                               id="publish_date" name="publish_date" value="{{ $news->publish_date ? $news->publish_date->format('Y-m-d\TH:i') : date('Y-m-d\TH:i') }}">
                        @error('publish_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <hr>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.news') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Berita
                        </button>
                    </div>
                </div>
            </div>
        </form>
            @method('PUT')
        </form>
    </div>
</div>

@endsection