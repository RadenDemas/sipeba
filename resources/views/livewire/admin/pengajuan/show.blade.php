<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Panel Admin" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.pengajuan.index') }}" class="p-2 text-text-secondary hover:text-text-primary hover:bg-background rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-text-primary">Detail Pengajuan</h2>
            </div>
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

            <div class="max-w-3xl">
                <div class="bg-surface rounded-2xl border border-border p-8">
                    <!-- Status Badge -->
                    <div class="flex items-center justify-between mb-6">
                        @php
                            $statusColors = [
                                'pending' => 'bg-pending/10 text-pending',
                                'ditolak' => 'bg-rejected/10 text-rejected',
                                'dipinjam' => 'bg-primary/10 text-primary',
                                'selesai' => 'bg-returned/10 text-returned',
                            ];
                        @endphp
                        <span class="px-4 py-2 rounded-full text-sm font-medium capitalize {{ $statusColors[$pengajuan->status] ?? '' }}">
                            Status: {{ $pengajuan->status }}
                        </span>
                        <span class="text-sm text-text-secondary">
                            Diajukan {{ $pengajuan->created_at->format('d M Y H:i') }}
                        </span>
                    </div>

                    <!-- Pemohon Info -->
                    <div class="mb-6 pb-6 border-b border-border">
                        <h3 class="text-sm font-medium text-text-secondary mb-2">Pemohon</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                <span class="text-primary font-semibold">{{ strtoupper(substr($pengajuan->user->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-text-primary">{{ $pengajuan->user->name }}</p>
                                <p class="text-sm text-text-secondary">{{ $pengajuan->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Barang Info -->
                    <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b border-border">
                        <div>
                            <h3 class="text-sm font-medium text-text-secondary mb-1">Barang</h3>
                            <p class="text-text-primary font-medium">{{ $pengajuan->barang->nama_barang }}</p>
                            <p class="text-sm text-text-secondary">Kode: {{ $pengajuan->barang->kode_barang }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-text-secondary mb-1">Jumlah</h3>
                            <p class="text-text-primary font-medium">{{ $pengajuan->jumlah }} unit</p>
                            <p class="text-sm text-text-secondary">Tersedia: {{ $pengajuan->barang->jumlah_tersedia }}</p>
                        </div>
                    </div>

                    <!-- Periode -->
                    <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b border-border">
                        <div>
                            <h3 class="text-sm font-medium text-text-secondary mb-1">Tanggal Mulai</h3>
                            <p class="text-text-primary font-medium">{{ \Carbon\Carbon::parse($pengajuan->date_start)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-text-secondary mb-1">Tanggal Selesai</h3>
                            <p class="text-text-primary font-medium">{{ \Carbon\Carbon::parse($pengajuan->date_end)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    @if($pengajuan->keterangan)
                        <div class="mb-6 pb-6 border-b border-border">
                            <h3 class="text-sm font-medium text-text-secondary mb-1">Keterangan</h3>
                            <p class="text-text-primary">{{ $pengajuan->keterangan }}</p>
                        </div>
                    @endif

                    <!-- Petugas Info (if approved) -->
                    @if($pengajuan->petugas)
                        <div class="mb-6 pb-6 border-b border-border">
                            <h3 class="text-sm font-medium text-text-secondary mb-1">Diproses Oleh</h3>
                            <p class="text-text-primary font-medium">{{ $pengajuan->petugas->name }}</p>
                            @if($pengajuan->approved_at)
                                <p class="text-sm text-text-secondary">Pada {{ $pengajuan->approved_at->format('d M Y H:i') }}</p>
                            @endif
                        </div>
                    @endif

                    <!-- Pengembalian Info -->
                    @if($pengajuan->pengembalian)
                        <div class="mb-6 pb-6 border-b border-border">
                            <h3 class="text-sm font-medium text-text-secondary mb-1">Pengembalian</h3>
                            <p class="text-text-primary font-medium capitalize">Status: {{ $pengajuan->pengembalian->status }}</p>
                            @if($pengajuan->pengembalian->verified_at)
                                <p class="text-sm text-text-secondary">Dikembalikan {{ $pengajuan->pengembalian->verified_at->format('d M Y H:i') }}</p>
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons (CRUD only, no approve/reject) -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.pengajuan.edit', $pengajuan) }}" 
                           class="px-6 py-3 bg-pending hover:bg-pending/90 text-white font-medium rounded-xl transition-colors">
                            Edit
                        </a>
                        <button wire:click="delete" 
                                wire:confirm="Yakin ingin menghapus pengajuan ini?"
                                class="px-6 py-3 bg-rejected hover:bg-rejected/90 text-white font-medium rounded-xl transition-colors">
                            Hapus
                        </button>
                        <a href="{{ route('admin.pengajuan.index') }}" 
                           class="px-6 py-3 bg-background hover:bg-border text-text-secondary font-medium rounded-xl transition-colors">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
