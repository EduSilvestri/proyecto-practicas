@extends('layouts.app')

@section('title', 'Detalles del Ticket')

@section('content')
    <h2 class="text-2xl font-bold mb-4">{{ $ticket->titulo }}</h2>
    <p><strong>Descripción:</strong> {{ $ticket->descripcion }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($ticket->estado) }}</p>
    <p><strong>Prioridad:</strong> {{ ucfirst($ticket->prioridad) }}</p>
    <a href="{{ route('tickets.index') }}" class="text-blue-500">Volver a la lista</a>
@endsection
