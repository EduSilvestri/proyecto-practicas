@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white rounded-lg shadow-lg">
    <h1 class="text-2xl font-semibold mb-4">Detalles del Ticket</h1>
    
    <!-- Componente Livewire -->
    @livewire('ticket-show', ['ticket' => $ticket])
    
    <div class="mt-6">
        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition">
            Volver a la lista de tickets
        </a>
    </div>
</div>
@endsection
