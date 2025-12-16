<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Panel Admin" />

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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-text-primary">{{ $totalUsers }}</p>
                            <p class="text-sm text-text-secondary">Total Pengguna</p>
                        </div>
                    </div>
                </div>

                <!-- Total Barangs -->
                <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-approved/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-approved" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-text-primary">{{ $totalBarangs }}</p>
                            <p class="text-sm text-text-secondary">Total Barang</p>
                        </div>
                    </div>
                </div>

                <!-- Total Pengajuans -->
                <div class="bg-surface rounded-2xl p-6 border border-border shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-text-primary">{{ $totalPengajuans }}</p>
                            <p class="text-sm text-text-secondary">Total Pengajuan</p>
                        </div>
                    </div>
                </div>

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
            </div>

            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-primary to-primary-hover rounded-2xl p-8 text-white">
                <h3 class="text-xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
                <p class="text-white/80">Anda login sebagai Administrator. Kelola pengguna, barang, dan pantau aktivitas peminjaman dari dashboard ini.</p>
            </div>
        </div>
    </main>
</div>
