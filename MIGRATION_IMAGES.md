# Migration Images to Storage

## Langkah-langkah Perbaikan Upload File

### 1. Masalah yang Diperbaiki
Sebelumnya, aplikasi mengupload file gambar langsung ke folder `public/images/` yang:
- Kurang aman
- Tidak terorganisir dengan baik
- Sulit untuk dikelola
- Tidak mengikuti best practice Laravel

### 2. Solusi yang Diimplementasikan
File gambar sekarang diupload ke Laravel storage (`storage/app/public/`) dengan:
- **Organisasi yang lebih baik**: File disimpan dalam folder berdasarkan kategori dan tanggal
- **Keamanan yang lebih baik**: Menggunakan Laravel storage filesystem
- **Naming convention yang konsisten**: Prefix kategori + timestamp + random string
- **Validasi file yang lebih ketat**: Melalui service class

### 3. Perubahan Structure File
```
storage/app/public/
├── gallery/2025/01/
├── equipment/2025/01/  
├── articles/2025/01/
├── staff/2025/01/
└── testing-results/2025/01/
```

### 4. Service Class yang Ditambahkan
**FileUploadService** dengan method:
- `uploadGalleryImage()` - Upload gambar galeri
- `uploadEquipmentImage()` - Upload gambar equipment  
- `uploadArticleImage()` - Upload gambar artikel
- `uploadStaffImage()` - Upload gambar staff
- `deleteFile()` - Hapus file dengan aman
- `getFileUrl()` - Mendapatkan URL file

### 5. Controller yang Diperbaiki
- **GaleriLaboratoriumController**
- **EquipmentController**  
- **ArticleController**
- **StaffController**

### 6. View yang Diperbaiki
Semua view sekarang menggunakan `url('storage/' . $path)` instead of `asset($path)`

### 7. Migration Command
Untuk memindahkan file lama dari public ke storage:

```bash
php artisan migrate:images-to-storage
```

### 8. Symbolic Link
Pastikan symbolic link storage sudah dibuat:

```bash
php artisan storage:link
```

### 9. Testing
Setelah migration:
1. Test upload gambar baru di semua fitur
2. Verifikasi gambar lama masih tampil dengan benar
3. Test delete gambar
4. Test edit gambar

### 10. Backup
Disarankan untuk backup folder `public/images/` sebelum menjalankan migration:

```bash
# Backup folder images
cp -r public/images/ backup_images/
```

## Keuntungan Setelah Migration

1. **Security**: File tidak langsung accessible via URL
2. **Organization**: File tersimpan dengan struktur yang rapi
3. **Best Practice**: Mengikuti Laravel storage best practice
4. **Maintenance**: Lebih mudah untuk manage file
5. **Scalability**: Mudah untuk pindah ke cloud storage di masa depan

## Troubleshooting

### Jika Symbolic Link Belum Ada
```bash
php artisan storage:link
```

### Jika Permission Error
```bash
chmod -R 755 storage/
chmod -R 755 public/storage/
```

### Jika Gambar Tidak Muncul
1. Cek apakah symbolic link ada: `ls -la public/storage`
2. Cek permission storage folder
3. Cek APP_URL di .env file
4. Cek path di database apakah sudah updated

## Notes
- File lama akan dipindahkan dan dihapus dari public/images/
- Database akan diupdate dengan path yang baru  
- Backup selalu disarankan sebelum migration
