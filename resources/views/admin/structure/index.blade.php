@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi - Admin Panel')

@section('content')
<div class="content-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-sitemap me-2"></i>Kelola Struktur Organisasi</h2>
            <p class="text-muted mb-0">Perbarui nama, foto, dan informasi jabatan</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEntryModal">
                <i class="fas fa-plus me-2"></i>Tambah Struktur
            </button>
        </div>
    </div>
</div>

@php
    $entries = $struktur['entries'] ?? [ 'rt' => [], 'dusun' => [], 'perangkat' => [], 'bpd' => [], 'lpm' => [] ];
    $categoryLabels = [ 'rt' => 'RT', 'dusun' => 'Kepala Dusun', 'perangkat' => 'Perangkat Desa', 'bpd' => 'BPD', 'lpm' => 'LPM' ];
@endphp

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Structure Categories Filter -->
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
                    <button type="button" class="btn btn-outline-success" data-filter="kepala_desa">Kepala Desa</button>
                    <button type="button" class="btn btn-outline-info" data-filter="perangkat">Perangkat</button>
                    <button type="button" class="btn btn-outline-warning" data-filter="bpd">BPD</button>
                    <button type="button" class="btn btn-outline-secondary" data-filter="lpm">LPM</button>
                    <button type="button" class="btn btn-outline-danger" data-filter="dusun">Dusun</button>
                    <button type="button" class="btn btn-outline-dark" data-filter="rt">RT</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card fade-in">
    <div class="card-body">
        <form action="{{ route('admin.structure.kades.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h5 class="mb-3"><i class="fas fa-user-tie me-2 text-success"></i>Kepala Desa</h5>
            <div class="row g-3 mb-4 structure-item" data-role-type="kepala_desa">
                <div class="col-md-3 text-center">
                    <div class="border rounded p-2">
                        <span role="button" class="open-image" data-src="{{ $struktur['kades']['photo'] ?? asset('FOTO/LOGO.png') }}">
                            <img src="{{ $struktur['kades']['photo'] ?? asset('FOTO/LOGO.png') }}" alt="Kepala Desa" class="img-fluid" style="max-height:160px; object-fit:cover;">
                        </span>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="kades_name" class="form-control" value="{{ $struktur['kades']['name'] ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Informasi</label>
                        <input type="text" name="kades_info" class="form-control" value="{{ $struktur['kades']['info'] ?? '' }}" placeholder="Misal: Masa Jabatan 2024 - Sekarang">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="kades_photo" class="form-control" accept="image/*">
                        <small class="text-muted">Format JPG/PNG, disarankan rasio 1:1</small>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan Kepala Desa</button>
            </div>
        </form>
    </div>
</div>

<div class="card fade-in mb-4">
    <div class="card-header bg-transparent border-0">
        <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Daftar Struktur per Kategori</h5>
    </div>
    <div class="card-body">
        @foreach($entries as $cat => $list)
        <div class="mb-4">
            <h6 class="text-uppercase text-muted mb-3">{{ $categoryLabels[$cat] }}</h6>
            @if(count($list) === 0)
                <p class="text-muted">Belum ada data.</p>
            @else
            <div class="row g-3">
                @foreach($list as $item)
                <div class="col-lg-4 col-md-6 structure-item" data-role-type="{{ $cat }}">
                    <div class="p-3 border rounded h-100 d-flex">
                        <div class="me-3" style="width:64px;height:64px;flex:0 0 64px;">
                            <span role="button" class="open-image" data-src="{{ $item['photo'] ?? asset('FOTO/LOGO-removebg-preview.png') }}">
                                <img src="{{ $item['photo'] ?? asset('FOTO/LOGO-removebg-preview.png') }}" alt="{{ $item['name'] }}" class="rounded" style="width:64px;height:64px;object-fit:cover;">
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $item['name'] }}</strong>
                                    <div class="small text-muted">
                                        {{ ($item['role_type'] ?? '') === 'lainnya' ? ($item['role_text'] ?? 'Lainnya') : ucfirst($item['role_type'] ?? '') }}
                                    </div>
                                    @if(!empty($item['info']))
                                        <div class="small text-muted">{{ $item['info'] }}</div>
                                    @endif
                                </div>
                                <div class="btn-group btn-group-sm">
                                    @if(!empty($item['photo']))
                                    <a class="btn btn-outline-secondary" href="{{ $item['photo'] }}" target="_blank" title="Lihat"><i class="fas fa-eye"></i></a>
                                    @endif
                                    <button class="btn btn-outline-warning" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#editEntryModal"
                                        data-id="{{ $item['id'] }}"
                                        data-category="{{ $item['category'] }}"
                                        data-name="{{ $item['name'] }}"
                                        data-role_type="{{ $item['role_type'] }}"
                                        data-role_text="{{ $item['role_text'] ?? '' }}"
                                        data-info="{{ $item['info'] ?? '' }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.structure.entry.delete', $item['id']) }}" method="POST" class="delete-entry-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-delete-entry" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<!-- Add Entry Modal -->
<div class="modal fade" id="addEntryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Struktur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.structure.entry.store') }}" method="POST" enctype="multipart/form-data" id="addEntryForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="dusun">Kepala Dusun</option>
                            <option value="rt">RT</option>
                            <option value="perangkat">Perangkat Desa</option>
                            <option value="bpd">BPD</option>
                            <option value="lpm">LPM</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <select name="role_type" class="form-control" id="add_role_type" required>
                            <option value="ketua">Ketua</option>
                            <option value="sekretaris">Sekretaris</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3" id="add_number_wrap" style="display:none;">
                        <label class="form-label" id="add_number_label">Nomor</label>
                        <input type="number" class="form-control" id="add_unit_number" min="1" value="1">
                        <small class="text-muted">Isi angka RT/Dusun</small>
                    </div>
                    <div class="mb-3" id="add_role_text_wrap" style="display:none;">
                        <label class="form-label">Teks Jabatan</label>
                        <input type="text" class="form-control" name="role_text" placeholder="Contoh: Bendahara">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Informasi (opsional)</label>
                        <input type="text" class="form-control" name="info" placeholder="Keterangan tambahan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto (opsional)</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
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

<!-- Edit Entry Modal -->
<div class="modal fade" id="editEntryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Struktur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data" id="editEntryForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-control" id="edit_category" required>
                            <option value="dusun">Kepala Dusun</option>
                            <option value="rt">RT</option>
                            <option value="perangkat">Perangkat Desa</option>
                            <option value="bpd">BPD</option>
                            <option value="lpm">LPM</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <select name="role_type" class="form-control" id="edit_role_type" required>
                            <option value="ketua">Ketua</option>
                            <option value="sekretaris">Sekretaris</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3" id="edit_number_wrap" style="display:none;">
                        <label class="form-label" id="edit_number_label">Nomor</label>
                        <input type="number" class="form-control" id="edit_unit_number" min="1" value="1">
                        <small class="text-muted">Isi angka RT/Dusun</small>
                    </div>
                    <div class="mb-3" id="edit_role_text_wrap" style="display:none;">
                        <label class="form-label">Teks Jabatan</label>
                        <input type="text" class="form-control" name="role_text" id="edit_role_text" placeholder="Contoh: Bendahara">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Informasi (opsional)</label>
                        <input type="text" class="form-control" name="info" id="edit_info" placeholder="Keterangan tambahan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto (opsional)</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
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

<style>
.structure-item {
    transition: all 0.3s ease;
}

.structure-item:hover {
    transform: translateY(-5px);
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterBtns = document.querySelectorAll('[data-filter]');
    const structureItems = document.querySelectorAll('.structure-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            structureItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-role-type') === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    const addRole = document.getElementById('add_role_type');
    const addRoleWrap = document.getElementById('add_role_text_wrap');
    const addCategory = document.querySelector('#addEntryForm select[name="category"]');
    const addNumberWrap = document.getElementById('add_number_wrap');
    const addNumberInput = document.getElementById('add_unit_number');
    const addNumberLabel = document.getElementById('add_number_label');
    const addRoleTextInput = document.querySelector('#addEntryForm input[name="role_text"]');
    if (addRole && addCategory) {
        const toggleAddControls = () => {
            const cat = addCategory.value;
            if (cat === 'rt' || cat === 'dusun') {
                // force role_type to 'lainnya' and hide both role selectors
                addRole.value = 'lainnya';
                addRole.closest('.mb-3').style.display = 'none';
                addRoleWrap.style.display = 'none';
                addNumberWrap.style.display = 'block';
                addNumberLabel.textContent = (cat === 'rt') ? 'Nomor RT' : 'Nomor Dusun';
                addNumberInput.min = 1;
                addNumberInput.max = (cat === 'rt') ? 6 : 3;
                // set role_text as "RT X" or "Dusun Y"
                const prefix = (cat === 'rt') ? 'RT ' : 'Dusun ';
                addRoleTextInput.value = prefix + (addNumberInput.value || 1);
            } else {
                addRole.closest('.mb-3').style.display = 'block';
                // default show role text only if 'lainnya'
                addNumberWrap.style.display = 'none';
                addRoleWrap.style.display = addRole.value === 'lainnya' ? 'block' : 'none';
                addRoleTextInput.value = addRole.value === 'lainnya' ? (addRoleTextInput.value || '') : '';
            }
        };
        addCategory.addEventListener('change', toggleAddControls);
        addRole.addEventListener('change', toggleAddControls);
        addNumberInput.addEventListener('input', () => {
            const cat = addCategory.value;
            const prefix = (cat === 'rt') ? 'RT ' : 'Dusun ';
            addRoleTextInput.value = prefix + (addNumberInput.value || 1);
        });
        toggleAddControls();
    }

    const editModal = document.getElementById('editEntryModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const category = button.getAttribute('data-category');
        const name = button.getAttribute('data-name');
        const roleType = button.getAttribute('data-role_type');
        const roleText = button.getAttribute('data-role_text');
        const info = button.getAttribute('data-info');

        const form = document.getElementById('editEntryForm');
        form.action = '{{ url('admin/structure/entry') }}/' + encodeURIComponent(id);
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_role_type').value = roleType || 'ketua';
        document.getElementById('edit_role_text').value = roleText || '';
        document.getElementById('edit_info').value = info || '';

        const roleWrap = document.getElementById('edit_role_text_wrap');
        const roleTypeSelect = document.getElementById('edit_role_type');
        const numberWrap = document.getElementById('edit_number_wrap');
        const numberInput = document.getElementById('edit_unit_number');
        const numberLabel = document.getElementById('edit_number_label');

        const toggleEditControls = () => {
            const cat = document.getElementById('edit_category').value;
            if (cat === 'rt' || cat === 'dusun') {
                roleTypeSelect.value = 'lainnya';
                roleTypeSelect.closest('.mb-3').style.display = 'none';
                roleWrap.style.display = 'none';
                numberWrap.style.display = 'block';
                numberLabel.textContent = (cat === 'rt') ? 'Nomor RT' : 'Nomor Dusun';
                numberInput.min = 1;
                numberInput.max = (cat === 'rt') ? 6 : 3;
                // parse existing role_text like "RT 3" or "Dusun 2"
                const m = (roleText || '').match(/(\d+)/);
                numberInput.value = m ? m[1] : (numberInput.value || 1);
                const prefix = (cat === 'rt') ? 'RT ' : 'Dusun ';
                document.getElementById('edit_role_text').value = prefix + numberInput.value;
            } else {
                roleTypeSelect.closest('.mb-3').style.display = 'block';
                numberWrap.style.display = 'none';
                roleWrap.style.display = (roleTypeSelect.value === 'lainnya') ? 'block' : 'none';
            }
        };

        document.getElementById('edit_category').addEventListener('change', toggleEditControls);
        roleTypeSelect.addEventListener('change', toggleEditControls);
        numberInput.addEventListener('input', () => {
            const cat = document.getElementById('edit_category').value;
            const prefix = (cat === 'rt') ? 'RT ' : 'Dusun ';
            document.getElementById('edit_role_text').value = prefix + (numberInput.value || 1);
        });

        toggleEditControls();
    });
    // SweetAlert2 confirm for delete buttons
    document.querySelectorAll('.btn-delete-entry').forEach((btn) => {
        btn.addEventListener('click', function(e) {
            const form = this.closest('form.delete-entry-form');
            Swal.fire({
                title: 'Hapus data ini?',
                text: 'Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
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
</script>
@endsection




@endsection


