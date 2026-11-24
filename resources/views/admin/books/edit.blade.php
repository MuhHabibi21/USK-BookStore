@extends('layouts.admin')

@section('title', 'Edit Data Buku - BookStore')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Buku
    </a>
    <h3 class="fw-bold mb-0">Edit Data Buku</h3>
    <p class="text-muted small mb-0">Perbarui informasi buku "{{ $book->title }}"</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label for="title" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                    @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="category_id" class="form-label fw-semibold">Kategori Buku <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <label for="author" class="form-label fw-semibold">Nama Penulis / Pengarang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                    @error('author')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="publisher" class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}" required>
                    @error('publisher')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="year" class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', $book->year) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                    @error('year')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label fw-semibold">Harga Buku (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', (int)$book->price) }}" min="0" step="500" required>
                    </div>
                    @error('price')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="stock" class="form-label fw-semibold">Jumlah Stok Tersedia <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $book->stock) }}" min="0" required>
                    @error('stock')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="cover_image" class="form-label fw-semibold">Ganti Gambar Sampul (Opsional)</label>
                    @if($book->cover_image)
                        <div class="mb-3 p-3 bg-light rounded border d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="rounded border shadow-sm" style="width: 70px; height: 95px; object-fit: cover;">
                                <div>
                                    <span class="fw-semibold text-dark d-block">Gambar Sampul Saat Ini</span>
                                    <small class="text-muted">Tersimpan di sistem</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCoverModal">
                                <i class="bi bi-trash me-1"></i> Hapus Gambar Sampul
                            </button>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
                    <small class="text-muted">Mendukung semua format gambar: JPG, JPEG, PNG, WEBP, GIF, SVG, BMP (Maksimal 5 MB). Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    @error('cover_image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Sinopsis / Deskripsi Buku</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 text-end border-top pt-3 mt-3">
                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-warning px-4 fw-semibold">
                        <i class="bi bi-pencil-square me-1"></i> Perbarui Buku
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@if($book->cover_image)
<!-- Modal Konfirmasi Hapus Gambar Sampul -->
<div class="modal fade" id="deleteCoverModal" tabindex="-1" aria-labelledby="deleteCoverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-danger" id="deleteCoverModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus Gambar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body py-3">
                <p class="mb-2">Apakah Anda yakin ingin menghapus gambar cover dari buku <strong>"{{ $book->title }}"</strong>?</p>
                <small class="text-muted">File gambar akan dihapus dari penyimpanan dan cover buku akan kembali ke tampilan default.</small>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.books.deleteCover', $book->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold">
                        <i class="bi bi-trash me-1"></i> Ya, Hapus Gambar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
