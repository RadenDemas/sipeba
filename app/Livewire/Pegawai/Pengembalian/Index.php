<?php

namespace App\Livewire\Pegawai\Pengembalian;

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

    public string $filterStatus = '';

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    /**
     * Request return - pegawai initiates return request
     */
    public function requestReturn($pengajuanId)
    {
        $pengajuan = Pengajuan::where('id_user', auth()->id())
            ->where('id', $pengajuanId)
            ->where('status', 'dipinjam')
            ->firstOrFail();

        // Check if there's already a pending return request
        if ($pengajuan->pengembalian && $pengajuan->pengembalian->status === 'pending') {
            $this->dispatch('swal:error', message: 'Request pengembalian sudah dibuat sebelumnya.');
            return;
        }

        // Create pengembalian with pending status
        Pengembalian::create([
            'id_pengajuan' => $pengajuan->id,
            'id_user' => auth()->id(),
            'status' => 'pending',
            'tanggal_pengembalian' => now(),
        ]);

        $this->dispatch('swal:success', message: 'Request pengembalian berhasil dikirim. Menunggu verifikasi petugas.');
    }

    /**
     * Cancel pending return request
     */
    public function cancelReturn($pengajuanId)
    {
        $pengajuan = Pengajuan::where('id_user', auth()->id())
            ->where('id', $pengajuanId)
            ->firstOrFail();

        if ($pengajuan->pengembalian && $pengajuan->pengembalian->status === 'pending') {
            $pengajuan->pengembalian->delete();
            $this->dispatch('swal:success', message: 'Request pengembalian dibatalkan.');
        }
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
        $pengajuans = Pengajuan::with(['barang', 'pengembalian'])
            ->where('id_user', auth()->id())
            ->where('status', 'dipinjam')
            ->orderBy('date_end', 'asc')
            ->paginate(10);

        return view('livewire.pegawai.pengembalian.index', [
            'pengajuans' => $pengajuans,
        ]);
    }
}
