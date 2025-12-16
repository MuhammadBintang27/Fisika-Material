<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BiodataPengurus extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'biodata_pengurus';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
        'jabatan',
    ];

    public function gambar()
    {
        return $this->hasMany(Gambar::class, 'pengurusId');
    }
} 