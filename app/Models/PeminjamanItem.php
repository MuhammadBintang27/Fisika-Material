<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanItem extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'peminjaman_item';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'peminjamanId',
        'alat_id',
        'jumlah',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjamanId');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
} 