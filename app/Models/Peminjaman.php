<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Peminjaman extends Model
{
    use HasUuids;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'tracking_code',
        'user_type',
        'namaPeminjam',
        'noHp',
        'email',
        'nip_nim',
        'instansi',
        'jabatan',
        'judul_penelitian',
        'deskripsi_penelitian',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'durasi_jam',
        'status',
        'notes',
        'supervisor_name',
        'supervisor_nip',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_pengembalian' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(PeminjamanItem::class, 'peminjamanId');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'PENDING' => 'Menunggu Persetujuan',
            'APPROVED' => 'Disetujui',
            'REJECTED' => 'Ditolak',
            'COMPLETED' => 'Selesai',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getUserTypeLabelAttribute()
    {
        $labels = [
            'dosen' => 'Dosen',
            'mahasiswa' => 'Mahasiswa',
            'pihak-luar' => 'Pihak Luar USK',
        ];

        return $labels[$this->user_type] ?? $this->user_type;
    }
} 