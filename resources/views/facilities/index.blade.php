@extends('admin.layouts.app')

@section('title', 'Sarana & Prasarana Desa')

@section('content')
<div class="content-header">
    <h2>Sarana & Prasarana Desa</h2>
    <p class="text-muted">Kelola data sarana dan prasarana desa</p>
        </div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
                        @endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
@endif

<!-- Tombol Tambah -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
        <i class="fas fa-plus me-2"></i> Tambah Sarana/Prasarana
                                    </button>
                            </div>

<!-- Facilities Display -->
<div class="row">
    @if($facilitiesByBidang->count() > 0)
        @foreach($facilitiesByBidang as $bidang => $facilities)
            @if($facilities->count() > 0)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="facility-category-card">
                        <div class="facility-category-header">
                            @php
                                $categoryIcons = [
                                    'Kesehatan' => 'fas fa-heartbeat',
                                    'Pendidikan' => 'fas fa-graduation-cap', 
                                    'Keagamaan' => 'fas fa-mosque',
                                    'Infrastruktur' => 'fas fa-tools',
                                    'Air & Sanitasi' => 'fas fa-tint',
                                    'Olahraga & Rekreasi' => 'fas fa-dumbbell',
                                    'Lainnya' => 'fas fa-building'
                                ];
                                $categoryColors = [
                                    'Kesehatan' => 'text-danger',
                                    'Pendidikan' => 'text-primary',
                                    'Keagamaan' => 'text-success',
                                    'Infrastruktur' => 'text-warning',
                                    'Air & Sanitasi' => 'text-info',
                                    'Olahraga & Rekreasi' => 'text-success',
                                    'Lainnya' => 'text-secondary'
                                ];
                                $icon = $categoryIcons[$bidang] ?? 'fas fa-building';
                                $color = $categoryColors[$bidang] ?? 'text-secondary';
                            @endphp
                            <i class="{{ $icon }} fa-2x {{ $color }}"></i>
                            <h5 class="{{ $color }}">{{ $bidang ?? 'Lainnya' }}</h5>
                        </div>
                        <div class="facility-category-body">
                            @foreach($facilities as $facility)
                                <div class="facility-item">
                                    <div class="facility-item-content">
                                        <div class="facility-info">
                                        <span class="facility-name">{{ $facility->nama }}</span>
                                        <span class="facility-count">{{ $facility->jumlah_unit }} unit</span>
                                        </div>
                                        <div class="facility-actions">
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editFacilityModal"
                                                    onclick="editFacility({{ $facility->id }}, '{{ $facility->nama }}', '{{ $facility->bidang }}', {{ $facility->jumlah_unit }}, '{{ addslashes($facility->deskripsi) }}')"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteFacility({{ $facility->id }}, '{{ $facility->nama }}')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @if($facility->deskripsi)
                                        <div class="facility-description">{{ $facility->deskripsi }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
                <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-building fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum ada data sarana atau prasarana</h4>
                    <p class="text-muted">Mulai dengan menambahkan sarana atau prasarana pertama Anda.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
                        <i class="fas fa-plus me-2"></i> Tambah Sarana/Prasarana
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Detailed View Modal -->
<div class="modal fade" id="categoryDetailsModal" tabindex="-1" aria-labelledby="categoryDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryDetailsModalLabel">
                    <i class="fas fa-list me-2"></i>Detail Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="categoryDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal Tambah Facility -->
<div class="modal fade" id="addFacilityModal" tabindex="-1" aria-labelledby="addFacilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFacilityModalLabel">
                        <i class="fas fa-plus me-2"></i>Tambah Sarana/Prasarana
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                    <div class="mb-3">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                <select name="bidang" class="form-control @error('bidang') is-invalid @enderror" required>
                                    <option value="">Pilih Bidang</option>
                                    <option value="Kesehatan" {{ old('bidang') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                    <option value="Pendidikan" {{ old('bidang') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                    <option value="Keagamaan" {{ old('bidang') == 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                                    <option value="Infrastruktur" {{ old('bidang') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                    <option value="Air & Sanitasi" {{ old('bidang') == 'Air & Sanitasi' ? 'selected' : '' }}>Air & Sanitasi</option>
                                    <option value="Olahraga & Rekreasi" {{ old('bidang') == 'Olahraga & Rekreasi' ? 'selected' : '' }}>Olahraga & Rekreasi</option>
                                    <option value="Lainnya" {{ old('bidang') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('bidang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Jumlah Unit <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_unit" class="form-control @error('jumlah_unit') is-invalid @enderror" 
                                       min="0" value="{{ old('jumlah_unit') }}" required>
                                @error('jumlah_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Facility -->
<div class="modal fade" id="editFacilityModal" tabindex="-1" aria-labelledby="editFacilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFacilityForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editFacilityModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Sarana/Prasarana
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="edit_nama" class="form-control @error('nama') is-invalid @enderror" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                    </div>
                        <div class="col-md-6">
                    <div class="mb-3">
                                <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                <select name="bidang" id="edit_bidang" class="form-control @error('bidang') is-invalid @enderror" required>
                                    <option value="">Pilih Bidang</option>
                                    <option value="Kesehatan">Kesehatan</option>
                                    <option value="Pendidikan">Pendidikan</option>
                                    <option value="Keagamaan">Keagamaan</option>
                                    <option value="Infrastruktur">Infrastruktur</option>
                                    <option value="Air & Sanitasi">Air & Sanitasi</option>
                                    <option value="Olahraga & Rekreasi">Olahraga & Rekreasi</option>
                                    <option value="Lainnya">Lainnya</option>
                        </select>
                                @error('bidang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                    <div class="mb-3">
                                <label class="form-label">Jumlah Unit <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_unit" id="edit_jumlah_unit" class="form-control @error('jumlah_unit') is-invalid @enderror" min="0" required>
                                @error('jumlah_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4"></textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteFacilityModal" tabindex="-1" aria-labelledby="deleteFacilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFacilityModalLabel">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data sarana/prasarana:</p>
                <div class="alert alert-warning">
                    <strong id="deleteFacilityName"></strong>
                </div>
                <p class="text-muted">Data yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form id="deleteFacilityForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.facility-category-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-green);
    min-height: 200px;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.facility-category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(46, 139, 87, 0.2);
}

.facility-category-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(46, 139, 87, 0.1);
}

.facility-category-header i {
    margin-right: 1rem;
}

.facility-category-header h5 {
    margin-bottom: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.facility-category-body {
    margin-bottom: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.facility-item {
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: rgba(46, 139, 87, 0.05);
    border-radius: 8px;
    border-left: 3px solid var(--primary-green);
}

.facility-item:last-child {
    margin-bottom: 0;
}

.facility-item-content {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 0.25rem;
    gap: 1rem;
}

.facility-info {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    min-width: 0; /* Allow text wrapping */
}

.facility-name {
    font-weight: 500;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    word-wrap: break-word;
    line-height: 1.3;
}

.facility-count {
    font-size: 0.9rem;
    color: var(--text-light);
    white-space: nowrap;
    align-self: flex-start;
}

.facility-actions {
    display: flex;
    gap: 0.5rem;
    align-items: flex-start;
    flex-shrink: 0;
    margin-top: 0.25rem;
}

.facility-actions .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
    border-radius: 6px;
    transition: all 0.2s ease;
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.facility-actions .btn:hover {
    transform: translateY(-1px);
}

.facility-status {
    font-size: 1.1rem;
}

.facility-description {
    font-size: 0.8rem;
    display: block;
    margin-top: 0.5rem;
    color: var(--text-light);
    line-height: 1.4;
    word-wrap: break-word;
    padding: 0.5rem;
    background: rgba(46, 139, 87, 0.03);
    border-radius: 4px;
    border-left: 2px solid rgba(46, 139, 87, 0.2);
}

.facility-category-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(46, 139, 87, 0.1);
}

.facility-category-actions .btn {
    flex: 1;
    max-width: 120px;
}

/* Empty state styling */
.facility-item.empty {
    background: rgba(108, 117, 125, 0.05);
    border-left-color: #6c757d;
}

.facility-item.empty .facility-name {
    color: #6c757d;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .facility-category-card {
        margin-bottom: 1rem;
        padding: 1rem;
    }
    
    .facility-item {
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .facility-item-content {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }
    
    .facility-info {
        margin-bottom: 0.5rem;
    }
    
    .facility-name {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .facility-count {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .facility-actions {
        justify-content: flex-end;
        margin-top: 0;
        gap: 0.75rem;
    }
    
    .facility-actions .btn {
        min-width: 40px;
        height: 40px;
        font-size: 0.9rem;
    }
    
    .facility-description {
        margin-top: 0.75rem;
        padding: 0.75rem;
        font-size: 0.85rem;
    }
    
    .facility-category-actions {
        flex-direction: column;
    }
    
    .facility-category-actions .btn {
        max-width: none;
    }
}
</style>

<script>
function toggleCategoryDetails(categoryName) {
    // This function can be expanded to show detailed view of facilities in a category
    const modal = new bootstrap.Modal(document.getElementById('categoryDetailsModal'));
    document.getElementById('categoryDetailsModalLabel').innerHTML = 
        `<i class="fas fa-list me-2"></i>Detail Kategori - ${categoryName}`;
    
    // For now, just show a placeholder
    document.getElementById('categoryDetailsContent').innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-building fa-3x text-muted mb-3"></i>
            <p class="text-muted">Fitur detail kategori akan segera tersedia.</p>
        </div>
    `;
    
    modal.show();
}

// Add fade-in animation to cards and handle modal errors
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.facility-category-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Auto-open modal if there are validation errors
    @if($errors->any())
        const modal = new bootstrap.Modal(document.getElementById('addFacilityModal'));
        modal.show();
    @endif
});

// Edit facility function
function editFacility(id, nama, bidang, jumlahUnit, deskripsi) {
    // Set form action URL
    document.getElementById('editFacilityForm').action = `/admin/facilities/${id}`;
    
    // Fill form fields
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_bidang').value = bidang;
    document.getElementById('edit_jumlah_unit').value = jumlahUnit;
    document.getElementById('edit_deskripsi').value = deskripsi || '';
}

// Delete facility function
function deleteFacility(id, nama) {
    // Set form action URL
    document.getElementById('deleteFacilityForm').action = `/admin/facilities/${id}`;
    
    // Set facility name in confirmation modal
    document.getElementById('deleteFacilityName').textContent = nama;
    
    // Show confirmation modal
    const modal = new bootstrap.Modal(document.getElementById('deleteFacilityModal'));
    modal.show();
}
</script>
@endsection
