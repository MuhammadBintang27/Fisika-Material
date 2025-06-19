<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Peminjaman extends Model
{
    use HasUuids;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'namaPeminjam',
        'noHp',
        'tujuanPeminjaman',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(PeminjamanItem::class, 'peminjamanId');
    }
} 