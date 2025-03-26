@extends('layouts.app')

@section('title', 'Detalles del Ticket')

@section('content')
    <h2 class="text-2xl font-bold mb-4">{{ $ticket->asunto }}</h2>
    <p><strong>Descripción:</strong> {{ $ticket->descripcion }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($ticket->estado) }}</p>
    <p><strong>Prioridad:</strong> {{ ucfirst($ticket->prioridad) }}</p>
    <p><strong>Tipo:</strong> {{ ucfirst($ticket->tipo) }}</p>
    
    <!-- Sección para visualizar archivos adjuntos y capturas de pantalla -->
    @if($ticket->archivos)
        @php
            $files = json_decode($ticket->archivos, true);
        @endphp
        @if($files && count($files) > 0)
            <div class="mt-4">
                <h3 class="text-xl font-semibold">Archivos Adjuntos y Capturas de Pantalla</h3>
                <ul class="list-disc pl-5">
                    @foreach($files as $file)
                        <li class="mt-2">
                            @if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $file) }}" alt="Adjunto" style="max-width: 200px;" class="mb-2">
                            @else
                                <a href="{{ asset('storage/' . $file) }}" target="_blank">{{ $file }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="mt-4">No hay archivos adjuntos.</p>
        @endif
    @else
        <p class="mt-4">No hay archivos adjuntos.</p>
    @endif

    <a href="{{ route('tickets.index') }}" class="text-blue-500 mt-4 inline-block">Volver a la lista</a>
@endsection


