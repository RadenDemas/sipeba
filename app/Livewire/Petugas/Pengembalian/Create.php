<?php

namespace App\Livewire\Petugas\Pengembalian;

use App\Models\Pengajuan;
use App\Models\Pengembalian;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.app')]
#[Title('Proses Pengembalian')]
class Create extends Component
{
    public Pengajuan $pengajuan;

    #[Rule('nullable|max:500')]
    public string $keterangan = '';

    public function mount(Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'dipinjam') {
            session()->flash('error', 'Pengajuan ini bukan status dipinjam.');
            return redirect()->route('petugas.pengembalian.index');
        }
        
        $this->pengajuan = $pengajuan->load(['user', 'barang']);
    }

    public function save()
    {
        $this->validate();

        // Create pengembalian record
        Pengembalian::create([
            'id_pengajuan' => $this->pengajuan->id,
            'id_petugas' => auth()->id(),
            'tanggal_pengembalian' => now(),
            'keterangan' => $this->keterangan,
        ]);

        // Update pengajuan status
        $this->pengajuan->update([
            'status' => 'selesai',
        ]);

        // Restore stock
        $this->pengajuan->barang->increment('jumlah_tersedia', $this->pengajuan->jumlah);

        session()->flash('success', 'Pengembalian berhasil dicatat.');

        return redirect()->route('petugas.pengembalian.index');
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
        return view('livewire.petugas.pengembalian.create');
    }
}
