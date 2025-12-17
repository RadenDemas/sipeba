<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Portal Pegawai" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <h2 class="text-xl font-bold text-text-primary">Pengembalian Barang</h2>
        </header>

        <!-- Content -->
        <div class="p-8">
            <!-- Info Card -->
            <div class="mb-6 p-4 bg-primary/10 border border-primary/20 rounded-xl">
                <p class="text-primary text-sm">
                    <strong>Info:</strong> Request pengembalian akan diverifikasi oleh petugas gudang. 
                    Anda juga dapat langsung mengembalikan barang ke petugas tanpa membuat request.
                </p>
            </div>

            <!-- Cards -->
            <div class="space-y-4">
                @forelse($pengajuans as $p)
                    @php
                        $isOverdue = \Carbon\Carbon::parse($p->date_end)->isPast();
                        $hasPendingReturn = $p->pengembalian && $p->pengembalian->status === 'pending';
                    @endphp
                    <div class="bg-surface rounded-2xl border border-border p-6 {{ $isOverdue ? 'ring-2 ring-rejected/30' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-semibold text-text-primary">{{ $p->barang->nama_barang }}</h3>
                                    @if($hasPendingReturn)
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-pending/10 text-pending">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($isOverdue)
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-rejected/10 text-rejected">
                                            Terlambat {{ \Carbon\Carbon::parse($p->date_end)->diffInDays(now()) }} hari
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                            Dipinjam
                                        </span>
                                    @endif
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="text-text-secondary">Jumlah</p>
                                        <p class="text-text-primary font-medium">{{ $p->jumlah }} unit</p>
                                    </div>
                                    <div>
                                        <p class="text-text-secondary">Mulai</p>
                                        <p class="text-text-primary font-medium">{{ \Carbon\Carbon::parse($p->date_start)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-text-secondary">Batas Kembali</p>
                                        <p class="text-text-primary font-medium {{ $isOverdue ? 'text-rejected' : '' }}">{{ \Carbon\Carbon::parse($p->date_end)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-text-secondary">Disetujui</p>
                                        <p class="text-text-primary font-medium">{{ $p->approved_at ? $p->approved_at->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                                @if($hasPendingReturn)
                                    <p class="mt-3 text-sm text-pending">
                                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Request pengembalian dikirim {{ $p->pengembalian->created_at->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                            <div class="ml-4">
                                @if($hasPendingReturn)
                                    <button 
                                        wire:click="cancelReturn({{ $p->id }})"
                                        wire:confirm="Batalkan request pengembalian?"
                                        class="px-4 py-2 text-sm text-rejected hover:bg-rejected/10 rounded-lg transition-colors"
                                    >
                                        Batalkan
                                    </button>
                                @else
                                    <button 
                                        wire:click="requestReturn({{ $p->id }})"
                                        wire:confirm="Ajukan request pengembalian barang ini?"
                                        class="px-4 py-2 bg-returned hover:bg-returned/90 text-white text-sm font-medium rounded-lg transition-colors"
                                    >
                                        Request Pengembalian
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-surface rounded-2xl border border-border p-12 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-text-secondary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="text-text-secondary">Tidak ada barang yang sedang dipinjam.</p>
                        <a href="{{ route('pegawai.pengajuan.create') }}" class="inline-block mt-4 text-primary hover:underline">
                            Ajukan peminjaman baru
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $pengajuans->links() }}
            </div>
        </div>
    </main>
</div>
