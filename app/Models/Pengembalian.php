<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pengajuan',
        'id_petugas',
        'tanggal_pengembalian',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengembalian' => 'date',
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
     * Get the petugas who processed this return
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }
}
