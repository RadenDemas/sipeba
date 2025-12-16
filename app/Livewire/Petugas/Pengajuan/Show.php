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
        if ($this->pengajuan->status !== 'pending') {
            session()->flash('error', 'Pengajuan sudah diproses.');
            return;
        }

        $barang = $this->pengajuan->barang;

        // Check stock availability
        if ($barang->jumlah_tersedia < $this->pengajuan->jumlah) {
            session()->flash('error', 'Stok tidak mencukupi.');
            return;
        }

        // Reduce available stock
        $barang->decrement('jumlah_tersedia', $this->pengajuan->jumlah);

        $this->pengajuan->update([
            'status' => 'disetujui',
            'id_petugas' => auth()->id(),
            'approved_at' => now(),
        ]);

        session()->flash('success', 'Pengajuan disetujui.');
        return redirect()->route('petugas.pengajuan.index');
    }

    public function reject()
    {
        if ($this->pengajuan->status !== 'pending') {
            session()->flash('error', 'Pengajuan sudah diproses.');
            return;
        }

        $this->pengajuan->update([
            'status' => 'ditolak',
            'id_petugas' => auth()->id(),
        ]);

        session()->flash('success', 'Pengajuan ditolak.');
        return redirect()->route('petugas.pengajuan.index');
    }

    public function markDipinjam()
    {
        if ($this->pengajuan->status !== 'disetujui') {
            session()->flash('error', 'Pengajuan belum disetujui.');
            return;
        }

        $this->pengajuan->update([
            'status' => 'dipinjam',
        ]);

        session()->flash('success', 'Status diubah menjadi dipinjam.');
        return redirect()->route('petugas.pengajuan.index');
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
