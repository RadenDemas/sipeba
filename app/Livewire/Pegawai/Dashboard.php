<?php

namespace App\Livewire\Pegawai;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Pengajuan;

#[Layout('components.layouts.app')]
#[Title('Dashboard Pegawai')]
class Dashboard extends Component
{
    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('login');
    }

    public function render()
    {
        $userId = auth()->id();
        
        return view('livewire.pegawai.dashboard', [
            'myPengajuans' => Pengajuan::where('id_user', $userId)->count(),
            'myPending' => Pengajuan::where('id_user', $userId)->where('status', 'pending')->count(),
            'myDipinjam' => Pengajuan::where('id_user', $userId)->where('status', 'dipinjam')->count(),
        ]);
    }
}

