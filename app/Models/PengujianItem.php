<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PengujianItem extends Model
{
    use HasUuids;
    protected $table = 'pengujian_item';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'jenisPengujianId',
        'pengujianId',
    ];

    public function jenisPengujian()
    {
        return $this->belongsTo(JenisPengujian::class, 'jenisPengujianId');
    }

    public function pengujian()
    {
        return $this->belongsTo(Pengujian::class, 'pengujianId');
    }
} 
 