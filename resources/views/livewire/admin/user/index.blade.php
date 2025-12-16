<div class="min-h-screen bg-background">
    <!-- Sidebar -->
    <x-sidebar subtitle="Panel Admin" />

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-8">
            <h2 class="text-xl font-bold text-text-primary">Kelola Pengguna</h2>
            <a href="{{ route('admin.user.create') }}" 
               class="px-4 py-2 bg-primary hover:bg-primary-hover text-white font-medium rounded-xl transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Pengguna
            </a>
        </header>

        <!-- Content -->
        <div class="p-8">
            <!-- Flash Messages -->
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
                    placeholder="Cari nama atau email..."
                    class="w-full max-w-xs px-4 py-3 rounded-xl border border-border bg-surface text-text-primary placeholder-text-secondary/50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                >
                <select 
                    wire:model.live="filterRole"
                    class="px-4 py-3 rounded-xl border border-border bg-surface text-text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                >
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="pegawai">Pegawai</option>
                </select>
            </div>

            <!-- Table -->
            <div class="bg-surface rounded-2xl border border-border overflow-hidden">
                <table class="w-full">
                    <thead class="bg-background">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Nama</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-text-primary">Role</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-text-primary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($users as $user)
                            <tr class="hover:bg-background/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                            <span class="text-primary font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                        </div>
                                        <span class="font-medium text-text-primary">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-text-secondary">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $roleColors = [
                                            'admin' => 'bg-primary/10 text-primary',
                                            'petugas' => 'bg-approved/10 text-approved',
                                            'pegawai' => 'bg-secondary/10 text-secondary',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm font-medium capitalize {{ $roleColors[$user->role] ?? '' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.user.edit', $user) }}" 
                                           class="p-2 text-text-secondary hover:text-primary hover:bg-primary/10 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <button wire:click="delete({{ $user->id }})" 
                                                    wire:confirm="Yakin ingin menghapus pengguna ini?"
                                                    class="p-2 text-text-secondary hover:text-rejected hover:bg-rejected/10 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-text-secondary">
                                    Tidak ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </main>
</div>
