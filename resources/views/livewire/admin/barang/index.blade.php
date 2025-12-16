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
            <h2 class="text-xl font-bold text-text-primary">Kelola Barang</h2>
            <a href="{{ route($routePrefix . '.barang.create') }}" 
               class="px-4 py-2 bg-primary hover:bg-primary-hover text-white font-medium rounded-xl transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Barang
            </a>
        </header>

        <!-- Content -->
        <div class="p-8">
            <!-- Flash Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-approved/10 border border-approved/20 rounded-xl text-approved">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search -->
            <div class="mb-6">
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Cari nama atau kode barang..."
                    class="w-full max-w-md px-4 py-3 rounded-xl border border-border bg-surface text-text-primary placeholder-text-secondary/50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                >
            </div>

            <!-- Table -->
            <div class="bg-surface rounded-2xl border border-border overflow-hidden">
                <table class="w-full">
                    <thead class="bg-background">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Kode</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Nama Barang</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Total</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Tersedia</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-text-primary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($barangs as $barang)
                            <tr class="hover:bg-background/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-primary/10 text-primary text-sm font-medium rounded-lg">
                                        {{ $barang->kode_barang }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-text-primary">{{ $barang->nama_barang }}</p>
                                    @if($barang->deskripsi)
                                        <p class="text-sm text-text-secondary truncate max-w-xs">{{ $barang->deskripsi }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-text-primary">{{ $barang->jumlah_total }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-lg text-sm font-medium {{ $barang->jumlah_tersedia > 0 ? 'bg-approved/10 text-approved' : 'bg-rejected/10 text-rejected' }}">
                                        {{ $barang->jumlah_tersedia }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route($routePrefix . '.barang.edit', $barang) }}" 
                                           class="p-2 text-text-secondary hover:text-primary hover:bg-primary/10 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button wire:click="delete({{ $barang->id }})" 
                                                wire:confirm="Yakin ingin menghapus barang ini?"
                                                class="p-2 text-text-secondary hover:text-rejected hover:bg-rejected/10 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-text-secondary">
                                    Tidak ada data barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $barangs->links() }}
            </div>
        </div>
    </main>
</div>
