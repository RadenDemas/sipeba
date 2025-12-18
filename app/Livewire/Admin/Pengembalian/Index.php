<?php

namespace App\Livewire\Admin\Pengembalian;

use App\Models\Pengembalian;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Data Pengembalian')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
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
        $pengembalians = Pengembalian::with(['pengajuan.user', 'pengajuan.barang', 'user', 'petugas'])
            ->when($this->search, function ($query) {
                $query->whereHas('pengajuan.user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('pengajuan.barang', function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.pengembalian.index', [
            'pengembalians' => $pengembalians,
        ]);
    }
}
