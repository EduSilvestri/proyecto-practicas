@extends('layouts.app')

@section('title', 'Mis Tickets')

@section('content')
<div class="flex flex-col items-center">
    <h2 class="text-2xl font-bold mb-4">Mis Tickets</h2>
    
    <!-- Caja del formulario con borde -->
    <div class="border bg-lujoNeg rounded p-4 w-[70%] mb-4">
      <!-- Formulario de búsqueda y filtrado -->
      <form method="GET" action="{{ route('tickets.index') }}">
        <div class="flex flex-wrap gap-4 justify-center">
          <!-- Buscar por asunto -->
          <div>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por asunto" class="border rounded p-2">
          </div>
          <!-- Filtrar por tipo -->
          <div>
            <select name="tipo" class="border rounded p-2">
              <option value="">Tipos</option>
              <option value="Preguntas generales" {{ request('tipo') == 'Preguntas generales' ? 'selected' : '' }}>Preguntas generales</option>
              <option value="Problemas de lanzamiento" {{ request('tipo') == 'Problemas de lanzamiento' ? 'selected' : '' }}>Problemas de lanzamiento</option>
              <option value="Problemas de Pagina Web" {{ request('tipo') == 'Problemas de Pagina Web' ? 'selected' : '' }}>Problemas de Pagina Web</option>
              <option value="Pagos" {{ request('tipo') == 'Pagos' ? 'selected' : '' }}>Pagos</option>
              <option value="Peticion de Actualizacion de Lanzamiento" {{ request('tipo') == 'Peticion de Actualizacion de Lanzamiento' ? 'selected' : '' }}>Peticion de Actualizacion de Lanzamiento</option>
              <option value="Peticion de Takedown" {{ request('tipo') == 'Peticion de Takedown' ? 'selected' : '' }}>Peticion de Takedown</option>
              <option value="Peticion de Copyright" {{ request('tipo') == 'Peticion de Copyright' ? 'selected' : '' }}>Peticion de Copyright</option>
            </select>
          </div>
          <!-- Filtrar por estado -->
          <div>
            <select name="estado" class="border rounded p-2">
              <option value="">Estados</option>
              <option value="abierto" {{ request('estado') == 'abierto' ? 'selected' : '' }}>Abierto</option>
              <option value="en_progreso" {{ request('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
              <option value="cerrado" {{ request('estado') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
          </div>
          <!-- Botón de búsqueda -->
          <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
          </div>
        </div>
      </form>
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
                          <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-500">Ver</a> |
                          <a href="{{ route('tickets.edit', $ticket) }}" class="text-yellow-500">Editar</a>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
    </div>
  </div>
@endsection

