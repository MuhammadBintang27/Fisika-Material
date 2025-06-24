<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kunjungan extends Model
{
    use HasUuids;
    protected $table = 'kunjungan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'namaPengunjung',
        'tujuan',
        'jumlahPengunjung',
        'status',
    ];

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'kunjunganId');
    }
} 
 