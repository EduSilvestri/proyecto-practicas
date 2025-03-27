@extends('layouts.app')

@section('title', 'Detalles del Ticket')

@section('content')
   <!-- Contenedor para centrar el contenido -->
   <div class="flex justify-center items-center min-h-screen bg-lujoYel-100">
        <div class="bg-lujoNeg p-6 rounded-lg shadow-lg w-[80%] ">
            <h2 class="text-2xl font-bold mb-4 text-center text-white">{{ $ticket->asunto }}</h2>

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
                <tbody class="bg-gray-800 text-white">
                    <tr class="border">
                        <!-- <td class="border p-2">{{ $ticket->descripcion }}</td> -->
                        <td class="border p-2 text-center">{{ ucfirst($ticket->estado) }}</td>
                        <td class="border p-2 text-center">{{ ucfirst($ticket->prioridad) }}</td>
                        <td class="border p-2 text-center">{{ ucfirst($ticket->tipo) }}</td>
                        <td class="border p-2 text-center">{{ $ticket->created_at->format('d-m-Y H:i:s') }}</td>
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
            </div>
        </div>
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
    </script>

@endsection

