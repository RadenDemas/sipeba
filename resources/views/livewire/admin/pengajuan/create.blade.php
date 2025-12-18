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
                <h2 class="text-xl font-bold text-text-primary">Buat Pengajuan Baru</h2>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8">
            <div class="max-w-2xl">
                <form wire:submit="save" class="bg-surface rounded-2xl border border-border p-8 space-y-6">
                    <!-- User (Pemohon) -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Pilih Pegawai</label>
                        <select 
                            wire:model="id_user"
                            class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
                        >
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Barang -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Pilih Barang</label>
                        <select 
                            wire:model="id_barang"
                            class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
                        >
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}">
                                    {{ $barang->nama_barang }} (Tersedia: {{ $barang->jumlah_tersedia }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_barang')
                            <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Jumlah</label>
                        <input 
                            wire:model="jumlah"
                            type="number" 
                            min="1"
                            class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
                        >
                        @error('jumlah')
                            <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-text-primary mb-2">Tanggal Mulai</label>
                            <input 
                                wire:model="date_start"
                                type="date"
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
                            >
                            @error('date_start')
                                <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary mb-2">Tanggal Selesai</label>
                            <input 
                                wire:model="date_end"
                                type="date"
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
                            >
                            @error('date_end')
                                <p class="mt-2 text-sm text-rejected">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Keterangan (Opsional)</label>
                        <textarea 
                            wire:model="keterangan"
                            rows="3"
                            placeholder="Tujuan peminjaman..."
                            class="w-full px-4 py-3 rounded-xl border border-border bg-background text-text-primary placeholder-text-secondary/50 focus:outline-none focus:ring-2 focus:ring-primary resize-none"
                        ></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" 
                                class="px-6 py-3 bg-primary hover:bg-primary-hover text-white font-medium rounded-xl transition-colors"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-70">
                            <span wire:loading.remove>Simpan</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                        <a href="{{ route('admin.pengajuan.index') }}" 
                           class="px-6 py-3 bg-background hover:bg-border text-text-secondary font-medium rounded-xl transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
