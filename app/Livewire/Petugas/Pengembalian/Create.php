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
    public ?Pengembalian $existingReturn = null;

    #[Rule('nullable|max:500')]
    public string $keterangan = '';

    public function mount(Pengajuan $pengajuan)
    {
        $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'petugas';
        
        if ($pengajuan->status !== 'dipinjam') {
            session()->flash('swal', ['type' => 'error', 'message' => 'Pengajuan ini bukan status dipinjam.']);
            return redirect()->route($routePrefix . '.pengembalian.index');
        }
        
        $this->pengajuan = $pengajuan->load(['user', 'barang']);
        
        // Check if there's an existing pending return request
        $this->existingReturn = $pengajuan->pengembalian;
    }

    public function save()
    {
        $this->validate();

        $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'petugas';

        // Check if there's already a pending return request
        if ($this->existingReturn && $this->existingReturn->status === 'pending') {
            // Verify the existing return request
            $this->existingReturn->update([
                'status' => 'dikembalikan',
                'id_petugas' => auth()->id(),
                'verified_at' => now(),
                'keterangan' => $this->keterangan ?: $this->existingReturn->keterangan,
            ]);
        } else {
            // Create new pengembalian record (direct processing)
            Pengembalian::create([
                'id_pengajuan' => $this->pengajuan->id,
                'id_petugas' => auth()->id(),
                'status' => 'dikembalikan',
                'tanggal_pengembalian' => now(),
                'verified_at' => now(),
                'keterangan' => $this->keterangan,
            ]);
        }

        // Update pengajuan status
        $this->pengajuan->update([
            'status' => 'selesai',
        ]);

        // Restore stock
        $this->pengajuan->barang->increment('jumlah_tersedia', $this->pengajuan->jumlah);

        session()->flash('swal', ['type' => 'success', 'message' => 'Pengembalian berhasil dicatat.']);

        return redirect()->route($routePrefix . '.pengembalian.index');
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

