<?php

namespace App\Livewire\Petugas\Pengajuan;

use App\Models\Pengajuan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Detail Pengajuan')]
class Show extends Component
{
    public Pengajuan $pengajuan;

    public function mount(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan->load(['user', 'barang', 'petugas']);
    }

    public function approve()
    {
        $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'petugas';

        if ($this->pengajuan->status !== 'pending') {
            $this->dispatch('swal:error', message: 'Pengajuan sudah diproses.');
            return;
        }

        $barang = $this->pengajuan->barang;

        // Check stock availability
        if ($barang->jumlah_tersedia < $this->pengajuan->jumlah) {
            $this->dispatch('swal:error', message: 'Stok tidak mencukupi.');
            return;
        }

        // Reduce available stock
        $barang->decrement('jumlah_tersedia', $this->pengajuan->jumlah);

        // Directly set status to 'dipinjam' (simplified flow)
        $this->pengajuan->update([
            'status' => 'dipinjam',
            'id_petugas' => auth()->id(),
            'approved_at' => now(),
        ]);

        session()->flash('swal', ['type' => 'success', 'message' => 'Pengajuan disetujui. Barang sudah dipinjam.']);
        return redirect()->route($routePrefix . '.pengajuan.index');
    }

    public function reject()
    {
        $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'petugas';

        if ($this->pengajuan->status !== 'pending') {
            $this->dispatch('swal:error', message: 'Pengajuan sudah diproses.');
            return;
        }

        $this->pengajuan->update([
            'status' => 'ditolak',
            'id_petugas' => auth()->id(),
        ]);

        session()->flash('swal', ['type' => 'success', 'message' => 'Pengajuan berhasil ditolak.']);
        return redirect()->route($routePrefix . '.pengajuan.index');
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
        return view('livewire.petugas.pengajuan.show');
    }
}

