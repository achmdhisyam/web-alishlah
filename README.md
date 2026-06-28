# 🏫 Website Profil & Manajemen Sekolah (Web Al-Ishlah)

[![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter%204-orange?style=for-the-badge&logo=codeigniter)](https://codeigniter.com)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue?style=for-the-badge&logo=php)](https://www.php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple?style=for-the-badge&logo=bootstrap)](https://getbootstrap.com)
[![AdminLTE](https://img.shields.io/badge/Admin-AdminLTE%203-red?style=for-the-badge)](https://adminlte.io)
[![Laragon](https://img.shields.io/badge/Environment-Laragon-cyan?style=for-the-badge&logo=laravel)](https://laragon.org)

Website Profil dan Manajemen Sekolah resmi **Al-Ishlah** yang dikembangkan menggunakan framework **CodeIgniter 4**. Aplikasi ini dirancang untuk memudahkan manajemen informasi sekolah, publikasi berita, profil guru/staff, pendaftaran siswa baru (PPDB), serta interaksi antara pihak sekolah, siswa, dan masyarakat umum.

---

## ✨ Fitur Utama

### 🌐 Halaman Front-End (Publik)
*   **Beranda (Homepage):** Banner dinamis, sambutan kepala sekolah, berita terbaru, dan statistik sekolah.
*   **Profil Sekolah:** Sejarah yayasan, visi & misi, fasilitas, sarana & prasarana, serta ekstrakurikuler.
*   **Direktori Staff & Guru:** Daftar tenaga pendidik beserta jabatan dan profil singkat.
*   **Informasi & Pengumuman:** Artikel berita, agenda kegiatan sekolah, dan prestasi akademik/non-akademik.
*   **Galeri Media:** Galeri foto kegiatan sekolah dan video dokumentasi (YouTube integration).
*   **Unduhan (Downloads):** File formulir, dokumen penting, atau materi ajar yang dapat diunduh publik.
*   **Portal Pendaftaran (SPMB):** Registrasi akun, pengisian biodata wizard 4-tahap, sistem unggah dokumen (multi-upload), integrasi OneSignal push notification, dan dasbor status kelulusan siswa.
*   **Kontak & Integrasi WA:** Informasi alamat, form kontak, WhatsApp floating widget, dan tombol hubungi panitia saat gelombang tutup.

### 🔐 Halaman Back-End (Administrator & Operator)
*   **Dashboard Analytics:** Statistik pendaftar siswa baru (Total, Menunggu, Diterima, Ditolak), total berita, galeri, dan aktivitas sistem.
*   **Manajemen Konten (CMS):** Kelola berita, kategori berita, event/agenda, galeri foto, dan video.
*   **Manajemen Akademik:** Kelola data guru/staff, rombongan belajar (rombel), kelas, tahun ajaran, dan ekstrakurikuler.
*   **Sistem SPMB Online:** Verifikasi pendaftar baru (preview dokumen inline), manajemen berkas persyaratan, ekspor PDF/Excel data pendaftar, dan template impor Excel 30 kolom.
*   **Manajemen Pengguna:** Pengaturan akun admin, operator, serta hak akses.
*   **Konfigurasi Sistem:** Pengaturan profil sekolah, logo & favicon, info kontak, SMTP email, dan menu navigasi.

---

## 🛠️ Spesifikasi Teknis

*   **Framework Utama:** CodeIgniter `v4.x`
*   **Admin Template:** AdminLTE `v3.2.0`
*   **Front-End Template:** Sandbox - Modern & Multipurpose Bootstrap 5 Template `v3.4.0`
*   **Notifikasi:** SweetAlert2 & Toastr
*   **Data Grid:** DataTables (dengan fitur ekspor PDF/Excel)
*   **PDF Generator:** mPDF

---

## 🚀 Panduan Instalasi Lokal (Laragon)

Ikuti langkah-langkah di bawah ini untuk menjalankan project di komputer lokal menggunakan **Laragon**:

### 1. Prasyarat Sistem
Pastikan komputer Anda sudah terinstal:
*   [Laragon Full](https://laragon.org/download/) (Direkomendasikan menggunakan PHP 8.1 atau PHP 8.2)
*   [Composer](https://getcomposer.org/)

### 2. Kloning Project
Letakkan folder project ini di dalam direktori root Laragon (`C:\laragon\www\`).
```bash
C:\laragon\www\project
```

### 3. Instalasi Dependensi
Buka terminal (bisa melalui terminal Laragon) di direktori project, lalu jalankan perintah berikut untuk mengunduh package composer yang dibutuhkan:
```bash
composer install
```

### 4. Konfigurasi Environment (`.env`)
Salin file konfigurasi environment dari template default `env` ke `.env`:
```bash
copy env .env
```
Buka file `.env` yang baru dibuat dan sesuaikan konfigurasi database Anda:
```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = nama_database
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 5. Konfigurasi Database
1. Buka phpMyAdmin atau aplikasi database manager pilihan Anda (HeidiSQL, DBeaver, dll.).
2. Buat database baru bernama `web_sekolah`.
3. Import file database utama (jika disediakan file `.sql` di folder backup/db).

### 6. Menjalankan Aplikasi
Aplikasi dapat diakses dengan cara:
*   **Melalui Virtual Host Laragon:** Klik **Start All** pada Laragon. 
*   **Melalui Spark CLI:** Jalankan perintah berikut di terminal project:
    ```bash
    php spark serve
    ```
    Lalu buka browser di alamat [http://localhost:8080](http://localhost:8080).

---


## 📁 Struktur Direktori Penting

*   [`app/Controllers/`](file:///c:/laragon/www/websitesekolah-main/app/Controllers) - Logika kontroler utama aplikasi.
*   [`app/Models/`](file:///c:/laragon/www/websitesekolah-main/app/Models) - Logika interaksi database.
*   [`app/Views/`](file:///c:/laragon/www/websitesekolah-main/app/Views) - Template tampilan web (Front-End & Back-End).
*   [`public/`](file:///c:/laragon/www/websitesekolah-main/public) - Aset publik (CSS, JS, Gambar) dan entry point utama `index.php`.
*   [`assets/`](file:///c:/laragon/www/websitesekolah-main/assets) - Kumpulan plugin, vendor, dan aset asset-management.

---

## 🔄 Pembaruan Terbaru (Changelog)

*   **Pembersihan Berkas & Data Sentral (Cascading Delete - OOP/MVC):** Penerapan method `deleteSiswaCascading()` di `Siswa_model` untuk menghapus secara aman berkas pasfoto fisik (`assets/upload/image/`), berkas dokumen persyaratan (`assets/upload/pendaftaran/`), serta data relasi tabel database (`dokumen`, `siswa_rombel`, `siswa_logs`) secara otomatis saat pendaftar dihapus.
*   **Redesain Bar Pintasan SPMB Beranda:** Bar horizontal ramping bertema hijau sekolah di bawah banner utama dengan tombol aksi dinamis (Daftar & Portal/Dasbor Siswa) berbasis status login siswa.
*   **Perbaikan Pengunduhan Template Impor Excel:** Penambahan modul pembuat spreadsheet Excel dinamis 30 kolom (`template-siswa.xlsx`) menggunakan library `PhpSpreadsheet` di menu admin.
*   **Proteksi Halaman Gelombang Pendaftaran:** Penanganan halaman kosong (*empty state*) pendaftaran siswa dengan Alert Warning interaktif dan WhatsApp floating widget jika tidak ada gelombang pendaftaran aktif.
*   **Peningkatan Keamanan Pendaftaran:** Menghapus field status pendaftaran disabled dari form biodata siswa dan mengenkripsi kata sandi pendaftar baru menggunakan `PASSWORD_DEFAULT`.
*   **Visual Risiko Admin:** Mengubah warna tombol aksi hapus siswa menjadi merah (`btn-danger`) di data master siswa admin.



