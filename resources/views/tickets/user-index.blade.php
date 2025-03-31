@extends('layouts.app')

@section('title', 'Mis Tickets')

@section('content')
    <h2 class="text-2xl font-bold mb-4 text-center mt-5">Mis Tickets</h2>

    @if(session('exito'))
        <p class="text-green-500">{{ session('exito') }}</p>
    @endif

    @if(Auth::user()->isUser())
    <table class="w-full mt-4 border-collapse border">
        <thead>
            <tr class="bg-lujoNeg text-white">
                <th class="border p-2">Asunto</th>
                <th class="border p-2">Estado</th>
                <th class="border p-2">Tipo</th>
                <th class="border p-2">Fecha de Creación</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-gray-800 text-white">
            @foreach($tickets as $ticket)
                <tr class="border">
                    <td class="border p-2 text-center">{{ $ticket->asunto }}</td>
                    <td class="border p-2 text-center">{{ ucfirst($ticket->estado) }}</td>
                    <td class="border p-2 text-center">{{ ucfirst($ticket->tipo) }}</td>
                    <td class="border p-2 text-center">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    <td class="border p-2 text-center">
                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-500">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

@endsection


