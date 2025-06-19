<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Alat extends Model
{
    use HasUuids;
    protected $table = 'alat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
        'deskripsi',
        'stok',
        'isBroken',
        'harga',
    ];

    public function gambar()
    {
        return $this->hasMany(Gambar::class, 'alat_id');
    }

    public function peminjamanItems()
    {
        return $this->hasMany(PeminjamanItem::class, 'alat_id');
    }
} 