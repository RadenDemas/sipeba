<?php

namespace App\Livewire\Pegawai\Pengajuan;

use App\Models\Pengajuan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Pengajuan Saya')]
class Index extends Component
{
    use WithPagination;

    public string $filterStatus = '';

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function cancel($id)
    {
        $pengajuan = Pengajuan::where('id_user', auth()->id())
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $pengajuan->update([
            'status' => 'ditolak',
            'canceled_at' => now(),
            'keterangan' => 'Dibatalkan oleh pemohon',
        ]);

        $this->dispatch('swal:success', message: 'Pengajuan berhasil dibatalkan.');
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
        $pengajuans = Pengajuan::with(['barang'])
            ->where('id_user', auth()->id())
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pegawai.pengajuan.index', [
            'pengajuans' => $pengajuans,
        ]);
    }
}
