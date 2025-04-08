<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout> -->

<div>
    @include('layouts.navigation')
    
    <div class="min-h-screen bg-gray-100">
        <div id="dynamic-content">
            <!-- Aquí se cargarán los componentes dinámicamente -->
            @if(request()->routeIs('tickets.index'))
                <livewire:ticket-index />
            @elseif(request()->routeIs('tickets.show'))
                <livewire:ticket-show :ticket="$ticket" />
            @endif
        </div>
    </div>
</div>
