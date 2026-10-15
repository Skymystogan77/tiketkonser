# 🎫 Ticket Box System - Pra-Ujian Internal JWP (Klaster Web Programming)

Aplikasi web pemesanan tiket konser berbasis Laravel dengan arsitektur MVC, integrasi database relasional, transaksi database multi-tabel (`DB::beginTransaction`), dan panel administrasi.

---

## 📋 Fitur Utama Aplikasi

- **Katalog Publik**: Menampilkan daftar konser/event aktif dengan fitur filter berdasarkan kategori (Musik, Festival, Seminar).
- **Checkout & Transaksi Multi-Tabel**: Pemesanan tiket menggunakan `DB::beginTransaction()`, commit & rollback otomatis pada tabel `orders` dan `order_details`.
- **Manajemen Event (Admin)**: CRUD data event lengkap dengan unggah poster ke `storage/app/public`.
- **Rekap Pesanan (Admin)**: Melihat seluruh transaksi pesanan masuk dan mengubah status pembayaran (*Pending*, *Confirmed*, *Cancelled*).
- **Keamanan**: Proteksi CSRF (`@csrf`), server-side validation `$request->validate()`, dan autentikasi Breeze.

---

## 🚀 Panduan Instalasi & Menjalankan Project (Langkah Demi Langkah)

Ikuti langkah-langkah berikut secara berurutan untuk menjalankan project ini di komputer lokal (Windows / Linux / macOS):

### 1. Clone Repository
Buka Terminal / Command Prompt / Git Bash, lalu jalankan:
```bash
git clone https://github.com/Skymystogan77/tiketkonser.git
cd tiketkonser
```

### 2. Install Dependensi PHP & Frontend
Jalankan Composer untuk mengunduh package PHP Laravel:
```bash
composer install
```
Jalankan NPM untuk mengunduh asset JavaScript & styling Tailwind/Bootstrap:
```bash
npm install
npm run build
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
- **Windows (Command Prompt / PowerShell)**:
  ```bash
  copy .env.example .env
  ```
- **Linux / Git Bash / macOS**:
  ```bash
  cp .env.example .env
  ```

Buka file `.env` dan pastikan konfigurasi database sudah sesuai dengan MySQL Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_tiket_konser
DB_USERNAME=root
DB_PASSWORD=
```
> *(Catatan: Buat database baru bernama `db_tiket_konser` di phpMyAdmin / MySQL terlebih dahulu jika belum ada)*.

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Hubungkan Storage Link (Wajib untuk Poster Event)
Agar gambar poster event yang diunggah ke `storage/app/public` dapat diakses langsung oleh browser:
```bash
php artisan storage:link
```

### 6. Jalankan Migrasi & Seeder Database
Perintah ini akan membuat semua struktur tabel (`users`, `events`, `orders`, `order_details`) dan mengisi 5 data awal konser serta akun login admin:
```bash
php artisan migrate:fresh --seed
```

### 7. Jalankan Server Lokal
Nyalakan server development Laravel:
```bash
php artisan serve
```
Akses aplikasi melalui browser:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔑 Akun Login Penguji (Reviewer / Guru)

Penguji atau guru dapat masuk ke panel dashboard dan manajemen admin menggunakan akun berikut:

| Akses | Kredensial |
| :--- | :--- |
| **URL Login** | [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login) |
| **Email** | `admin@admin.com` |
| **Password** | `Password123` |

---

## 📁 Struktur MVC & File Penting

- **Model**:
  - `app/Models/Event.php` (Data konser/acara)
  - `app/Models/Order.php` (Header data pesanan pembeli)
  - `app/Models/OrderDetail.php` (Detail kuantitas tiket & subtotal per pesanan)
- **Controller**:
  - `app/Http/Controllers/EventController.php` (Katalog publik, filter kategori, CRUD master event & upload storage)
  - `app/Http/Controllers/OrderController.php` (Logika transaksi `DB::beginTransaction()`, simpan multi-tabel, rekap transaksi admin)
- **Routes**:
  - `routes/web.php` (Pemisahan route publik dan route admin dengan middleware `auth`)
