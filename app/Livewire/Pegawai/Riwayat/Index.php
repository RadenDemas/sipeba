<?php

namespace App\Livewire\Pegawai\Riwayat;

use App\Models\Pengajuan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Riwayat Peminjaman')]
class Index extends Component
{
    use WithPagination;

    public string $filterStatus = '';

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
        $riwayats = Pengajuan::with(['barang', 'pengembalian'])
            ->where('id_user', auth()->id())
            ->whereIn('status', ['selesai', 'ditolak'])
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('livewire.pegawai.riwayat.index', [
            'riwayats' => $riwayats,
        ]);
    }
}
