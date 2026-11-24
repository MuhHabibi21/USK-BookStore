# 📚 Toko Buku Online (BookStore) - Uji Sertifikasi Kompetensi (USK)

Aplikasi web Toko Buku Online modern, responsif, dan lengkap yang dibangun menggunakan framework **Laravel** dan **Bootstrap 5**, dirancang khusus untuk memenuhi seluruh butir penilaian dan rubrik **Uji Sertifikasi Kompetensi (USK) Skema Web Developer**.

---

## 🚀 Fitur Utama Sistem

### 👤 Pengguna (User / Customer)
- **Katalog Buku & Pagination**: Menampilkan daftar koleksi buku secara terstruktur per 6 buku per halaman.
- **Pencarian & Filter**: Pencarian berdasarkan judul buku, penulis, penerbit, serta filter kategori dan rentang harga.
- **Keranjang Belanja Interaktif**: 
  - Stepper penambahan dan pengurangan kuantitas yang aman (anti-input huruf).
  - Checkbox pilihan buku (Pilih Semua & per item).
  - Kalkulasi subtotal & total tagihan otomatis secara real-time.
- **Checkout & Pembayaran**: Formulir pemesanan lengkap mendukung metode pembayaran COD (Cash on Delivery) dan Transfer.
- **Riwayat Pesanan**: Melihat status pemesanan buku secara berkala.
- **Hubungi Kami (Kontak)**: Kirim pesan langsung ke administrator.

### 🛡️ Administrator (Admin)
- **Dashboard Statistik**: Ringkasan data pesanan, jumlah buku, dan pengguna.
- **Kelola Kategori**: CRUD kategori buku dengan validasi judul (10-20 karakter) dan deskripsi (50-100 karakter).
- **Kelola Buku**: Tambah, edit, dan hapus katalog buku lengkap dengan upload sampul dan proteksi transaksi aktif.
- **Kelola Pesanan**: Pemantauan pesanan pelanggan, verifikasi status pembayaran, dan pengiriman.
- **Manajemen Pengguna**: Pemantauan data pengguna terdaftar.
- **Kotak Pesan Masuk**: Menjawab aspirasi atau pertanyaan dari pelanggan.

---

## 🎨 Desain Antarmuka (Figma vs Realisasi Web)

Berikut adalah perbandingan hasil rancangan UI/UX pada **Figma** dan hasil implementasi fungsional pada **Aplikasi Web**:

### 1. Antarmuka Sisi Pengguna (User / Customer)

| Halaman | Desain Figma | Realisasi Web |
| :--- | :---: | :---: |
| **Registrasi Akun** | ![Figma Regist](screenshots/FIGMA/USER/User%20-%20Regist.png) | ![Web Regist](screenshots/WEB/USER/User%20-%20Regist.png) |
| **Login Akun** | ![Figma Login](screenshots/FIGMA/USER/User%20-%20Login.png) | ![Web Login](screenshots/WEB/USER/User%20-%20Login.png) |
| **Katalog & Pencarian** | ![Figma Pencarian](screenshots/FIGMA/USER/User%20-%20Pencarian.png) | ![Web Pencarian](screenshots/WEB/USER/User%20-%20Pencarian.png) |
| **Keranjang Belanja** | ![Figma Cart](screenshots/FIGMA/USER/User%20-%20Cart.png) | ![Web Cart](screenshots/WEB/USER/User%20-%20Cart.png) |
| **Pembayaran / Checkout** | ![Figma Payment](screenshots/FIGMA/USER/User%20-%20Payment.png) | ![Web Payment](screenshots/WEB/USER/User%20-%20Payment.png) |
| **Kontak Admin** | ![Figma Kontak](screenshots/FIGMA/USER/User%20-%20Kontak%20Admin.png) | ![Web Kontak](screenshots/WEB/USER/User%20-%20Kontak%20Admin.png) |
| **Tentang Kami (About Us)** | ![Figma About](screenshots/FIGMA/USER/User%20-%20About%20US.png) | ![Web About](screenshots/WEB/USER/User%20-%20About%20US.png) |

---

### 2. Antarmuka Sisi Administrator (Admin)

| Modul Admin | Desain Figma | Realisasi Web |
| :--- | :---: | :---: |
| **Tambah Buku** | ![Figma Add Buku](screenshots/FIGMA/ADMIN/Admin%20-%20Add%20Buku.png) | ![Web Tambah Buku](screenshots/WEB/ADMIN/Admin%20-%20Tambah%20Buku.png) |
| **Update / Edit Buku** | ![Figma Update Buku](screenshots/FIGMA/ADMIN/Admin%20-%20Update%20Buku.png) | ![Web Edit Buku](screenshots/WEB/ADMIN/Admin%20-%20Edit%20Buku.png) |
| **Hapus Buku (Proteksi)** | ![Figma Delete Buku](screenshots/FIGMA/ADMIN/Admin%20-%20Delete%20Buku.png) | ![Web Delete Buku](screenshots/WEB/ADMIN/Admin%20-%20Delete%20Buku.png) |
| **Tambah Kategori** | ![Figma Add Kategori](screenshots/FIGMA/ADMIN/Admin%20-%20Add%20Kategori.png) | ![Web Tambah Kategori](screenshots/WEB/ADMIN/Admin%20-%20Tambah%20Kategori.png) |
| **Update Kategori** | ![Figma Update Kategori](screenshots/FIGMA/ADMIN/Admin%20-%20Update%20Kategori.png) | ![Web Edit Kategori](screenshots/WEB/ADMIN/Admin%20-%20Edit%20Kategori.png) |
| **Hapus Kategori** | ![Figma Delete Kategori](screenshots/FIGMA/ADMIN/Admin%20-%20Delete%20Kategori.png) | ![Web Delete Kategori](screenshots/WEB/ADMIN/Admin%20-%20Delete.png) |
| **Daftar Pesanan Masuk** | ![Figma List Pesanan](screenshots/FIGMA/ADMIN/Admin%20-%20List%20Pesanan%20.png) | ![Web List Pesanan](screenshots/WEB/ADMIN/Admin%20-%20List%20Pesanan.png) |
| **Daftar Pengguna** | ![Figma List User](screenshots/FIGMA/ADMIN/Admin%20-%20List%20User.png) | ![Web List User](screenshots/WEB/ADMIN/Admin%20-%20List%20User.png) |

---

## 🛠️ Panduan Instalasi & Menjalankan Projek

1. **Clone Repository**:
   ```bash
   git clone https://github.com/MuhHabibi21/USK-BookStore.git
   cd USK-BookStore
   ```

2. **Install Dependensi PHP**:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**:
   Salin `.env.example` menjadi `.env` lalu sesuaikan database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_bookstore
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key & Migrasi Database**:
   ```bash
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Akses aplikasi pada peramban: `http://127.0.0.1:8000`

---
*Dibuat untuk pelaksanaan Uji Sertifikasi Kompetensi (USK) Rekayasa Perangkat Lunak / Web Developer.*
