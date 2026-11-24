@extends('layouts.admin')

@section('title', 'Kelola Kategori Buku - BookStore')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Kelola Kategori Buku</h3>
        <p class="text-muted small mb-0">Tambah, ubah, dan hapus kategori koleksi buku</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;" class="text-center">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th class="text-center" style="width: 140px;">Jumlah Buku</th>
                    <th class="text-center" style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $idx => $cat)
                    <tr>
                        <td class="text-center">{{ $categories->firstItem() + $idx }}</td>
                        <td>
                            <strong class="text-dark">{{ $cat->name }}</strong>
                        </td>
                        <td class="text-muted small">{{ $cat->description ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-secondary-subtle text-secondary border">{{ $cat->books_count }} buku</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-outline-warning btn-edit-category" 
                                    data-id="{{ $cat->id }}" 
                                    data-name="{{ $cat->name }}" 
                                    data-description="{{ $cat->description }}"
                                    title="Edit Kategori">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                @if($cat->books_count > 0)
                                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Kategori tidak dapat dihapus karena masih memuat {{ $cat->books_count }} buku">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @else
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-delete-category" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteCategoryModal" 
                                            data-id="{{ $cat->id }}" 
                                            data-name="{{ $cat->name }}" 
                                            title="Hapus Kategori">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="card-footer bg-white d-flex justify-content-center py-3">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kategori Buku Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="name" class="form-label fw-semibold mb-1">Judul / Nama Kategori <span class="text-danger">*</span></label>
                            <span class="text-muted small">10 - 20 Karakter</span>
                        </div>
                        <input type="text" class="form-control" id="name" name="name" required minlength="10" maxlength="20" placeholder="Contoh: Novel Remaja Populer">
                        <small class="text-muted">Minimal 10 dan maksimal 20 karakter.</small>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="description" class="form-label fw-semibold mb-1">Deskripsi Kategori <span class="text-danger">*</span></label>
                            <span class="text-muted small">50 - 100 Karakter</span>
                        </div>
                        <textarea class="form-control" id="description" name="description" rows="3" required minlength="50" maxlength="100" placeholder="Tuliskan deskripsi lengkap mengenai kategori ini (minimal 50 dan maksimal 100 karakter)..."></textarea>
                        <small class="text-muted">Panjang deskripsi wajib antara 50 sampai 100 karakter.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Kategori Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="edit_name" class="form-label fw-semibold mb-1">Judul / Nama Kategori <span class="text-danger">*</span></label>
                            <span class="text-muted small">10 - 20 Karakter</span>
                        </div>
                        <input type="text" class="form-control" id="edit_name" name="name" required minlength="10" maxlength="20">
                        <small class="text-muted">Minimal 10 dan maksimal 20 karakter.</small>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="edit_description" class="form-label fw-semibold mb-1">Deskripsi Kategori <span class="text-danger">*</span></label>
                            <span class="text-muted small">50 - 100 Karakter</span>
                        </div>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" required minlength="50" maxlength="100"></textarea>
                        <small class="text-muted">Panjang deskripsi wajib antara 50 sampai 100 karakter.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Perbarui Kategori</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Kategori -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="deleteCategoryModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-trash3 text-danger fs-1 d-block mb-3"></i>
                <h5 class="fw-bold text-dark mb-2">Hapus Kategori Buku?</h5>
                <p class="text-muted mb-0">
                    Apakah Anda yakin ingin menghapus kategori <strong id="deleteModalCategoryName" class="text-dark"></strong>?
                </p>
            </div>
            <div class="modal-footer border-top-0 pt-0 justify-content-center pb-4">
                <button type="button" class="btn btn-secondary px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
                <form id="deleteCategoryForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-bold">
                        <i class="bi bi-trash me-1"></i> Ya, Hapus Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit-category');
        const editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        const editForm = document.getElementById('editCategoryForm');
        const editName = document.getElementById('edit_name');
        const editDesc = document.getElementById('edit_description');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const desc = this.getAttribute('data-description');

                editForm.action = `/admin/categories/${id}`;
                editName.value = name;
                editDesc.value = desc || '';

                editModal.show();
            });
        });

        // Delete Category Modal Handler
        const deleteCategoryModal = document.getElementById('deleteCategoryModal');
        if (deleteCategoryModal) {
            deleteCategoryModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const catId = button.getAttribute('data-id');
                const catName = button.getAttribute('data-name');

                document.getElementById('deleteModalCategoryName').textContent = `"${catName}"`;
                document.getElementById('deleteCategoryForm').action = `/admin/categories/${catId}`;
            });
        }
    });
</script>
@endpush
@endsection
