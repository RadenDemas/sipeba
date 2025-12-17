<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Barang\Index as AdminBarangIndex;
use App\Livewire\Admin\Barang\Create as AdminBarangCreate;
use App\Livewire\Admin\Barang\Edit as AdminBarangEdit;
use App\Livewire\Petugas\Dashboard as PetugasDashboard;
use App\Livewire\Pegawai\Dashboard as PegawaiDashboard;

// Redirect root to login
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            default => redirect()->route('pegawai.dashboard'),
        };
    }
    return redirect()->route('login');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    
    // Barang CRUD
    Route::get('/barang', AdminBarangIndex::class)->name('barang.index');
    Route::get('/barang/create', AdminBarangCreate::class)->name('barang.create');
    Route::get('/barang/{barang}/edit', AdminBarangEdit::class)->name('barang.edit');

    // User CRUD
    Route::get('/user', \App\Livewire\Admin\User\Index::class)->name('user.index');
    Route::get('/user/create', \App\Livewire\Admin\User\Create::class)->name('user.create');
    Route::get('/user/{user}/edit', \App\Livewire\Admin\User\Edit::class)->name('user.edit');

    // Pengajuan (reuse Petugas components)
    Route::get('/pengajuan', \App\Livewire\Petugas\Pengajuan\Index::class)->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', \App\Livewire\Petugas\Pengajuan\Show::class)->name('pengajuan.show');

    // Pengembalian (reuse Petugas components)
    Route::get('/pengembalian', \App\Livewire\Petugas\Pengembalian\Index::class)->name('pengembalian.index');
    Route::get('/pengembalian/{pengajuan}', \App\Livewire\Petugas\Pengembalian\Create::class)->name('pengembalian.create');
});

// Petugas routes
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', PetugasDashboard::class)->name('dashboard');
    
    // Barang CRUD
    Route::get('/barang', AdminBarangIndex::class)->name('barang.index');
    Route::get('/barang/create', AdminBarangCreate::class)->name('barang.create');
    Route::get('/barang/{barang}/edit', AdminBarangEdit::class)->name('barang.edit');

    // Pengajuan
    Route::get('/pengajuan', \App\Livewire\Petugas\Pengajuan\Index::class)->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', \App\Livewire\Petugas\Pengajuan\Show::class)->name('pengajuan.show');

    // Pengembalian
    Route::get('/pengembalian', \App\Livewire\Petugas\Pengembalian\Index::class)->name('pengembalian.index');
    Route::get('/pengembalian/{pengajuan}', \App\Livewire\Petugas\Pengembalian\Create::class)->name('pengembalian.create');
});

// Pegawai routes
Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', PegawaiDashboard::class)->name('dashboard');

    // Barang (read-only)
    Route::get('/barang', \App\Livewire\Pegawai\Barang\Index::class)->name('barang.index');

    // Pengajuan
    Route::get('/pengajuan', \App\Livewire\Pegawai\Pengajuan\Index::class)->name('pengajuan.index');
    Route::get('/pengajuan/create', \App\Livewire\Pegawai\Pengajuan\Create::class)->name('pengajuan.create');

    // Pengembalian
    Route::get('/pengembalian', \App\Livewire\Pegawai\Pengembalian\Index::class)->name('pengembalian.index');

    // Riwayat
    Route::get('/riwayat', \App\Livewire\Pegawai\Riwayat\Index::class)->name('riwayat.index');
});


