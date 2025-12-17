<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengembalian extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_DIKEMBALIKAN = 'dikembalikan';

    protected $fillable = [
        'id_pengajuan',
        'id_user',
        'id_petugas',
        'status',
        'tanggal_pengembalian',
        'verified_at',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengembalian' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Get the pengajuan being returned
     */
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }

    /**
     * Get the user who requested the return
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the petugas who processed this return
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    /**
     * Check if return request is pending verification
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if return is completed
     */
    public function isDikembalikan(): bool
    {
        return $this->status === self::STATUS_DIKEMBALIKAN;
    }
}

