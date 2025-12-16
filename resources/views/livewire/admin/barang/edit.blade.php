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
                <a href="{{ route($routePrefix . '.barang.index') }}" class="p-2 text-text-secondary hover:text-text-primary hover:bg-background rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-text-primary">Edit Barang</h2>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8">
            <div class="max-w-2xl">
                <form wire:submit="save" class="bg-surface rounded-2xl border border-border p-8 space-y-6">
                    <!-- Kode Barang -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Kode Barang</label>
                        <input 
                            wire:model="kode_barang"
                            type="text" 
                            class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                        @error('kode_barang')
                            <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Barang -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Nama Barang</label>
                        <input 
                            wire:model="nama_barang"
                            type="text" 
                            class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                        @error('nama_barang')
                            <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Deskripsi (Opsional)</label>
                        <textarea 
                            wire:model="deskripsi"
                            rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                        ></textarea>
                        @error('deskripsi')
                            <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Jumlah Total</label>
                        <input 
                            wire:model="jumlah_total"
                            type="number" 
                            min="0"
                            class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                        <p class="mt-1 text-sm text-text-secondary">Stok tersedia saat ini: {{ $barang->jumlah_tersedia }}</p>
                        @error('jumlah_total')
                            <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" 
                                class="px-6 py-3 bg-primary hover:bg-primary-hover text-white font-medium rounded-xl transition-colors"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-70">
                            <span wire:loading.remove>Simpan Perubahan</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                        <a href="{{ route($routePrefix . '.barang.index') }}" 
                           class="px-6 py-3 bg-background hover:bg-border text-text-secondary font-medium rounded-xl transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
