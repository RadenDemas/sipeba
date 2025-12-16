<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'jumlah_total',
        'jumlah_tersedia',
    ];

    /**
     * Get all pengajuans for this barang
     */
    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'id_barang');
    }

    /**
     * Check if barang is available for certain quantity
     */
    public function isAvailable(int $jumlah = 1): bool
    {
        return $this->jumlah_tersedia >= $jumlah;
    }
}
