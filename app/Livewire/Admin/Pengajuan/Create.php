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
#[Title('Buat Pengajuan')]
class Create extends Component
{
    #[Rule('required|exists:users,id')]
    public string $id_user = '';

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
            'id_user' => $this->id_user,
            'id_barang' => $this->id_barang,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'jumlah' => $this->jumlah,
            'status' => 'pending',
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('swal', ['type' => 'success', 'message' => 'Pengajuan berhasil dibuat.']);

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
        $barangs = Barang::where('jumlah_tersedia', '>', 0)->get();

        return view('livewire.admin.pengajuan.create', [
            'users' => $users,
            'barangs' => $barangs,
        ]);
    }
}
