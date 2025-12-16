<?php

namespace App\Livewire\Pegawai\Barang;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Daftar Barang')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
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
        $barangs = Barang::query()
            ->when($this->search, function ($query) {
                $query->where('nama_barang', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_barang', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_barang', 'asc')
            ->paginate(12);

        return view('livewire.pegawai.barang.index', [
            'barangs' => $barangs,
        ]);
    }
}
