<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProfilLaboratorium extends Model
{
    use HasUuids;
    protected $table = 'profil_laboratorium';
    protected $fillable = [
        'tentang',
        'visi',
        'alamat',
        'email',
        'telepon',
    ];

    public function misi(): BelongsTo
    {
        return $this->belongsTo(Misi::class, 'misiId');
    }
}
