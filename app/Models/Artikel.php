<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Artikel extends Model
{
    use HasUuids;
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'namaAcara',
        'deskripsi',
        'penulis',
        'deskripsi_penulis',
        'tanggalAcara',
    ];

    public function gambar()
    {
        return $this->hasMany(Gambar::class, 'acaraId');
    }
} 