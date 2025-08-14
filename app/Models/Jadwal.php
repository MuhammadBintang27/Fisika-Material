<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class Jadwal extends Model
{
    use HasUuids;
    protected $table = 'jadwal';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kunjunganId',
        'tanggal',
        'jamMulai',
        'jamSelesai',
        'isActive',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'isActive' => 'boolean',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjunganId');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Filter schedules by date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
/*******  b5b685b4-e06e-4e93-8f1b-d089edad0ade  *******/
    public function scopeByDate($query, $date)
    {
        return $query->where('tanggal', $date);
    }

    public function scopeByTime($query, $jamMulai, $jamSelesai)
    {
        return $query->where('jamMulai', $jamMulai)->where('jamSelesai', $jamSelesai);
    }

    public function scopeAvailable($query)
    {
        return $query->where('isActive', true)->whereNull('kunjunganId');
    }

    public function scopeWithKunjungan($query)
    {
        return $query->whereNotNull('kunjunganId');
    }

    // Accessors
    public function getTimeLabelAttribute()
    {
        if (!$this->jamMulai || !$this->jamSelesai) {
            return 'Tidak ditentukan';
        }
        return Carbon::parse($this->jamMulai)->format('H.i') . ' - ' . Carbon::parse($this->jamSelesai)->format('H.i');
    }

    public function getDurationAttribute()
    {
        if (!$this->jamMulai || !$this->jamSelesai) {
            return 0;
        }
        return Carbon::parse($this->jamMulai)->diffInHours(Carbon::parse($this->jamSelesai));
    }

    public function getIsBookedAttribute()
    {
        return !is_null($this->kunjunganId);
    }

    public function getKunjunganInfoAttribute()
    {
        if ($this->kunjungan) {
            $status = $this->kunjungan->status === 'COMPLETED' ? '✓' : '';
            return $status . ' ' . $this->kunjungan->namaPengunjung . ' (' . $this->time_label . ')';
        }
        return null;
    }

    // Methods
    public function isAvailable()
    {
        return $this->isActive && is_null($this->kunjunganId);
    }

    public function getEndTime()
    {
        return $this->jamSelesai;
    }

    // Static methods for generating default schedule
    public static function getDefaultHours()
    {
        return [
            '09:00:00' => '10:00:00',
            '10:00:00' => '11:00:00',
            '11:00:00' => '12:00:00',
            '12:00:00' => '13:00:00',
            '13:00:00' => '14:00:00',
            '14:00:00' => '15:00:00',
            '15:00:00' => '16:00:00',
            '16:00:00' => '17:00:00',
        ];
    }

    public static function createDefaultSchedule($tanggal)
    {
        \Log::info("Creating default schedule for: $tanggal");
        $hours = self::getDefaultHours();
        $schedules = [];
        try {
            foreach ($hours as $jamMulai => $jamSelesai) {
                $schedule = self::firstOrCreate([
                    'tanggal' => $tanggal,
                    'jamMulai' => $jamMulai,
                    'jamSelesai' => $jamSelesai,
                ], [
                    'isActive' => true,
                    'kunjunganId' => null,
                ]);
                $schedules[] = $schedule;
                \Log::info("Created/Found schedule: ID={$schedule->id}, Time={$jamMulai}-{$jamSelesai}");
            }
        } catch (\Exception $e) {
            \Log::error("Error creating schedule for $tanggal: " . $e->getMessage());
            throw $e;
        }
        return $schedules;
    }
}