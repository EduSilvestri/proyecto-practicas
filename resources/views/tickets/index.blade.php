@extends('layouts.app')

@section('title', 'Mis Tickets')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Mis Tickets</h2>
    <a href="{{ route('tickets.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Ticket</a>

    @if(session('exito'))
        <p class="text-green-500">{{ session('exito') }}</p>
    @endif

    <table class="w-full mt-4 border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Título</th>
                <th class="border p-2">Estado</th>
                <th class="border p-2">Prioridad</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr class="border">
                    <td class="border p-2">{{ $ticket->titulo }}</td>
                    <td class="border p-2">{{ ucfirst($ticket->estado) }}</td>
                    <td class="border p-2">{{ ucfirst($ticket->prioridad) }}</td>
                    <td class="border p-2">
                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-500">Ver</a> |
                        <a href="{{ route('tickets.edit', $ticket) }}" class="text-yellow-500">Editar</a> |
                        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
