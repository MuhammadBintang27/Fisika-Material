<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Gambar extends Model
{
    use HasUuids;
    protected $table = 'gambar';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'pengurusId',
        'acaraId',
        'alatID',
        'url',
        'kategori',
    ];

    public function staff()
    {
        return $this->belongsTo(BiodataPengurus::class, 'pengurusId');
    }

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'acaraId');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alatID');
    }
} 