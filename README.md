# 🎬 FilmKu — Sistem Informasi Review dan Rating Film

> Tugas Akhir berbasis web menggunakan **Laravel 11** dan **MySQL**

---

## 📋 Fitur

### 👤 Admin
- Login khusus admin
- Dashboard statistik (total film, genre, user, review)
- CRUD Film (dengan upload poster)
- CRUD Genre
- Kelola User (ubah role, hapus)
- Hapus review tidak pantas

### 🙋 User *(coming soon)*
- Register / Login
- Lihat & cari film
- Filter berdasarkan genre
- Rating bintang & review film
- Watchlist film favorit
- Edit profil

---

## 🛠️ Teknologi

| Stack | Versi |
|-------|-------|
| PHP | 8.3 |
| Laravel | 11.x |
| MySQL | 8.x |
| Laragon | (rekomendasi) |

---

## 🚀 Cara Setup Project (Setelah Clone)

### 1. Clone repository
```bash
git clone <link-repo-github>
cd projectpwf
```

### 2. Install dependencies PHP
```bash
composer install
```

### 3. Buat file `.env`
```bash
cp .env.example .env
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Konfigurasi database

Buka file `.env` dan sesuaikan:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projectpwf
DB_USERNAME=root
DB_PASSWORD=
```

> Pastikan database **`projectpwf`** sudah dibuat di phpMyAdmin terlebih dahulu.

### 6. Jalankan migrasi & seeder
```bash
php artisan migrate --seed
```

Perintah ini akan:
- Membuat semua tabel database
- Membuat akun admin default secara otomatis

### 7. Buat storage link (untuk poster film)
```bash
php artisan storage:link
```

### 8. Jalankan server
```bash
php artisan serve
```

Buka browser → [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔐 Akun Admin Default

| Field | Value |
|-------|-------|
| Email | `admin@filmku.com` |
| Password | `password` |

> **Penting:** Segera ganti password setelah pertama kali login!

URL Admin: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

---

## 📁 Struktur Database

| Tabel | Keterangan |
|-------|------------|
| `users` | Data user & admin |
| `films` | Data film |
| `genres` | Kategori genre |
| `film_genre` | Relasi many-to-many film & genre |
| `reviews` | Review & rating dari user |
| `watchlists` | Daftar film favorit user |

---

## ⚠️ Catatan untuk Pengguna Laragon

Jika perintah `php` tidak dikenali di terminal, gunakan path lengkap:

```powershell
& "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" artisan serve
```

Atau aktifkan PHP di PATH: **Laragon → klik kanan → PHP → Add to PATH** lalu restart terminal.

---

## 👥 Kelompok 7

> Tugas Akhir Mata Kuliah Pemrograman Web Framework
