<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Panel Admin" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <h2 class="text-xl font-bold text-text-primary">Data Pengembalian</h2>
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

            <!-- Filters -->
            <div class="flex flex-wrap gap-4 mb-6">
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Cari peminjam atau barang..."
                    class="w-full max-w-xs px-4 py-3 rounded-xl border border-border bg-surface text-text-primary placeholder-text-secondary/50 focus:outline-none focus:ring-2 focus:ring-primary"
                >
                <select 
                    wire:model.live="filterStatus"
                    class="px-4 py-3 rounded-xl border border-border bg-surface text-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
                >
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="dikembalikan">Dikembalikan</option>
                </select>
            </div>

            <!-- Table -->
            <div class="bg-surface rounded-2xl border border-border overflow-hidden">
                <table class="w-full">
                    <thead class="bg-background">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Peminjam</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Barang</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Jumlah</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Tanggal</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Diproses Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($pengembalians as $p)
                            <tr class="hover:bg-background/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-text-primary">{{ $p->pengajuan->user->name }}</p>
                                    <p class="text-sm text-text-secondary">{{ $p->pengajuan->user->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-text-primary">{{ $p->pengajuan->barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-text-primary">{{ $p->pengajuan->jumlah }}</td>
                                <td class="px-6 py-4 text-sm text-text-secondary">
                                    <p>Request: {{ $p->created_at->format('d/m/Y H:i') }}</p>
                                    @if($p->verified_at)
                                        <p class="text-returned">Verified: {{ $p->verified_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-pending/10 text-pending',
                                            'dikembalikan' => 'bg-returned/10 text-returned',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium capitalize {{ $statusColors[$p->status] ?? '' }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-text-primary">
                                    @if($p->petugas)
                                        {{ $p->petugas->name }}
                                    @else
                                        <span class="text-text-secondary">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-text-secondary">
                                    Tidak ada data pengembalian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $pengembalians->links() }}
            </div>
        </div>
    </main>
</div>
