<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengajuan extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_DISETUJUI = 'disetujui';
    const STATUS_DITOLAK = 'ditolak';
    const STATUS_DIPINJAM = 'dipinjam';
    const STATUS_SELESAI = 'selesai';

    protected $fillable = [
        'id_user',
        'id_barang',
        'id_petugas',
        'date_start',
        'date_end',
        'jumlah',
        'status',
        'approved_at',
        'canceled_at',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'date_start' => 'date',
            'date_end' => 'date',
            'approved_at' => 'datetime',
            'canceled_at' => 'datetime',
        ];
    }

    /**
     * Get the user who created this pengajuan
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the barang being borrowed
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    /**
     * Get the petugas who processed this pengajuan
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    /**
     * Get the pengembalian for this pengajuan
     */
    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class, 'id_pengajuan');
    }

    /**
     * Check if pengajuan is pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if pengajuan is approved
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_DISETUJUI;
    }
}
