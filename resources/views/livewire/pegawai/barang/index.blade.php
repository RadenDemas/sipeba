<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Portal Pegawai" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <h2 class="text-xl font-bold text-text-primary">Daftar Barang</h2>
        </header>

        <!-- Content -->
        <div class="p-8">
            <!-- Search -->
            <div class="mb-6">
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Cari nama atau kode barang..."
                    class="w-full max-w-md px-4 py-3 rounded-xl border border-border bg-surface text-text-primary placeholder-text-secondary/50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                >
            </div>

            <!-- Grid Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($barangs as $barang)
                    <div class="bg-surface rounded-2xl border border-border p-6 hover:border-primary/30 transition-colors">
                        <div class="flex items-start justify-between mb-4">
                            <span class="px-2 py-1 bg-primary/10 text-primary text-xs font-medium rounded-lg">
                                {{ $barang->kode_barang }}
                            </span>
                            @if($barang->jumlah_tersedia > 0)
                                <span class="px-2 py-1 bg-approved/10 text-approved text-xs font-medium rounded-lg">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-2 py-1 bg-rejected/10 text-rejected text-xs font-medium rounded-lg">
                                    Habis
                                </span>
                            @endif
                        </div>
                        <h3 class="font-semibold text-text-primary mb-2">{{ $barang->nama_barang }}</h3>
                        @if($barang->deskripsi)
                            <p class="text-sm text-text-secondary mb-4 line-clamp-2">{{ $barang->deskripsi }}</p>
                        @endif
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-text-secondary">Stok tersedia</span>
                            <span class="font-medium text-text-primary">{{ $barang->jumlah_tersedia }} / {{ $barang->jumlah_total }}</span>
                        </div>
                        @if($barang->jumlah_tersedia > 0)
                            <a href="{{ route('pegawai.pengajuan.create') }}" 
                               class="w-full mt-4 px-4 py-2 bg-primary hover:bg-primary-hover text-white text-center font-medium rounded-xl transition-colors block">
                                Ajukan Pinjam
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full bg-surface rounded-2xl border border-border p-12 text-center">
                        <p class="text-text-secondary">Tidak ada barang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $barangs->links() }}
            </div>
        </div>
    </main>
</div>
