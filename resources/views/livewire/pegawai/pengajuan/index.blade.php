<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Portal Pegawai" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <h2 class="text-xl font-bold text-text-primary">Pengajuan Saya</h2>
            <a href="{{ route('pegawai.pengajuan.create') }}" 
               class="px-4 py-2 bg-primary hover:bg-primary-hover text-white font-medium rounded-xl transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Ajukan Baru
            </a>
        </header>

        <!-- Content -->
        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-approved/10 border border-approved/20 rounded-xl text-approved">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter -->
            <div class="mb-6">
                <select 
                    wire:model.live="filterStatus"
                    class="px-4 py-3 rounded-xl border border-border bg-surface text-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
                >
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <!-- Cards -->
            <div class="space-y-4">
                @forelse($pengajuans as $p)
                    <div class="bg-surface rounded-2xl border border-border p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-semibold text-text-primary">{{ $p->barang->nama_barang }}</h3>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-pending/10 text-pending',
                                            'disetujui' => 'bg-approved/10 text-approved',
                                            'ditolak' => 'bg-rejected/10 text-rejected',
                                            'dipinjam' => 'bg-primary/10 text-primary',
                                            'selesai' => 'bg-returned/10 text-returned',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium capitalize {{ $statusColors[$p->status] ?? '' }}">
                                        {{ $p->status }}
                                    </span>
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
                                        <p class="text-text-secondary">Selesai</p>
                                        <p class="text-text-primary font-medium">{{ \Carbon\Carbon::parse($p->date_end)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-text-secondary">Diajukan</p>
                                        <p class="text-text-primary font-medium">{{ $p->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                @if($p->keterangan)
                                    <p class="mt-2 text-sm text-text-secondary">{{ $p->keterangan }}</p>
                                @endif
                            </div>
                            @if($p->status === 'pending')
                                <button wire:click="cancel({{ $p->id }})" 
                                        wire:confirm="Yakin ingin membatalkan pengajuan ini?"
                                        class="px-3 py-2 text-sm text-rejected hover:bg-rejected/10 rounded-lg transition-colors">
                                    Batalkan
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-surface rounded-2xl border border-border p-12 text-center">
                        <p class="text-text-secondary">Belum ada pengajuan.</p>
                        <a href="{{ route('pegawai.pengajuan.create') }}" class="inline-block mt-4 text-primary hover:underline">
                            Buat pengajuan pertama
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
