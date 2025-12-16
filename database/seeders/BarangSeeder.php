<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangs = [
            [
                'kode_barang' => 'LPT-001',
                'nama_barang' => 'Laptop ASUS',
                'deskripsi' => 'Laptop ASUS untuk keperluan kerja',
                'jumlah_total' => 5,
                'jumlah_tersedia' => 5,
            ],
            [
                'kode_barang' => 'LPT-002',
                'nama_barang' => 'Laptop HP',
                'deskripsi' => 'Laptop HP untuk keperluan presentasi',
                'jumlah_total' => 3,
                'jumlah_tersedia' => 3,
            ],
            [
                'kode_barang' => 'PRY-001',
                'nama_barang' => 'Proyektor Epson',
                'deskripsi' => 'Proyektor untuk ruang meeting',
                'jumlah_total' => 4,
                'jumlah_tersedia' => 4,
            ],
            [
                'kode_barang' => 'PRY-002',
                'nama_barang' => 'Proyektor BenQ',
                'deskripsi' => 'Proyektor portable',
                'jumlah_total' => 2,
                'jumlah_tersedia' => 2,
            ],
            [
                'kode_barang' => 'PRT-001',
                'nama_barang' => 'Printer Canon',
                'deskripsi' => 'Printer warna untuk dokumen',
                'jumlah_total' => 3,
                'jumlah_tersedia' => 3,
            ],
            [
                'kode_barang' => 'PRT-002',
                'nama_barang' => 'Printer HP LaserJet',
                'deskripsi' => 'Printer laser untuk cetak cepat',
                'jumlah_total' => 2,
                'jumlah_tersedia' => 2,
            ],
            [
                'kode_barang' => 'KMR-001',
                'nama_barang' => 'Kamera Sony',
                'deskripsi' => 'Kamera DSLR untuk dokumentasi',
                'jumlah_total' => 2,
                'jumlah_tersedia' => 2,
            ],
            [
                'kode_barang' => 'MIC-001',
                'nama_barang' => 'Microphone Wireless',
                'deskripsi' => 'Microphone untuk presentasi',
                'jumlah_total' => 5,
                'jumlah_tersedia' => 5,
            ],
            [
                'kode_barang' => 'SPK-001',
                'nama_barang' => 'Speaker Portable',
                'deskripsi' => 'Speaker untuk acara',
                'jumlah_total' => 3,
                'jumlah_tersedia' => 3,
            ],
            [
                'kode_barang' => 'HDC-001',
                'nama_barang' => 'Hardisk External 1TB',
                'deskripsi' => 'Hardisk untuk backup data',
                'jumlah_total' => 10,
                'jumlah_tersedia' => 10,
            ],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}
