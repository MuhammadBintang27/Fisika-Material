<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory, HasUuids;
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
        'tujuan_peminjaman',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'durasi_jam',
        'status',
        'notes',
        'supervisor_name',
        'supervisor_nip',
        'supervisor_instansi',
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
            'ONGOING' => 'Berlangsung',
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
} 