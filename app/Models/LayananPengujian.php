<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayananPengujian extends Model
{
    use HasFactory;
    protected $table = 'layanan_pengujian';
    
    protected $fillable = [
        'namaLayanan',
        'deskripsi',
        'estimasiSelesaiHari',
        'harga',
        'isAktif',
        'instruksiSampel',
    ];

    protected $casts = [
        'isAktif' => 'boolean',
        'harga' => 'integer',
        'estimasiSelesaiHari' => 'integer',
    ];

    public function pengajuanPengujian()
    {
        return $this->hasMany(PengajuanPengujian::class, 'layananId');
    }

    public function scopeAktif($query)
    {
        return $query->where('isAktif', true);
    }
} 
 