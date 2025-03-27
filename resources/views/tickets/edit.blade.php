@extends('layouts.app')

@section('title', 'Editar Ticket')

@section('content')
    <!-- Contenedor para centrar el contenido -->
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #efe300;">
        <div style="background-color: #1F1F1F; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 50%; max-width: 700px;">
            <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem; text-align: center; color: white;">{{ old('titulo', $ticket->asunto) }}</h2>

            <!-- Mensajes de error -->
            @if ($errors->any())
                <div style="background-color: #FAD1D1; color: #D84A4A; padding: 12px; margin-bottom: 16px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario para editar el ticket -->
            <form action="{{ route('tickets.update', $ticket) }}" method="POST" style="margin-top: 24px;">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 16px;">
                    <label style="display: block; color: white;">Estado</label>
                    <select name="estado" style="border: 1px solid #ccc; border-radius: 4px; padding: 8px; width: 100%;" required>
                        <option value="abierto" {{ old('estado', $ticket->estado) == 'abierto' ? 'selected' : '' }}>Abierto</option>
                        <option value="en_progreso" {{ old('estado', $ticket->estado) == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option value="cerrado" {{ old('estado', $ticket->estado) == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; color: white;">Prioridad</label>
                    <select name="prioridad" style="border: 1px solid #ccc; border-radius: 4px; padding: 8px; width: 100%;" required>
                        <option value="baja" {{ old('prioridad', $ticket->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ old('prioridad', $ticket->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta" {{ old('prioridad', $ticket->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>

                <!-- Botón de actualización -->
                <button type="submit" style="background-color: #efe300; color: #1F1F1F; font-weight: 600; padding: 12px 24px; border-radius: 8px; transition: background-color 0.3s;">
                    Actualizar Ticket
                </button>
            </form>

            <!-- Enlace para volver a la lista -->
            <div style="margin-top: 24px; text-align: center;">
                <a href="{{ route('tickets.index') }}" style="color: #efe300; text-decoration: none; font-weight: 600;">
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>
@endsection



