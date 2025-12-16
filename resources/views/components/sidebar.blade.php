<aside class="fixed inset-y-0 left-0 w-64 bg-surface border-r border-border flex flex-col z-50">
    <!-- Logo -->
    <div class="h-16 flex items-center gap-3 px-6 border-b border-border">
        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-text-primary">SIPEBA</h1>
            <p class="text-xs text-text-secondary">{{ $subtitle ?? 'Dashboard' }}</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-text-secondary hover:bg-background hover:text-text-primary' }} transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-background hover:text-text-primary transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <span class="font-medium">Pengguna</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-background hover:text-text-primary transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">Barang</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-background hover:text-text-primary transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="font-medium">Laporan</span>
            </a>
        @elseif(auth()->user()->isPetugas())
            <a href="{{ route('petugas.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('petugas.dashboard') ? 'bg-primary text-white' : 'text-text-secondary hover:bg-background hover:text-text-primary' }} transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-background hover:text-text-primary transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span class="font-medium">Pengajuan</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-background hover:text-text-primary transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
                </svg>
                <span class="font-medium">Pengembalian</span>
            </a>
        @else
            <a href="{{ route('pegawai.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('pegawai.dashboard') ? 'bg-primary text-white' : 'text-text-secondary hover:bg-background hover:text-text-primary' }} transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-background hover:text-text-primary transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">Daftar Barang</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-background hover:text-text-primary transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="font-medium">Ajukan Pinjaman</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary hover:bg-background hover:text-text-primary transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">Riwayat Saya</span>
            </a>
        @endif
    </nav>

    <!-- User Section -->
    <div class="p-4 border-t border-border">
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-background">
            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                <span class="text-primary font-semibold text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-text-primary truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-text-secondary capitalize">{{ auth()->user()->role }}</p>
            </div>
        </div>
        <button wire:click="logout" class="w-full mt-3 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-rejected hover:bg-rejected/10 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span class="font-medium">Logout</span>
        </button>
    </div>
</aside>
