@extends('layouts.app')

@section('title', 'Detalles del Ticket')

@section('content')
   <!-- Contenedor para centrar el contenido -->
   <div class="flex justify-center items-center min-h-screen bg-lujoYel-100">
        <div class="bg-lujoNeg p-6 rounded-lg shadow-lg w-[80%] ">
            <h2 class="text-2xl font-bold mb-4 text-center text-white">{{ $ticket->asunto }}</h2>


            <form action="{{ route('tickets.update', $ticket) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Tabla para mostrar los detalles del ticket -->
            <table class="w-full mt-4 border-collapse border">
                <thead>
                    <tr class="bg-lujoNeg text-white">
                        <!-- <th class="border p-2">Descripción</th> -->
                        <th class="border p-2">Estado</th>
                        <th class="border p-2">Prioridad</th>
                        <th class="border p-2">Tipo</th>
                        <th class="border p-2">Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800">
                    <tr class="border">
                        <!-- <td class="border p-2">{{ $ticket->descripcion }}</td> -->
                        <td class="border p-2 text-center text-black">
                        <select name="estado" class="border rounded p-2 w-full" required>
                            <option value="abierto" {{ old('estado', $ticket->estado) == 'abierto' ? 'selected' : '' }}>Abierto</option>
                            <option value="en_progreso" {{ old('estado', $ticket->estado) == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="cerrado" {{ old('estado', $ticket->estado) == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                        </select>
                        </td>
                        <td class="border p-2 text-center">
                            <select name="prioridad" class="border rounded p-2 w-full" required>
                                <option value="baja" {{ old('prioridad', $ticket->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('prioridad', $ticket->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('prioridad', $ticket->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </td>
                        <td class="border p-2 text-center text-white">{{ ucfirst($ticket->tipo) }}</td>
                        <td class="border p-2 text-center text-white">{{ $ticket->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-white text-center">Descripción</h3>
                <p class="text-white">{{ $ticket->descripcion }}</p>
            </div>

            <!-- Sección para visualizar archivos adjuntos y capturas de pantalla -->
            @if($ticket->archivos)
                @php
                    $files = json_decode($ticket->archivos, true);
                @endphp
                @if($files && count($files) > 0)
                    <div class="mt-8">
                        <h3 class="text-xl text-center font-semibold text-white">Archivos Adjuntos y Capturas de Pantalla</h3>
                        <div class="flex justify-center space-x-4 mt-2">
                            @foreach($files as $file)
                                <div class="text-white">
                                    @if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $file) }}" alt="Adjunto" style="max-width: 150px;" class="mb-2">
                                    @else
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-lujoYel hover:underline">{{ $file }}</a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="mt-4 text-white">No hay archivos adjuntos.</p>
                @endif
            @else
                <p class="mt-4 text-white">No hay archivos adjuntos.</p>
            @endif

            <!-- Botón "Volver a la lista" estilizado -->
            <div class="mt-6 text-center">
                <a href="{{ route('tickets.index') }}" class="inline-block px-6 py-2 bg-lujoYel text-lujoNeg font-semibold rounded-lg hover:bg-lujoNeg hover:text-lujoYel transition">
                    Volver a la lista
                </a>
                <button type="submit" class="px-6 py-2 bg-lujoYel text-black font-semibold rounded-lg hover:bg-blue-800 transition">
                    Guardar cambios
                </button>
            </div>
            </form>
        </div>
    </div>
@endsection

