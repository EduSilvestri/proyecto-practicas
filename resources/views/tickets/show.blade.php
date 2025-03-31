@extends('layouts.app')

@section('title', 'Detalles del Ticket')

@section('content')
<!-- Contenedor para centrar el contenido -->
<div class="flex justify-center items-center min-h-screen bg-lujoYel-100">
    <div class="bg-lujoNeg p-6 rounded-lg shadow-lg w-[80%]">
        <h2 class="text-2xl font-bold mb-4 text-center text-white">{{ $ticket->asunto }}</h2>

        @if(!Auth::user()->isUser())
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
                        <th class="border p-2">Derivar</th>
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
                            <div id="comentarioCierreContainer" class="hidden mt-4">
                                <label for="comentarioCierre" class="text-white">Comentario de Cierre (Obligatorio)</label>
                                <textarea id="comentarioCierre" name="comentario" class="border rounded p-2 w-full" placeholder="Ingrese un comentario de cierre"></textarea>
                            </div>
                        </td>
                        <td class="border p-2 text-center">
                            <select name="prioridad" class="border rounded p-2 w-full" required>
                                <option value="baja" {{ old('prioridad', $ticket->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('prioridad', $ticket->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('prioridad', $ticket->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </td>
                        @php
                        // Definir los tipos de tickets permitidos para cada rol
                        $tiposPorRol = [
                        'it' => ['Problemas de Pagina Web'],
                        'facturacion' => ['Pagos'],
                        'copyright' => ['Peticion de Copyright', 'Peticion de Takedown'],
                        'desarrollo' => ['Problemas de lanzamiento', 'Peticion de Actualizacion de Lanzamiento'],
                        'soporte' => ['Preguntas generales'],
                        'admin' => [], // El admin tiene acceso a todos los tickets
                        ];

                        // Crear el array de roles con nombres amigables
                        $roles = [
                        'it' => 'IT',
                        'facturacion' => 'Facturación',
                        'copyright' => 'Copyright',
                        'desarrollo' => 'Desarrollo',
                        'soporte' => 'Soporte',
                        ];
                        @endphp

                        <td class="border p-2 text-center">
                            <select name="tipo" class="border rounded p-2 w-full" required>
                                @foreach ($roles as $role => $name)
                                @foreach ($tiposPorRol[$role] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo', $ticket->tipo) == $tipo ? 'selected' : '' }}>
                                    {{ $name }}: {{ $tipo }}
                                </option>
                                @endforeach
                                @endforeach
                            </select>
                        </td>


                        <td class="border p-2 text-center text-white">{{ $ticket->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Seccion para el historial de cambios del ticket -->


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
                        <img src="{{ asset('storage/' . $file) }}" alt="Adjunto" style="max-width: 150px;" class="mb-2 cursor-pointer" onclick="openModal('{{ asset('storage/' . $file) }}')">
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
        @else
        @csrf
        @method('PUT')
        <!-- Tabla para mostrar los detalles del ticket -->
        <table class="w-full mt-4 border-collapse border">
            <thead>
                <tr class="bg-lujoNeg text-white">
                    <!-- <th class="border p-2">Descripción</th> -->
                    <th class="border p-2">Estado</th>
                    <th class="border p-2">Tipo</th>
                    <th class="border p-2">Fecha de Creación</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800">
                <tr class="border">
                    <!-- <td class="border p-2">{{ $ticket->descripcion }}</td> -->
                    <td class="border p-2 text-center text-white">{{ $ticket->estado }}</td>
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
                    <img src="{{ asset('storage/' . $file) }}" alt="Adjunto" style="max-width: 150px; padding: 2%;" class="mb-2 cursor-pointer" onclick="openModal('{{ asset('storage/' . $file) }}')">

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
        </div>
        @endif
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-white text-center">Conversación</h3>
            <div class="bg-gray-700 p-4 rounded">
                @forelse ($ticket->messages as $message)
                <div class="mb-2">
                    <strong class="text-lujoYel">{{ $message->user->name }}:</strong>
                    <span class="text-white">{{ $message->content }}</span>
                    <small class="block text-gray-400">{{ $message->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <p class="text-white">No hay mensajes en esta conversación.</p>
                @endforelse
            </div>
        </div>
        <div class="mt-4">
            <form action="{{ route('tickets.message.store', $ticket->id) }}" method="POST">
                @csrf
                <textarea name="content" class="w-full p-2 rounded" placeholder="Escribe tu mensaje..." rows="3"></textarea>
                <button type="submit" class="mt-2 w-full px-4 py-2 bg-lujoYel text-lujoNeg font-semibold rounded-lg hover:bg-lujoNeg hover:text-lujoYel transition">Enviar Mensaje</button>
            </form>
        </div>
    </div>
</div>

<div class="mt-8 bg-lujoNeg p-6 rounded-lg shadow-lg">
    @if(Auth::user()->rol !== 'usuario')
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-white text-center">Historial de Cambios</h3>
        <div class="bg-gray-700 p-4 rounded">
            @forelse ($ticket->ticketChanges as $change)
            <div class="mb-2">
                <strong class="text-lujoYel">{{ $change->user->name }}:</strong>
                <span class="text-white">Cambió {{ $change->change_type }} de {{ strtoupper($change->old_value) }} a {{ strtoupper($change->new_value) }}</span>

                <!-- Verificar si el cambio fue de estado y si el estado fue cerrado -->
                @if($change->change_type === 'estado' && $change->new_value === 'cerrado' && $ticket->comentario)
                <div class="mt-1 text-white bg-gray-600 rounded">
                    <strong class="text-lujoYel">Comentario de Cierre:</strong> {{ $ticket->comentario }}
                </div>
                @endif
                <small class="block text-gray-400">{{ $change->created_at->diffForHumans() }}</small>

            </div>
            @empty
            <p class="text-white">No hay cambios registrados para este ticket.</p>
            @endforelse
        </div>
    </div>
    @endif
</div>



<!-- Modal para mostrar la imagen grande -->
<div id="imageModal" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-75 hidden">
    <div class="relative bg-black p-4 rounded-lg w-[600px] h-auto">
        <div class="flex justify-end">
            <!-- Botón de cerrar -->
            <button onclick="closeModal()" class="px-6 py-2 text-black font-semibold rounded-lg bg-lujoYel">
                Cerrar
            </button>
        </div>

        <!-- Imagen dentro del modal -->
        <div style="width: 100%; display: flex; justify-content: center; overflow: hidden;">
            <img id="modalImage" src="" alt="Imagen grande" style="width: 900px; height: 600px; object-fit: contain; margin: 0 auto;">
        </div>

        <div class="flex justify-center">
            <a id="downloadLink" href="" download class="px-6 py-2 bg-lujoYel text-lujoNeg font-semibold rounded-lg hover:bg-lujoNeg hover:text-lujoYel transition">
                Descargar Imagen
            </a>
        </div>
    </div>
</div>

<!-- Script para manejar la apertura y cierre del modal -->
<script>
    // Función para abrir el modal
    function openModal(imageUrl) {
        document.getElementById('modalImage').src = imageUrl; // Set the image source
        document.getElementById('downloadLink').href = imageUrl; // Set the download link
        document.getElementById('imageModal').classList.remove('hidden'); // Show the modal
    }

    // Función para cerrar el modal
    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden'); // Hide the modal
    }
    document.addEventListener("DOMContentLoaded", function() {
        let estadoSelect = document.querySelector('select[name="estado"]');
        let comentarioContainer = document.getElementById("comentarioCierreContainer");
        let comentarioInput = document.getElementById("comentarioCierre");

        estadoSelect.addEventListener("change", function() {
            if (this.value === "cerrado") {
                comentarioContainer.classList.remove("hidden");
                comentarioInput.setAttribute("required", "required");
            } else {
                comentarioContainer.classList.add("hidden");
                comentarioInput.removeAttribute("required");
            }
        });
    });
</script>

@endsection