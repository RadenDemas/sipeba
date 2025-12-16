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
</body>
</html>
