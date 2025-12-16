<div class="min-h-screen bg-background">
    <!-- Header -->
    <header class="bg-surface border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-text-primary">SIPEBA</h1>
                        <p class="text-xs text-text-secondary">Portal Pegawai</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-text-secondary">{{ auth()->user()->name }}</span>
                    <span class="px-2 py-1 text-xs font-medium bg-secondary/10 text-secondary rounded-full">Pegawai</span>
                    <button wire:click="logout" class="text-sm text-text-secondary hover:text-rejected transition-colors">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold text-text-primary mb-6">Dashboard</h2>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- My Pengajuans -->
            <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-text-primary">{{ $myPengajuans }}</p>
                        <p class="text-sm text-text-secondary">Total Pengajuan Saya</p>
                    </div>
                </div>
            </div>

            <!-- My Pending -->
            <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-pending/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-pending" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-text-primary">{{ $myPending }}</p>
                        <p class="text-sm text-text-secondary">Menunggu Persetujuan</p>
                    </div>
                </div>
            </div>

            <!-- My Borrowed -->
            <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-approved/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-approved" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-text-primary">{{ $myDipinjam }}</p>
                        <p class="text-sm text-text-secondary">Sedang Dipinjam</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-primary to-primary-hover rounded-2xl p-8 text-white">
            <h3 class="text-xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p class="text-white/80">Anda dapat mengajukan peminjaman barang, melihat status pengajuan, dan riwayat peminjaman dari portal ini.</p>
        </div>
    </main>
</div>
