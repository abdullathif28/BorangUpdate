# 📋 Panduan Instalasi BorangDigital IPM

## Sistem Role

| Role | Login | Akses |
|------|-------|-------|
| **Superadmin** | Email + Password | Semua fitur, kelola admin & pelatihan |
| **Admin** | Email + Password | Kelola pelatihan daerah sendiri, peserta, borang |
| **IOT** | Token 8 karakter | Hanya Imamah & Kajian |
| **MOG** | Token 8 karakter | Hanya Games / Outbound |
| **Observer** | Token 8 karakter | Hanya Observasi Materi & Pendalaman |

## Langkah Instalasi

### 1. Copy & Setup Project
```bash
# Copy ke folder project Anda (misal: htdocs atau www)
cp -r BorangDigital /path/to/server/

cd BorangDigital

# Install dependencies
composer install
npm install && npm run build
```

### 2. Konfigurasi .env
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```
DB_DATABASE=borangdigital
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 3. Jalankan Migrasi
```bash
php artisan migrate
php artisan db:seed
```

> **PENTING:** Urutan migrasi sudah diatur. Migrasi baru ada di:
> - `2026_01_01_000001_enhance_users_table.php` → tambah kolom role, token, dll
> - `2026_01_01_000002_enhance_pelatihan_table.php` → tambah admin_id, status

### 4. Akun Default Superadmin
Setelah seeder berjalan:
- **Email:** `superadmin@borangdigital.id`
- **Password:** `superadmin123`
- ⚠️ Ganti password setelah login pertama!

---

## Alur Penggunaan

### A. Superadmin
1. Login dengan email+password
2. Masuk ke panel Superadmin
3. **Setujui pendaftaran Admin** dari daerah/wilayah
4. **Aktifkan pelatihan** yang dibuat admin (status: pending → aktif)
5. Bisa tutup/buka kembali pelatihan kapan saja

### B. Admin Daerah
1. Daftar di halaman `/register` dengan data pimpinan
2. Tunggu persetujuan Superadmin
3. Setelah disetujui, bisa login dan:
   - Buat pelatihan (status otomatis: pending)
   - Tambah peserta
   - Buat akun IOT/MOG/Observer (token auto-generate)
   - Input semua borang
   - Cetak syahadah & raport

### C. IOT / MOG / Observer
1. Login di halaman `/login` → tab **"Login Token"**
2. Masukkan token 8 karakter dari Admin
3. Akses menu sesuai role masing-masing

---

## Catatan Penting

- **Setiap Admin independen** — data tidak bercampur antar daerah
- **Token permanen** sampai Admin melakukan reset manual
- **Borang hanya bisa diisi** saat pelatihan berstatus **Aktif**
- **Syahadah** bisa dicetak dari halaman Data Peserta (tombol "Syahadah")

