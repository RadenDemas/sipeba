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
            <h2 class="text-xl font-bold text-text-primary">Pengembalian Barang</h2>
        </header>

        <!-- Content -->
        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-approved/10 border border-approved/20 rounded-xl text-approved">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-rejected/10 border border-rejected/20 rounded-xl text-rejected">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search -->
            <div class="mb-6">
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Cari pemohon atau barang..."
                    class="w-full max-w-xs px-4 py-3 rounded-xl border border-border bg-surface text-text-primary placeholder-text-secondary/50 focus:outline-none focus:ring-2 focus:ring-primary"
                >
            </div>

            <!-- Table -->
            <div class="bg-surface rounded-2xl border border-border overflow-hidden">
                <table class="w-full">
                    <thead class="bg-background">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Peminjam</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Barang</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Jumlah</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Periode</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Status</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-text-primary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($dipinjam as $p)
                            @php
                                $isOverdue = \Carbon\Carbon::parse($p->date_end)->isPast();
                            @endphp
                            <tr class="hover:bg-background/50 transition-colors {{ $isOverdue ? 'bg-rejected/5' : '' }}">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-text-primary">{{ $p->user->name }}</p>
                                </td>
                                <td class="px-6 py-4 text-text-primary">{{ $p->barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-text-primary">{{ $p->jumlah }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <p class="text-text-secondary">{{ \Carbon\Carbon::parse($p->date_start)->format('d/m') }} - {{ \Carbon\Carbon::parse($p->date_end)->format('d/m/Y') }}</p>
                                    @if($isOverdue)
                                        <span class="text-rejected text-xs font-medium">Terlambat</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium capitalize bg-primary/10 text-primary">
                                        Dipinjam
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route($routePrefix . '.pengembalian.create', $p) }}" 
                                       class="px-3 py-2 bg-returned hover:bg-returned/90 text-white text-sm font-medium rounded-lg transition-colors">
                                        Proses Kembali
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-text-secondary">
                                    Tidak ada barang yang sedang dipinjam.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $dipinjam->links() }}
            </div>
        </div>
    </main>
</div>
