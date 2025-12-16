<?php

namespace App\Livewire\Petugas\Pengembalian;

use App\Models\Pengajuan;
use App\Models\Pengembalian;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Pengembalian Barang')]
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
        // List of items to return (status = dipinjam)
        $dipinjam = Pengajuan::with(['user', 'barang'])
            ->where('status', 'dipinjam')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('barang', function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('date_end', 'asc')
            ->paginate(10);

        return view('livewire.petugas.pengembalian.index', [
            'dipinjam' => $dipinjam,
        ]);
    }
}
