<div>
<div class="flex justify-center items-center min-h-screen bg-lujoYel-100">
    <div class="bg-lujoNeg p-6 rounded-lg shadow-lg w-[80%]">
        <h2 class="text-2xl font-bold mb-4 text-center text-white">{{ $ticket->asunto }}</h2>

        @if(!Auth::user()->isUser())
        <form wire:submit.prevent="actualizar">
            @csrf
            @method('PUT')
            <!-- Tabla para mostrar los detalles del ticket -->
            <table class="w-full mt-4 border-collapse border">
                <thead>
                    <tr class="bg-lujoNeg text-white">
                        <th class="border p-2">Estado</th>
                        <th class="border p-2">Prioridad</th>
                        <th class="border p-2">Derivar</th>
                        <th class="border p-2">Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800">
                    <tr class="border">
                        <td class="border p-2 text-center text-black">
                            <select wire:model="estado" name="estado" class="border rounded p-2 w-full" required>
                                <option value="abierto">Abierto</option>
                                <option value="en_progreso">En Progreso</option>
                                <option value="cerrado">Cerrado</option>
                            </select>
                            @if($estado === 'cerrado')
                            <div class="mt-4">
                                <label for="comentarioCierre" class="text-white">Comentario de Cierre (Obligatorio)</label>
                                <textarea wire:model="comentario" id="comentarioCierre" name="comentario" class="border rounded p-2 w-full" placeholder="Ingrese un comentario de cierre" required></textarea>
                            </div>
                            @endif
                        </td>
                        <td class="border p-2 text-center">
                            <select wire:model="prioridad" name="prioridad" class="border rounded p-2 w-full" required>
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </td>
                        <td class="border p-2 text-center">
                            <select wire:model="tipo" name="tipo" class="border rounded p-2 w-full" required>
                                @foreach ($roles as $role => $name)
                                    @foreach ($tiposPorRol[$role] as $tipoOption)
                                        <option value="{{ $tipoOption }}">
                                            {{ $name }}: {{ $tipoOption }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </td>
                        <td class="border p-2 text-center text-white">{{ $ticket->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-white text-center">Descripción</h3>
                <p class="text-white">{{ $ticket->descripcion }}</p>
            </div>

            <!-- Sección para visualizar archivos adjuntos -->
            @if($files && count($files) > 0)
            <div class="mt-8">
                <h3 class="text-xl text-center font-semibold text-white">Archivos Adjuntos y Capturas</h3>
                <div class="flex justify-center space-x-4 mt-2 flex-wrap">
                    @foreach($files as $file)
                    <div class="text-white mb-4">
                        @if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ asset('storage/' . $file) }}" alt="Adjunto" style="max-width: 150px;" 
                             class="mb-2 cursor-pointer" 
                             onclick="openModal('{{ asset('storage/' . $file) }}')">
                        @else
                        <a href="{{ asset('storage/' . $file) }}" target="_blank" 
                           class="text-lujoYel hover:underline block mb-2">
                           {{ basename($file) }}
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <p class="mt-4 text-white">No hay archivos adjuntos.</p>
            @endif

            <div class="mt-6 text-center">
                <button type="button" wire:click="volverALaLista" 
                        class="bg-red-500 text-white px-4 py-2 rounded mr-4">
                    Volver a la lista
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-lujoYel text-black font-semibold rounded-lg hover:bg-blue-800 transition">
                    Guardar cambios
                </button>
            </div>
        </form>

        @if(Auth::user()->clase == 'jefe')
    <form wire:submit.prevent="asignarEncargado">
        @csrf
        <div class="mt-6 text-center">
            <label for="encargado_id" class="text-white block mb-2">Asignar encargado:</label>
            <select wire:model="encargado_id" id="encargado_id" class="border rounded p-2 w-full">
                @foreach ($usuariosMismoRol as $usuario)
                <option value="{{ $usuario->id }}" {{ $ticket->encargado_id == $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mt-6 text-center">
            <button type="submit" class="inline-block px-6 py-2 bg-lujoYel text-lujoNeg font-semibold rounded-lg hover:bg-lujoNeg hover:text-lujoYel transition">
                Asignar
            </button>
        </div>
    </form>
@endif

        @else
        <!-- Vista para usuarios normales -->
        <table class="w-full mt-4 border-collapse border">
            <thead>
                <tr class="bg-lujoNeg text-white">
                    <th class="border p-2">Estado</th>
                    <th class="border p-2">Tipo</th>
                    <th class="border p-2">Fecha de Creación</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800">
                <tr class="border">
                    <td class="border p-2 text-center text-white">{{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}</td>
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

        <div class="mt-6 text-center">
            <button wire:click="volverALaLista" 
                    class="inline-block px-6 py-2 bg-lujoYel text-lujoNeg font-semibold rounded-lg hover:bg-lujoNeg hover:text-lujoYel transition">
                Volver a la lista
            </button>
        </div>
        @endif

        <!-- Sección de conversación -->
<div class="mt-8">
    <h3 class="text-xl font-semibold text-white text-center">Conversación</h3>
    <div class="bg-gray-700 p-4 rounded max-h-60 overflow-y-auto" id="messagesContainer">
        @foreach ($messages as $message)
        <div class="mb-2">
            <strong class="text-lujoYel">{{ $message['user']['name'] }}:</strong>
            <span class="text-white">{{ $message['content'] }}</span>
            <small class="block text-gray-400">{{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</small>
        </div>
        @endforeach
    </div>
</div>

<!-- Formulario de mensaje -->
<div class="mt-4">
    <form wire:submit.prevent="enviarMensaje">
        <textarea wire:model="messageContent" class="w-full p-2 rounded" 
                  placeholder="Escribe tu mensaje..." rows="3" required></textarea>
        <button type="submit" class="mt-2 w-full px-4 py-2 bg-lujoYel text-lujoNeg font-semibold rounded-lg hover:bg-lujoNeg hover:text-lujoYel transition">
            Enviar Mensaje
        </button>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('scrollToMessage', () => {
            const container = document.getElementById('messagesContainer');
            container.scrollTop = 0; // Se desplaza al inicio donde están los nuevos mensajes
        });
    });
</script>
@endpush

        <!-- Historial de cambios -->
        @if(Auth::user()->rol !== 'usuario')
        <div class="mt-8 bg-lujoNeg p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-white text-center">Historial de Cambios</h3>
            <div class="bg-gray-700 p-4 rounded max-h-60 overflow-y-auto">
                @forelse ($ticket->ticketChanges as $change)
                <div class="mb-2">
                    <strong class="text-lujoYel">{{ $change->user->name }}:</strong>
                    <span class="text-white">Cambió {{ $change->change_type }} de {{ strtoupper($change->old_value) }} a {{ strtoupper($change->new_value) }}</span>
                    @if($change->change_type === 'estado' && $change->new_value === 'cerrado' && $ticket->comentario)
                    <div class="mt-1 text-white bg-gray-600 rounded p-2">
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
</div>

<!-- Modal para imágenes -->
<div id="imageModal" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-75 hidden z-50">
    <div class="relative bg-black p-4 rounded-lg w-[90%] h-[90%] max-w-4xl max-h-screen">
        <button onclick="closeModal()" class="absolute top-2 right-2 px-4 py-2 bg-lujoYel text-lujoNeg font-semibold rounded-lg">
            Cerrar
        </button>
        <div class="h-full flex flex-col">
            <div class="flex-grow flex justify-center items-center overflow-hidden">
                <img id="modalImage" src="" alt="Imagen grande" class="max-h-full max-w-full object-contain">
            </div>
            <div class="flex justify-center mt-4">
                <a id="downloadLink" href="" download class="px-6 py-2 bg-lujoYel text-lujoNeg font-semibold rounded-lg hover:bg-lujoNeg hover:text-lujoYel transition">
                    Descargar Imagen
                </a>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Función para abrir el modal con la imagen
    function openModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const downloadLink = document.getElementById('downloadLink');
        
        modal.classList.remove('hidden');
        modalImg.src = imageSrc;
        downloadLink.href = imageSrc;
        
        // Agregar nombre de archivo a la descarga
        const fileName = imageSrc.split('/').pop();
        downloadLink.download = fileName;
    }

    // Función para cerrar el modal
    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Cerrar modal al hacer clic fuera de la imagen
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Manejar el cambio de estado para mostrar/ocultar comentario
    document.addEventListener('livewire:init', () => {
        Livewire.on('estadoCambiado', (estado) => {
            const comentarioContainer = document.getElementById("comentarioCierreContainer");
            const comentarioInput = document.getElementById("comentarioCierre");
            
            if (estado === 'cerrado') {
                comentarioContainer.classList.remove("hidden");
                comentarioInput.setAttribute("required", "required");
            } else {
                comentarioContainer.classList.add("hidden");
                comentarioInput.removeAttribute("required");
            }
        });
    });
</script>