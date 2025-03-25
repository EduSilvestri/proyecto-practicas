@extends('layouts.app')

@section('title', 'Crear Ticket')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Crear Nuevo Ticket</h2>
    <form action="{{ route('tickets.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Título</label>
            <input type="text" name="titulo" class="border rounded p-2 w-full" required>
        </div>
        <div>
            <label class="block">Descripción</label>
            <textarea name="descripcion" class="border rounded p-2 w-full" required></textarea>
        </div>
        <div>
            <label class="block">Prioridad</label>
            <select name="prioridad" class="border rounded p-2 w-full">
                <option value="baja">Baja</option>
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
    </form>
@endsection
