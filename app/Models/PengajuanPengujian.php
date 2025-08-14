<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PengajuanPengujian extends Model
{
    protected $table = 'pengajuan_pengujian';
    
    protected $fillable = [
        'trackingCode',
        'namaPengaju',
        'noHp',
        'email',
        'nim',
        'nip',
        'instansi',
        'prodi',
        'alamat',
        'userType',
        'layananId',
        'tanggalPengajuan',
        'tanggalPenyerahan',
        'jumlahSampel',
        'deskripsiSampel',
        'filePendukung',
        'detailKhusus',
        'status',
        'estimasiSelesai',
        'catatanAdmin',
        'tanggalSelesai',
    ];

    protected $casts = [
        'tanggalPengajuan' => 'datetime',
        'tanggalPenyerahan' => 'date',
        'tanggalSelesai' => 'datetime',
        'estimasiSelesai' => 'date',
        'detailKhusus' => 'array',
        'jumlahSampel' => 'integer',
    ];

    public function layanan()
    {
        return $this->belongsTo(LayananPengujian::class, 'layananId');
    }

    public function hasil()
    {
        return $this->hasMany(PengajuanHasil::class, 'pengajuanId');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByTrackingCode($query, $code)
    {
        return $query->where('trackingCode', $code);
    }

    public static function generateTrackingCode()
    {
        do {
            $code = 'PU' . date('Ymd') . strtoupper(Str::random(4));
        } while (self::where('trackingCode', $code)->exists());
        
        return $code;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'MENUNGGU' => 'bg-yellow-100 text-yellow-800',
            'DISETUJUI' => 'bg-green-100 text-green-800',
            'DITOLAK' => 'bg-red-100 text-red-800',
            'DIPROSES' => 'bg-blue-100 text-blue-800',
            'SELESAI' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getUserTypeLabelAttribute()
    {
        $labels = [
            'DOSEN' => 'Dosen',
            'MAHASISWA' => 'Mahasiswa',
            'UMUM' => 'Umum',
        ];

        return $labels[$this->userType] ?? $this->userType;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'MENUNGGU' => 'Menunggu Persetujuan',
            'DISETUJUI' => 'Disetujui',
            'DITOLAK' => 'Ditolak',
            'DIPROSES' => 'Sedang Diproses',
            'SELESAI' => 'Selesai',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    // Methods untuk status management
    public function canBeCancelled()
    {
        return in_array($this->status, ['MENUNGGU']);
    }

    public function canBeApproved()
    {
        return in_array($this->status, ['MENUNGGU']);
    }

    public function canBeCompleted()
    {
        return in_array($this->status, ['DIPROSES']);
    }
}
