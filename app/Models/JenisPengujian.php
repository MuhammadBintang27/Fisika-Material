<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JenisPengujian extends Model
{
    use HasUuids;
    protected $table = 'jenis_pengujian';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'namaPengujian',
        'hargaPerSampel',
        'isAvailable',
    ];

    public function pengujianItems()
    {
        return $this->hasMany(PengujianItem::class, 'jenisPengujianId');
    }
} 
 