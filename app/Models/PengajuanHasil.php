<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanHasil extends Model
{
    protected $table = 'pengajuan_hasil';
    
    protected $fillable = [
        'pengajuanId',
        'fileHasil',
        'namaFile',
        'ukuranFile',
        'tipeFile',
        'catatan',
        'uploadedAt',
    ];

    protected $casts = [
        'uploadedAt' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPengujian::class, 'pengajuanId');
    }
}
