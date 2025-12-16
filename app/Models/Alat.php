<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'alat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
        'deskripsi',
        'stok',
        'stok_dipinjam', // jumlah alat yang sedang dipinjam
        'stok_rusak', // jumlah alat rusak
        'isBroken',
        'harga',
    ];

    public function gambar()
    {
        return $this->hasMany(Gambar::class, 'alatID');
    }

    public function peminjamanItems()
    {
        return $this->hasMany(PeminjamanItem::class, 'alat_id');
    }
} 