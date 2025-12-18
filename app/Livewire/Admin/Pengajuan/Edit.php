<?php

namespace App\Livewire\Admin\Pengajuan;

use App\Models\Barang;
use App\Models\User;
use App\Models\Pengajuan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.app')]
#[Title('Edit Pengajuan')]
class Edit extends Component
{
    public Pengajuan $pengajuan;
    public int $originalJumlah;
    public string $originalStatus;

    #[Rule('required|exists:users,id')]
    public string $id_user = '';

    #[Rule('required|exists:barangs,id')]
    public string $id_barang = '';

    #[Rule('required|date')]
    public string $date_start = '';

    #[Rule('required|date|after_or_equal:date_start')]
    public string $date_end = '';

    #[Rule('required|integer|min:1')]
    public int $jumlah = 1;

    #[Rule('required|in:pending,dipinjam,ditolak,selesai')]
    public string $status = '';

    #[Rule('nullable|max:500')]
    public string $keterangan = '';

    public function mount(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan;
        $this->originalJumlah = $pengajuan->jumlah;
        $this->originalStatus = $pengajuan->status;
        
        $this->id_user = (string) $pengajuan->id_user;
        $this->id_barang = (string) $pengajuan->id_barang;
        $this->date_start = $pengajuan->date_start->format('Y-m-d');
        $this->date_end = $pengajuan->date_end->format('Y-m-d');
        $this->jumlah = $pengajuan->jumlah;
        $this->status = $pengajuan->status;
        $this->keterangan = $pengajuan->keterangan ?? '';
    }

    public function save()
    {
        $this->validate();

        $barang = Barang::findOrFail($this->id_barang);

        // Handle stock changes based on status transitions
        if ($this->originalStatus === 'dipinjam' && $this->status !== 'dipinjam') {
            // Was borrowed, now not - restore original stock
            $this->pengajuan->barang->increment('jumlah_tersedia', $this->originalJumlah);
        } elseif ($this->originalStatus !== 'dipinjam' && $this->status === 'dipinjam') {
            // Wasn't borrowed, now is - reduce stock
            if ($barang->jumlah_tersedia < $this->jumlah) {
                $this->dispatch('swal:error', message: 'Stok tidak mencukupi. Tersedia: ' . $barang->jumlah_tersedia);
                return;
            }
            $barang->decrement('jumlah_tersedia', $this->jumlah);
        } elseif ($this->originalStatus === 'dipinjam' && $this->status === 'dipinjam') {
            // Still borrowed - adjust stock difference if jumlah changed
            $diff = $this->jumlah - $this->originalJumlah;
            if ($diff > 0 && $barang->jumlah_tersedia < $diff) {
                $this->dispatch('swal:error', message: 'Stok tidak mencukupi. Tersedia: ' . $barang->jumlah_tersedia);
                return;
            }
            if ($diff !== 0) {
                $barang->decrement('jumlah_tersedia', $diff);
            }
        }

        $this->pengajuan->update([
            'id_user' => $this->id_user,
            'id_barang' => $this->id_barang,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'jumlah' => $this->jumlah,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('swal', ['type' => 'success', 'message' => 'Pengajuan berhasil diperbarui.']);

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
        $users = User::where('role', 'pegawai')->orderBy('name')->get();
        $barangs = Barang::all();

        return view('livewire.admin.pengajuan.edit', [
            'users' => $users,
            'barangs' => $barangs,
        ]);
    }
}
