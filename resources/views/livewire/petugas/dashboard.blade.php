<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Panel Petugas" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <h2 class="text-xl font-bold text-text-primary">Dashboard</h2>
            <div class="flex items-center gap-2">
                <span class="text-sm text-text-secondary">{{ now()->format('l, d F Y') }}</span>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Pending -->
                <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-pending/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-pending" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-text-primary">{{ $pendingPengajuans }}</p>
                            <p class="text-sm text-text-secondary">Menunggu Persetujuan</p>
                        </div>
                    </div>
                </div>

                <!-- Approved Today -->
                <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-approved/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-approved" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-text-primary">{{ $approvedToday }}</p>
                            <p class="text-sm text-text-secondary">Disetujui Hari Ini</p>
                        </div>
                    </div>
                </div>

                <!-- Currently Borrowed -->
                <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-text-primary">{{ $dipinjam }}</p>
                            <p class="text-sm text-text-secondary">Sedang Dipinjam</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-approved to-returned rounded-2xl p-8 text-white">
                <h3 class="text-xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
                <p class="text-white/80">Anda login sebagai Petugas Gudang. Kelola pengajuan peminjaman dan pantau pengembalian barang dari dashboard ini.</p>
            </div>
        </div>
    </main>
</div>
