<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Jadwal extends Model
{
    use HasUuids;
    protected $table = 'jadwal';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'pengujianId',
        'kunjunganId',
        'tanggalMulai',
        'tanggalSelesai',
    ];

    public function pengujian()
    {
        return $this->belongsTo(Pengujian::class, 'pengujianId');
    }

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjunganId');
    }
} 
 