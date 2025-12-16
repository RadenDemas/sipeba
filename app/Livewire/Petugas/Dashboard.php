<?php

namespace App\Livewire\Petugas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Pengajuan;

#[Layout('components.layouts.app')]
#[Title('Dashboard Petugas')]
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
        return view('livewire.petugas.dashboard', [
            'pendingPengajuans' => Pengajuan::where('status', 'pending')->count(),
            'approvedToday' => Pengajuan::where('status', 'disetujui')
                ->whereDate('approved_at', today())->count(),
            'dipinjam' => Pengajuan::where('status', 'dipinjam')->count(),
        ]);
    }
}

