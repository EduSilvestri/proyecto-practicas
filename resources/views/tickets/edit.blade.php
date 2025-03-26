@extends('layouts.app')

@section('title', 'Editar Ticket')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Editar Ticket</h2>

    @if ($errors->any())
        <div class="bg-red-200 text-red-600 p-2 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $ticket->titulo) }}" class="border rounded p-2 w-full" required>
        </div>
        <div>
            <label class="block">Descripción</label>
            <textarea name="descripcion" rows="4" class="border rounded p-2 w-full" required>{{ old('descripcion', $ticket->descripcion) }}</textarea>
        </div>
        <div>
            <label class="block">Estado</label>
            <select name="estado" class="border rounded p-2 w-full" required>
                <option value="abierto" {{ old('estado', $ticket->estado) == 'abierto' ? 'selected' : '' }}>Abierto</option>
                <option value="en_progreso" {{ old('estado', $ticket->estado) == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                <option value="cerrado" {{ old('estado', $ticket->estado) == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
        </div>
        <div>
            <label class="block">Prioridad</label>
            <select name="prioridad" class="border rounded p-2 w-full" required>
                <option value="baja" {{ old('prioridad', $ticket->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('prioridad', $ticket->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('prioridad', $ticket->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar Ticket</button>
    </form>

    <a href="{{ route('tickets.index') }}" class="text-blue-500 mt-4 inline-block">Volver a la lista</a>
@endsection
