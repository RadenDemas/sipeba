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
    public string $tab = 'pending'; // pending or dipinjam

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTab()
    {
        $this->resetPage();
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    /**
     * Verify a pending return request from pegawai
     */
    public function verifyReturn($pengembalianId)
    {
        $pengembalian = Pengembalian::with('pengajuan.barang')->findOrFail($pengembalianId);
        
        if ($pengembalian->status !== 'pending') {
            $this->dispatch('swal:error', message: 'Pengembalian sudah diverifikasi.');
            return;
        }

        // Update pengembalian status
        $pengembalian->update([
            'status' => 'dikembalikan',
            'id_petugas' => auth()->id(),
            'verified_at' => now(),
        ]);

        // Update pengajuan status
        $pengembalian->pengajuan->update([
            'status' => 'selesai',
        ]);

        // Restore stock
        $pengembalian->pengajuan->barang->increment('jumlah_tersedia', $pengembalian->pengajuan->jumlah);

        $this->dispatch('swal:success', message: 'Pengembalian berhasil diverifikasi.');
    }

    /**
     * Reject a pending return request (barang belum dikembalikan)
     */
    public function rejectReturn($pengembalianId)
    {
        $pengembalian = Pengembalian::findOrFail($pengembalianId);
        
        if ($pengembalian->status !== 'pending') {
            $this->dispatch('swal:error', message: 'Pengembalian sudah diproses.');
            return;
        }

        // Delete the pending return request
        $pengembalian->delete();

        $this->dispatch('swal:success', message: 'Request pengembalian ditolak. Barang masih berstatus dipinjam.');
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
        // Pending return requests from pegawai
        $pendingReturns = Pengembalian::with(['pengajuan.user', 'pengajuan.barang', 'user'])
            ->where('status', 'pending')
            ->when($this->search, function ($query) {
                $query->whereHas('pengajuan.user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('pengajuan.barang', function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10, ['*'], 'pendingPage');

        // List of items to return (status = dipinjam, no pending return request)
        $dipinjam = Pengajuan::with(['user', 'barang'])
            ->where('status', 'dipinjam')
            ->whereDoesntHave('pengembalian', function ($query) {
                $query->where('status', 'pending');
            })
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('barang', function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('date_end', 'asc')
            ->paginate(10, ['*'], 'dipinjamPage');

        return view('livewire.petugas.pengembalian.index', [
            'pendingReturns' => $pendingReturns,
            'dipinjam' => $dipinjam,
        ]);
    }
}

