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
                                @if($showComentarioField)
                                <div class="mt-4">
                                    <label class="block text-white">Comentario de Cierre (Obligatorio)</label>
                                    <textarea wire:model="comentario" class="border rounded p-2 w-full"
                                        placeholder="Ingrese el motivo del cierre" required></textarea>
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
                    @foreach ($ticket->ticketChanges as $change)
                    <div class="mb-4 pb-4 border-b border-gray-600">
                        <div class="flex justify-between">
                            <strong class="text-lujoYel">{{ $change->user->name }}</strong>
                            <span class="text-gray-400 text-sm">{{ $change->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-white mt-1">
                            @if($change->change_type === 'comentario_cierre')
                            Agregó comentario de cierre:
                            @else
                            Cambió {{ $change->change_type }} de
                            <span class="font-bold">{{ strtoupper($change->old_value) }}</span> a
                            <span class="font-bold">{{ strtoupper($change->new_value) }}</span>
                            @endif
                        </p>

                        {{-- Mostrar comentario SOLO si es un cambio de tipo comentario_cierre --}}
                        @if($change->change_type === 'comentario_cierre')
                        <div class="mt-2 p-2 bg-gray-700 rounded">
                            <p class="text-white">{{ $change->new_value }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal para imágenes -->
    <div id="imageModal" class="fixed inset-0 flex justify-center items-center bg-gray-900 bg-opacity-90 hidden z-[9999] backdrop-blur-sm p-4">
        <div class="relative bg-lujoNeg rounded-lg shadow-xl w-full h-full max-w-[95vw] max-h-[95vh] md:max-w-[90vw] md:max-h-[90vh] flex flex-col">
            <!-- Header del modal -->
            <div class="flex justify-between items-center p-3 md:p-4 border-b border-gray-700">
                <h3 class="text-sm md:text-lg font-semibold text-lujoYel truncate max-w-[50%]" id="modalTitle">Vista previa</h3>
                <div class="flex space-x-2">
                    <a id="downloadLink" href="" download
                        class="px-2 py-1 md:px-4 md:py-2 bg-lujoYel text-lujoNeg text-xs md:text-base font-medium rounded-md hover:bg-yellow-400 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 mr-1 md:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="hidden sm:inline">Descargar</span>
                    </a>
                    <button onclick="closeModal()"
                        class="px-2 py-1 md:px-4 md:py-2 bg-gray-700 text-white text-xs md:text-base font-medium rounded-md hover:bg-gray-600 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="hidden sm:inline ml-1 md:ml-2">Cerrar</span>
                    </button>
                </div>
            </div>

            <!-- Contenido de la imagen -->
            <div class="flex-1 flex justify-center items-center p-2 md:p-4 overflow-auto">
                <img id="modalImage" src="" alt="Imagen ampliada"
                    class="max-h-[calc(100vh-180px)] max-w-full object-contain rounded">
            </div>

            <!-- Footer del modal -->
            <div class="p-2 md:p-3 bg-gray-800 text-center text-xs md:text-sm text-gray-400 rounded-b-lg flex flex-col sm:flex-row justify-center items-center gap-2">
                <span id="fileNameDisplay" class="truncate max-w-[80vw]"></span>
                <span id="imageDimensions" class="hidden sm:inline"></span>
            </div>
        </div>
    </div>

    <script>
        // Función para abrir el modal con la imagen
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const downloadLink = document.getElementById('downloadLink');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const imageDimensions = document.getElementById('imageDimensions');

            // Cargar la imagen para obtener sus dimensiones
            const img = new Image();
            img.onload = function() {
                imageDimensions.textContent = `${this.width} × ${this.height} px`;
                imageDimensions.classList.remove('hidden');
            };
            img.src = imageSrc;

            // Configurar elementos del modal
            modal.classList.remove('hidden');
            modalImg.src = imageSrc;
            downloadLink.href = imageSrc;

            // Extraer nombre del archivo
            const fileName = imageSrc.split('/').pop().split('?')[0];
            fileNameDisplay.textContent = fileName;
            downloadLink.download = fileName;

            // Bloquear scroll del body
            document.body.style.overflow = 'hidden';
            document.body.style.touchAction = 'none';
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = '';
            document.body.style.touchAction = '';
        }

        // Event listeners mejorados
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('imageModal');

            // Clic fuera del contenido
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Tecla ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });

        // Manejo responsive del tamaño de la imagen
        function adjustImageSize() {
            const modalImg = document.getElementById('modalImage');
            if (modalImg && modalImg.src) {
                const viewportHeight = window.innerHeight;
                modalImg.style.maxHeight = `calc(${viewportHeight}px - 180px)`;
            }
        }

        // Actualizar tamaño al redimensionar
        window.addEventListener('resize', adjustImageSize);

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