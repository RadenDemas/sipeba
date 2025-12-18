<?php

namespace App\Livewire\Admin\Pengajuan;

use App\Models\Pengajuan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Kelola Pengajuan')]
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

    public function delete($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        
        // If status is dipinjam, restore stock before deleting
        if ($pengajuan->status === 'dipinjam') {
            $pengajuan->barang->increment('jumlah_tersedia', $pengajuan->jumlah);
        }
        
        // Delete related pengembalian if exists
        if ($pengajuan->pengembalian) {
            $pengajuan->pengembalian->delete();
        }
        
        $pengajuan->delete();
        
        $this->dispatch('swal:success', message: 'Pengajuan berhasil dihapus.');
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
        $pengajuans = Pengajuan::with(['user', 'barang'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('barang', function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.pengajuan.index', [
            'pengajuans' => $pengajuans,
        ]);
    }
}
