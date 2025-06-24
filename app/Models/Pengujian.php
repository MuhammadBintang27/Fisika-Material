<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pengujian extends Model
{
    use HasUuids;
    protected $table = 'pengujian';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'namaPenguji',
        'noHpPenguji',
        'deskripsi',
        'totalHarga',
        'tanggalPengujian',
        'status',
    ];

    protected $casts = [
        'tanggalPengujian' => 'datetime',
        'totalHarga' => 'integer',
    ];

    public function pengujianItems()
    {
        return $this->hasMany(PengujianItem::class, 'pengujianId');
    }

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'pengujianId');
    }
} 
 