<div class="min-h-screen bg-background">
    @php
        $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'petugas';
        $subtitle = auth()->user()->isAdmin() ? 'Panel Admin' : 'Panel Petugas';
    @endphp

    <!-- Sidebar -->
    <x-sidebar :subtitle="$subtitle" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <div class="flex items-center gap-4">
                <a href="{{ route($routePrefix . '.pengembalian.index') }}" class="p-2 text-text-secondary hover:text-text-primary hover:bg-background rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-text-primary">Proses Pengembalian</h2>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8">
            <div class="max-w-3xl">
                <div class="bg-surface rounded-2xl border border-border p-8">
                    <!-- Pengajuan Info -->
                    <div class="mb-6 pb-6 border-b border-border">
                        <h3 class="text-lg font-semibold text-text-primary mb-4">Informasi Peminjaman</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-text-secondary">Peminjam</p>
                                <p class="font-medium text-text-primary">{{ $pengajuan->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-text-secondary">Email</p>
                                <p class="font-medium text-text-primary">{{ $pengajuan->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-text-secondary">Barang</p>
                                <p class="font-medium text-text-primary">{{ $pengajuan->barang->nama_barang }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-text-secondary">Jumlah</p>
                                <p class="font-medium text-text-primary">{{ $pengajuan->jumlah }} unit</p>
                            </div>
                            <div>
                                <p class="text-sm text-text-secondary">Periode</p>
                                <p class="font-medium text-text-primary">
                                    {{ \Carbon\Carbon::parse($pengajuan->date_start)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($pengajuan->date_end)->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-text-secondary">Status</p>
                                @php
                                    $isOverdue = \Carbon\Carbon::parse($pengajuan->date_end)->isPast();
                                @endphp
                                @if($isOverdue)
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-rejected/10 text-rejected">
                                        Terlambat {{ \Carbon\Carbon::parse($pengajuan->date_end)->diffInDays(now()) }} hari
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-approved/10 text-approved">
                                        Tepat Waktu
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit="save" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-text-primary mb-2">Keterangan (Opsional)</label>
                            <textarea 
                                wire:model="keterangan"
                                rows="3"
                                placeholder="Catatan pengembalian, kondisi barang, dll..."
                                class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary placeholder-text-secondary/50 focus:outline-none focus:ring-2 focus:ring-primary resize-none"
                            ></textarea>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" 
                                    wire:confirm="Konfirmasi pengembalian barang ini?"
                                    class="px-6 py-3 bg-returned hover:bg-returned/90 text-white font-medium rounded-xl transition-colors"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-70">
                                <span wire:loading.remove>Konfirmasi Pengembalian</span>
                                <span wire:loading>Memproses...</span>
                            </button>
                            <a href="{{ route($routePrefix . '.pengembalian.index') }}" 
                               class="px-6 py-3 bg-background hover:bg-border text-text-secondary font-medium rounded-xl transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
