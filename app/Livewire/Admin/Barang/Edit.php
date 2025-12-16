<?php

namespace App\Livewire\Admin\Barang;

use App\Models\Barang;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.app')]
#[Title('Edit Barang')]
class Edit extends Component
{
    public Barang $barang;

    #[Rule('required|max:50')]
    public string $kode_barang = '';

    #[Rule('required|max:255')]
    public string $nama_barang = '';

    #[Rule('nullable|max:1000')]
    public string $deskripsi = '';

    #[Rule('required|integer|min:0')]
    public int $jumlah_total = 0;

    public function mount(Barang $barang)
    {
        $this->barang = $barang;
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->deskripsi = $barang->deskripsi ?? '';
        $this->jumlah_total = $barang->jumlah_total;
    }

    public function rules()
    {
        return [
            'kode_barang' => 'required|max:50|unique:barangs,kode_barang,' . $this->barang->id,
        ];
    }

    public function save()
    {
        $this->validate();

        // Calculate new available stock
        $stockDifference = $this->jumlah_total - $this->barang->jumlah_total;
        $newAvailable = $this->barang->jumlah_tersedia + $stockDifference;

        $this->barang->update([
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'deskripsi' => $this->deskripsi,
            'jumlah_total' => $this->jumlah_total,
            'jumlah_tersedia' => max(0, $newAvailable),
        ]);

        session()->flash('success', 'Barang berhasil diperbarui.');

        return redirect()->route('admin.barang.index');
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
        return view('livewire.admin.barang.edit');
    }
}

