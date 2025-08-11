# Fitur Manajemen Admin

## Deskripsi
Sistem manajemen admin telah ditambahkan dengan dua level akses:
1. **Super Admin** - Memiliki akses penuh untuk mengelola admin lain
2. **Regular Admin** - Memiliki akses ke fitur admin biasa, namun tidak dapat mengelola admin lain

## Akun Default yang Tersedia

### Super Admin
- **Email**: `superadmin@fisika.com`
- **Password**: `superadmin123`
- **Hak Akses**: 
  - Semua fitur admin
  - Mengelola admin lain (tambah, edit, hapus)
  - Membuat admin baru (regular admin atau super admin)

### Regular Admin
- **Email**: `admin@fisika.com`
- **Password**: `admin123`
- **Hak Akses**: 
  - Semua fitur admin kecuali manajemen admin

## Fitur yang Ditambahkan

### 1. Model & Database
- Menambahkan field `is_super_admin` ke tabel `users`
- Method baru di User model:
  - `isSuperAdmin()` - Cek apakah user adalah super admin
  - `canManageAdmins()` - Cek apakah user dapat mengelola admin

### 2. Middleware
- **SuperAdminMiddleware** - Middleware khusus untuk mengautorisasi super admin
- Terdaftar sebagai `super_admin` di `bootstrap/app.php`

### 3. Controller
- **AdminManagementController** - Controller untuk CRUD admin
- Fitur:
  - List semua admin
  - Tambah admin baru
  - Edit admin existing
  - Hapus admin
  - View detail admin

### 4. Routes
- Semua routes admin management dilindungi middleware `super_admin`
- Path: `/admin/admin-management/*`
- Route names: `admin.admin-management.*`

### 5. Views
- `admin/admin-management/index.blade.php` - Daftar admin
- `admin/admin-management/create.blade.php` - Form tambah admin
- `admin/admin-management/edit.blade.php` - Form edit admin
- `admin/admin-management/show.blade.php` - Detail admin

### 6. Security Features
- Tidak dapat menghapus super admin terakhir
- Tidak dapat menghapus akun sendiri
- Validasi email unique saat create/update
- Password confirmation required

## Cara Menggunakan

1. **Login sebagai Super Admin**
   - Gunakan kredensial super admin di atas
   - Menu "Manajemen Admin" akan muncul di sidebar

2. **Menambah Admin Baru**
   - Klik "Manajemen Admin" → "Tambah Admin"
   - Isi form data admin
   - Centang "Super Admin" jika ingin membuat super admin

3. **Mengelola Admin Existing**
   - View, edit, atau hapus admin melalui tombol aksi
   - Ada proteksi untuk super admin terakhir

## Struktur Permission

```
Super Admin:
├── Semua fitur Admin biasa
├── Manajemen Admin
│   ├── View semua admin
│   ├── Tambah admin baru
│   ├── Edit admin (kecuali super admin terakhir)
│   └── Hapus admin (kecuali diri sendiri & super admin terakhir)

Regular Admin:
├── Dashboard
├── Kelola Web (Profil, Artikel, Galeri, Staff)
├── Alat & Peralatan
├── Peminjaman Alat
├── Kunjungan
├── Jadwal
├── Pengujian
└── Jenis Pengujian
```

## File yang Dimodifikasi

1. **Models**
   - `app/Models/User.php` - Tambah field & method super admin

2. **Controllers**
   - `app/Http/Controllers/Admin/AdminManagementController.php` - Controller baru

3. **Middleware**
   - `app/Http/Middleware/SuperAdminMiddleware.php` - Middleware baru

4. **Database**
   - Migration: `add_is_super_admin_to_users_table.php`
   - Seeder: `AdminSeeder.php` - Update untuk super admin

5. **Routes**
   - `routes/web.php` - Tambah routes admin management

6. **Views**
   - `resources/views/admin/admin-management/*` - Views baru
   - `resources/views/admin/layouts/app.blade.php` - Update sidebar

7. **Config**
   - `bootstrap/app.php` - Register middleware

## Keamanan
- Sistem mencegah penghapusan super admin terakhir
- Validasi yang ketat untuk operasi CRUD
- Middleware protection untuk semua routes manajemen admin
- Password hashing otomatis
