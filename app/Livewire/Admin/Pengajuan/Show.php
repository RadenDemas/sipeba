<?php

namespace App\Livewire\Admin\Pengajuan;

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
        $this->pengajuan = $pengajuan->load(['user', 'barang', 'petugas', 'pengembalian']);
    }

    public function delete()
    {
        // If status is dipinjam, restore stock before deleting
        if ($this->pengajuan->status === 'dipinjam') {
            $this->pengajuan->barang->increment('jumlah_tersedia', $this->pengajuan->jumlah);
        }
        
        // Delete related pengembalian if exists
        if ($this->pengajuan->pengembalian) {
            $this->pengajuan->pengembalian->delete();
        }
        
        $this->pengajuan->delete();

        session()->flash('swal', ['type' => 'success', 'message' => 'Pengajuan berhasil dihapus.']);
        return redirect()->route('admin.pengajuan.index');
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
        return view('livewire.admin.pengajuan.show');
    }
}
