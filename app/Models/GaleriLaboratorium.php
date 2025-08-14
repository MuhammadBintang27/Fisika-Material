<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriLaboratorium extends Model
{
    protected $fillable = [
        'judul',
        'gambar_url',
        'fasilitas',
    ];

    protected $casts = [
        'fasilitas' => 'array',
    ];
}
