<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Tampilkan Semua Kategori
     */
    public function index()
    {
        // =========================================================================
        // # JIKA INGIN MENGUBAH JUMLAH KATEGORI PER HALAMAN (PAGINATION KATEGORI ADMIN):
        // Ubah angka di paginate(10) di bawah ini jika penguji minta jumlah per halaman beda.
        // =========================================================================
        $categories = Category::withCount('books')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Simpan Kategori Baru
     */
    public function store(Request $request)
    {
        // =========================================================================
        // # JIKA INGIN MENGUBAH ATURAN MIN/MAX KARAKTER KATEGORI (CREATE):
        // - 'name' => 'min:10|max:20' -> Ubah angka 10 (minimal) & 20 (maksimal) panjang judul.
        // - 'description' => 'min:50|max:100' -> Ubah angka 50 (minimal) & 100 (maksimal) panjang deskripsi.
        // Jangan lupa ubah juga angka di teks pesan error di bawahnya agar sesuai.
        // =========================================================================
        $validated = $request->validate([
            'name' => 'required|string|min:10|max:20|unique:categories,name',
            'description' => 'required|string|min:50|max:100',
        ], [
            'name.required' => 'Judul / nama kategori wajib diisi.',
            'name.min' => 'Judul kategori minimal 10 karakter.',
            'name.max' => 'Judul kategori maksimal 20 karakter.',
            'name.unique' => 'Nama kategori sudah terdaftar dalam sistem.',
            'description.required' => 'Deskripsi kategori wajib diisi.',
            'description.min' => 'Deskripsi kategori minimal 50 karakter.',
            'description.max' => 'Deskripsi kategori maksimal 100 karakter.',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Update Data Kategori
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // =========================================================================
        // # JIKA INGIN MENGUBAH ATURAN MIN/MAX KARAKTER KATEGORI (EDIT/UPDATE):
        // - 'name' => 'min:10|max:20' -> Ubah angka 10 (minimal) & 20 (maksimal) panjang judul.
        // - 'description' => 'min:50|max:100' -> Ubah angka 50 (minimal) & 100 (maksimal) panjang deskripsi.
        // Jangan lupa ubah juga angka di teks pesan error di bawahnya agar sesuai.
        // =========================================================================
        $validated = $request->validate([
            'name' => 'required|string|min:10|max:20|unique:categories,name,' . $category->id,
            'description' => 'required|string|min:50|max:100',
        ], [
            'name.required' => 'Judul / nama kategori wajib diisi.',
            'name.min' => 'Judul kategori minimal 10 karakter.',
            'name.max' => 'Judul kategori maksimal 20 karakter.',
            'name.unique' => 'Nama kategori sudah terdaftar dalam sistem.',
            'description.required' => 'Deskripsi kategori wajib diisi.',
            'description.min' => 'Deskripsi kategori minimal 50 karakter.',
            'description.max' => 'Deskripsi kategori maksimal 100 karakter.',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus Kategori
     */
    public function destroy($id)
    {
        $category = Category::withCount('books')->findOrFail($id);

        if ($category->books_count > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', "Kategori \"{$category->name}\" tidak dapat dihapus karena masih memuat {$category->books_count} buku. Pindahkan atau hapus bukunya terlebih dahulu agar buku tidak ikut terhapus.");
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
