<?php

namespace App\Livewire\Admin\Barang;

use App\Models\Barang;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.app')]
#[Title('Tambah Barang')]
class Create extends Component
{
    #[Rule('required|unique:barangs,kode_barang|max:50')]
    public string $kode_barang = '';

    #[Rule('required|max:255')]
    public string $nama_barang = '';

    #[Rule('nullable|max:1000')]
    public string $deskripsi = '';

    #[Rule('required|integer|min:0')]
    public int $jumlah_total = 0;

    public function save()
    {
        $this->validate();

        Barang::create([
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'deskripsi' => $this->deskripsi,
            'jumlah_total' => $this->jumlah_total,
            'jumlah_tersedia' => $this->jumlah_total,
        ]);

        $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'petugas';
        
        session()->flash('swal', ['type' => 'success', 'message' => 'Barang berhasil ditambahkan.']);

        return redirect()->route($routePrefix . '.barang.index');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.admin.barang.create');
    }
}

