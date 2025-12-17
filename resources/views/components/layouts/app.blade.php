<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIPEBA' }} - Sistem Informasi Peminjaman Barang</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#2563EB',
                            hover: '#1E40AF',
                        },
                        secondary: '#64748B',
                        background: '#F8FAFC',
                        surface: '#FFFFFF',
                        'text-primary': '#0F172A',
                        'text-secondary': '#475569',
                        border: '#E2E8F0',
                        // Status colors
                        pending: '#F59E0B',
                        approved: '#16A34A',
                        rejected: '#DC2626',
                        returned: '#059669',
                        late: '#E11D48',
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    
    @livewireStyles
</head>
<body class="bg-background min-h-screen">
    {{ $slot }}
    
    @livewireScripts
    
    <script>
        // Listen for SweetAlert events from Livewire
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (data) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data[0].message || data.message,
                    confirmButtonColor: '#2563EB',
                    timer: 3000,
                    timerProgressBar: true,
                });
            });

            Livewire.on('swal:error', (data) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data[0].message || data.message,
                    confirmButtonColor: '#DC2626',
                });
            });

            Livewire.on('swal:confirm', (data) => {
                Swal.fire({
                    icon: 'warning',
                    title: data[0].title || 'Konfirmasi',
                    text: data[0].message || data.message,
                    showCancelButton: true,
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: '#64748B',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(data[0].action, { id: data[0].id });
                    }
                });
            });

            Livewire.on('swal:deleted', (data) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Terhapus!',
                    text: data[0].message || 'Data berhasil dihapus.',
                    confirmButtonColor: '#2563EB',
                    timer: 2000,
                    timerProgressBar: true,
                });
            });
        });

        // Check for session swal on page load
        @if(session('swal'))
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: '{{ session('swal.type') }}',
                    title: '{{ session('swal.type') === 'success' ? 'Berhasil!' : 'Error!' }}',
                    text: '{{ session('swal.message') }}',
                    confirmButtonColor: '{{ session('swal.type') === 'success' ? '#2563EB' : '#DC2626' }}',
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        @endif
    </script>
</body>
</html>

