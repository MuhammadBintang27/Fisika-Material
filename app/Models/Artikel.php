<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory, HasUuids;
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