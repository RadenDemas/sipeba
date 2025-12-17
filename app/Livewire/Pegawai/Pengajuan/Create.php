<?php

namespace App\Livewire\Pegawai\Pengajuan;

use App\Models\Barang;
use App\Models\Pengajuan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.app')]
#[Title('Ajukan Peminjaman')]
class Create extends Component
{
    #[Rule('required|exists:barangs,id')]
    public string $id_barang = '';

    #[Rule('required|date|after_or_equal:today')]
    public string $date_start = '';

    #[Rule('required|date|after_or_equal:date_start')]
    public string $date_end = '';

    #[Rule('required|integer|min:1')]
    public int $jumlah = 1;

    #[Rule('nullable|max:500')]
    public string $keterangan = '';

    public function save()
    {
        $this->validate();

        $barang = Barang::findOrFail($this->id_barang);

        // Check availability
        if ($barang->jumlah_tersedia < $this->jumlah) {
            $this->dispatch('swal:error', message: 'Stok tidak mencukupi. Tersedia: ' . $barang->jumlah_tersedia);
            return;
        }

        Pengajuan::create([
            'id_user' => auth()->id(),
            'id_barang' => $this->id_barang,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'jumlah' => $this->jumlah,
            'status' => 'pending',
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('swal', ['type' => 'success', 'message' => 'Pengajuan berhasil dibuat.']);

        return redirect()->route('pegawai.pengajuan.index');
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
        $barangs = Barang::where('jumlah_tersedia', '>', 0)->get();

        return view('livewire.pegawai.pengajuan.create', [
            'barangs' => $barangs,
        ]);
    }
}
