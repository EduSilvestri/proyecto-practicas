@extends('layouts.app')

@section('title', 'Mis Tickets')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Mis Tickets</h2>

    @if(session('exito'))
        <p class="text-green-500">{{ session('exito') }}</p>
    @endif

    <table class="w-full mt-4 border-collapse border">
        <thead>
            <tr class="bg-lujoNeg text-white">
                <th class="border p-2">Asunto</th>
                <th class="border p-2">Estado</th>
                <th class="border p-2">Prioridad</th>
                <th class="border p-2">Tipo</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-gray-800 text-white">
            @foreach($tickets as $ticket)
                <tr class="border">
                    <td class="border p-2 text-center">{{ $ticket->asunto }}</td>
                    <td class="border p-2 text-center">{{ ucfirst($ticket->estado) }}</td>
                    <td class="border p-2 text-center">{{ ucfirst($ticket->prioridad) }}</td>
                    <td class="border p-2 text-center">{{ ucfirst($ticket->tipo) }}</td>
                    <td class="border p-2 text-center">
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