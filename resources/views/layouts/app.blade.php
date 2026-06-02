<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ruaya Space Coffee') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
<body x-data="{ sidebarOpen: false }" class="font-sans antialiased text-slate-900">
    <div class="min-h-screen flex bg-[linear-gradient(180deg,#f8fafc,white)]">
        @unless(request()->routeIs('kasir.*'))
            @include('components.sidebar')
        @endunless
        <div class="flex-1 min-h-screen flex flex-col">
            @include('components.navbar')
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="max-w-screen-xl w-full mx-auto">
                    @include('components.reorder-alert')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @if(session('success'))
        <script>
            Swal.fire({icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false});
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 3500, showConfirmButton: false});
        </script>
    @endif
    @stack('scripts')
</body>
</html>
