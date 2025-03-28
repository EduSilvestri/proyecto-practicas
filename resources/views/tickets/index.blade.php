@extends('layouts.app')

@section('title', 'Mis Tickets')

@section('content')
<div class="flex flex-col items-center">
    <h2 class="mt-5 text-2xl font-bold mb-4">Mis Tickets</h2>
    
    <!-- Caja del formulario con borde -->
    <div class="bg-lujoNeg rounded p-4 mb-4">
      <!-- Formulario de búsqueda y filtrado -->
      <form method="GET" action="{{ route('tickets.index') }}">
        <div class="flex flex-wrap gap-4 justify-center">
          <!-- Buscar por asunto -->
          <div>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por asunto" class="border rounded p-2">
          </div>
          <!-- Botón de búsqueda -->
          <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
          </div>
        </div>
      </form>
    </div>

    <div class="flex flex-wrap gap-4 justify-center">
    <div>
      <form action="{{ route('tickets.index') }}" method="GET">
        <input type="hidden" name="estado" value="">
        <button type="submit" class="bg-lujoNeg text-white px-4 py-2 rounded">Todos los tickets</button>
      </form>
      </div>
      <div>
      <form action="{{ route('tickets.index') }}" method="GET">
        <input type="hidden" name="estado" value="abierto">
        <button type="submit" class="bg-lujoNeg text-white px-4 py-2 rounded">Tickets abiertos</button>
      </form>
      </div>
      <div>
      <form method="GET" action="{{ route('tickets.index') }}">
      <input type="hidden" name="estado" value="en_progreso">
        <button type="submit" class="bg-lujoNeg text-white px-4 py-2 rounded">Tickets en progreso</button>
      </form>
      </div>
      <div>
      <form method="GET" action="{{ route('tickets.index') }}">
      <input type="hidden" name="estado" value="cerrado">
        <button type="submit" class="bg-lujoNeg text-white px-4 py-2 rounded">Tickets cerrados</button>
      </form>
      </div>
    </div>
    
    <!-- Aquí iría la tabla debajo de la caja -->
    <div class="w-full max-w-4xl">
      <!-- Tabla de datos -->
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
                  <th class="border p-2">Fecha de Creación</th>
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
                      <td class="border p-2 text-center">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                      <td class="border p-2 text-center">
                          <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-500">Ver</a>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
    </div>
  </div>
@endsection

