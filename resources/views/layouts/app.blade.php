<!DOCTYPE html>
<html wire:navigate lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-lujoYel">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content') {{-- {{ $slot }} --}}
            </main>
        </div>

        @stack('modals')
        @stack('scripts')
        @livewireScripts
        <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('showTicketIndex', () => {
                // 1. Actualizar URL sin recargar
                history.pushState({}, '', '{{ route("tickets.index") }}');
                
                // 2. Cargar el componente de lista
                Livewire.dispatch('load-component', {
                    component: 'ticket-index',
                    target: 'dynamic-content'
                });
            });
        });
    </script>
    </body>
</html>