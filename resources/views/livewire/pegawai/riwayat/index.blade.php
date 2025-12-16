<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Portal Pegawai" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <h2 class="text-xl font-bold text-text-primary">Riwayat Peminjaman</h2>
        </header>

        <!-- Content -->
        <div class="p-8">
            <!-- Filter -->
            <div class="mb-6">
                <select 
                    wire:model.live="filterStatus"
                    class="px-4 py-3 rounded-xl border border-border bg-surface text-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
                >
                    <option value="">Semua Riwayat</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <!-- Cards -->
            <div class="space-y-4">
                @forelse($riwayats as $r)
                    <div class="bg-surface rounded-2xl border border-border p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-semibold text-text-primary">{{ $r->barang->nama_barang }}</h3>
                                    @php
                                        $statusColors = [
                                            'selesai' => 'bg-returned/10 text-returned',
                                            'ditolak' => 'bg-rejected/10 text-rejected',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium capitalize {{ $statusColors[$r->status] ?? '' }}">
                                        {{ $r->status }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="text-text-secondary">Jumlah</p>
                                        <p class="text-text-primary font-medium">{{ $r->jumlah }} unit</p>
                                    </div>
                                    <div>
                                        <p class="text-text-secondary">Periode</p>
                                        <p class="text-text-primary font-medium">{{ \Carbon\Carbon::parse($r->date_start)->format('d M') }} - {{ \Carbon\Carbon::parse($r->date_end)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-text-secondary">Diajukan</p>
                                        <p class="text-text-primary font-medium">{{ $r->created_at->format('d M Y') }}</p>
                                    </div>
                                    @if($r->status === 'selesai' && $r->pengembalian)
                                        <div>
                                            <p class="text-text-secondary">Dikembalikan</p>
                                            <p class="text-text-primary font-medium">{{ \Carbon\Carbon::parse($r->pengembalian->tanggal_pengembalian)->format('d M Y') }}</p>
                                        </div>
                                    @endif
                                </div>
                                @if($r->keterangan)
                                    <p class="mt-2 text-sm text-text-secondary">{{ $r->keterangan }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-surface rounded-2xl border border-border p-12 text-center">
                        <p class="text-text-secondary">Belum ada riwayat peminjaman.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $riwayats->links() }}
            </div>
        </div>
    </main>
</div>
