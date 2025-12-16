<?php

/**
 * Script untuk membuat symbolic link storage
 * Jalankan dari browser: https://material-phylab.fmipa.usk.ac.id/create-symlink.php
 * HAPUS FILE INI setelah selesai!
 */

$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

echo "<pre>";
echo "===========================================\n";
echo "SYMBOLIC LINK CREATOR\n";
echo "===========================================\n\n";

// Cek apakah target folder ada
if (!is_dir($target)) {
    echo "❌ ERROR: Target folder tidak ada!\n";
    echo "   Path: $target\n";
    exit;
}

echo "✅ Target folder ditemukan: $target\n\n";

// Hapus link lama jika ada
if (file_exists($link)) {
    if (is_link($link)) {
        echo "⚠️  Symbolic link sudah ada, menghapus link lama...\n";
        unlink($link);
        echo "✅ Link lama berhasil dihapus\n\n";
    } else {
        echo "❌ ERROR: '$link' sudah ada tapi bukan symbolic link!\n";
        echo "   Hapus manual folder/file ini terlebih dahulu.\n";
        exit;
    }
}

// Buat symbolic link
if (symlink($target, $link)) {
    echo "✅ BERHASIL!\n";
    echo "   Symbolic link dibuat dari:\n";
    echo "   $link\n";
    echo "   → menuju →\n";
    echo "   $target\n\n";
    
    // Test link
    if (is_link($link) && readlink($link) === $target) {
        echo "✅ Link terverifikasi dan berfungsi!\n\n";
        
        // Cek permission
        $perms = substr(sprintf('%o', fileperms($target)), -4);
        echo "📁 Permission target folder: $perms\n";
        
        if ($perms < 755) {
            echo "⚠️  WARNING: Permission terlalu ketat!\n";
            echo "   Jalankan: chmod -R 775 storage/app/public\n";
        }
    } else {
        echo "⚠️  WARNING: Link dibuat tapi tidak bisa diverifikasi\n";
    }
    
    echo "\n===========================================\n";
    echo "TEST AKSES:\n";
    echo "===========================================\n";
    
    // Cari file contoh
    $testFiles = glob($target . '/*/*.jpg');
    if (!empty($testFiles)) {
        $testFile = str_replace($target . '/', '', $testFiles[0]);
        $testUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/storage/' . $testFile;
        echo "Test URL: <a href='$testUrl' target='_blank'>$testUrl</a>\n";
    } else {
        echo "Belum ada file gambar untuk di-test.\n";
        echo "Upload foto dari admin panel terlebih dahulu.\n";
    }
    
    echo "\n===========================================\n";
    echo "⚠️  PENTING: HAPUS FILE INI SETELAH SELESAI!\n";
    echo "===========================================\n";
    
} else {
    echo "❌ GAGAL membuat symbolic link!\n\n";
    echo "Kemungkinan penyebab:\n";
    echo "1. Permission denied (coba jalankan via SSH)\n";
    echo "2. Symlink tidak diizinkan di hosting\n";
    echo "3. Open_basedir restriction\n\n";
    
    echo "SOLUSI ALTERNATIF:\n";
    echo "1. Hubungi hosting support untuk enable symlink\n";
    echo "2. Atau pindahkan foto ke public/images/ dan ubah path di code\n";
}

echo "</pre>";
