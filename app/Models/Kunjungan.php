<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Kunjungan extends Model
{
    use HasUuids;
    protected $table = 'kunjungan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'tracking_code',
        'namaPengunjung',
        'tujuan',
        'jumlahPengunjung',
        'status',
        'noHp',
        'namaInstansi',
        'suratPengajuan',
        'notes',
    ];

    protected $casts = [
        'jumlahPengunjung' => 'integer',
    ];

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'kunjunganId');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }
    public function scopeProcessing($query)
    {
        return $query->where('status', 'PROCESSING');
    }
    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }
    public function scopeCancelled($query)
    {
        return $query->where('status', 'CANCELLED');
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'PENDING' => 'Menunggu',
            'PROCESSING' => 'Diproses',
            'COMPLETED' => 'Selesai',
            'CANCELLED' => 'Dibatalkan',
            default => $this->status
        };
    }
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'PENDING' => 'warning',
            'PROCESSING' => 'info',
            'COMPLETED' => 'success',
            'CANCELLED' => 'danger',
            default => 'secondary'
        };
    }

    // Methods
    public function canBeCancelled()
    {
        return in_array($this->status, ['PENDING']);
    }
    public function canBeApproved()
    {
        return in_array($this->status, ['PENDING']);
    }
    public function canBeCompleted()
    {
        return in_array($this->status, ['PROCESSING']);
    }

    // Generate unique tracking_code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->tracking_code)) {
                $model->tracking_code = self::generateUniqueTrackingCode();
            }
        });
    }

    protected static function generateUniqueTrackingCode()
    {
        do {
            $code = 'KUNJ-' . Str::random(6);
        } while (self::where('tracking_code', $code)->exists());

        return $code;
    }
}