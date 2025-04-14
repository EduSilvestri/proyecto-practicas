<div class="min-h-screen bg-gray-900 py-8">
    <style>
        /* Estilos personalizados premium mejorados */
        body {
            background-color: #111827;
            color: #f3f4f6;
        }

        /* Recuadro de descripción */
        .descripcion-box {
            background: rgba(40, 42, 54, 0.7);
            border: 1px solid rgba(68, 71, 90, 0.3);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        /* Selects personalizados */
        .custom-select {
            background: rgba(40, 42, 54, 0.9);
            border: 1px solid rgba(68, 71, 90, 0.5);
            color: #f8f8f2; /* Color de texto neutro */
            padding: 0.5rem 1rem;
            border-radius: 6px;
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236272a4' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }

        .custom-select:focus {
            border-color: #bd93f9;
            box-shadow: 0 0 0 2px rgba(189, 147, 249, 0.2);
            outline: none;
        }

        /* Colores para estados seleccionados */
        .estado-abierto {
            color: #2ED573;
            border-color: rgba(46, 213, 115, 0.4);
        }

        .estado-en_progreso {
            color: #1E90FF;
            border-color: rgba(30, 144, 255, 0.4);
        }

        .estado-cerrado {
            color: #A29BFE;
            border-color: rgba(162, 155, 254, 0.4);
        }

        /* Colores para prioridades seleccionadas */
        .prioridad-alta {
            color: #FF4757;
            border-color: rgba(255, 71, 87, 0.4);
        }

        .prioridad-media {
            color: #FFC107;
            border-color: rgba(255, 193, 7, 0.4);
        }

        .prioridad-baja {
            color: #28A745;
            border-color: rgba(40, 167, 69, 0.4);
        }

        /* Placeholder para selects */
        .custom-select option[disabled][selected] {
            color: #6272a4;
        }

        /* Resto de tus estilos... */
        .glass-card {
            background: rgba(23, 23, 26, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.36);
        }

        .table-header {
            background: linear-gradient(135deg, rgba(40, 42, 54, 0.95) 0%, rgba(30, 32, 42, 0.95) 100%);
            color: #f8f8f2;
            border-bottom: 1px solid rgba(68, 71, 90, 0.5);
        }

        .table-row {
            background: rgba(40, 42, 54, 0.7);
            border-bottom: 1px solid rgba(68, 71, 90, 0.3);
        }

        .table-cell {
            border-right: 1px solid rgba(68, 71, 90, 0.2);
            padding: 1.25rem;
            color: #f3f4f6;
        }

        .table-cell:last-child {
            border-right: none;
        }

        .action-btn {
            background: rgba(80, 250, 123, 0.1);
            color: #50fa7b;
            border: 1px solid rgba(80, 250, 123, 0.3);
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
        }

        .action-btn:hover {
            background: rgba(80, 250, 123, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(80, 250, 123, 0.15);
        }

        .btn-volver {
            background: rgba(255, 71, 87, 0.1);
            color: #FF4757;
            border: 1px solid rgba(255, 71, 87, 0.3);
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .btn-volver:hover {
            background: rgba(255, 71, 87, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(255, 71, 87, 0.15);
        }

        /* ESTILOS PARA ESTADOS (COLORES) */
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-esperando {
            background: rgba(255, 159, 67, 0.15);
            color: #FF9F43;
            border: 1px solid rgba(255, 159, 67, 0.3);
        }

        .status-abierto {
            background: rgba(46, 213, 115, 0.15);
            color: #2ED573;
            border: 1px solid rgba(46, 213, 115, 0.3);
        }

        .status-en_progreso {
            background: rgba(30, 144, 255, 0.15);
            color: #1E90FF;
            border: 1px solid rgba(30, 144, 255, 0.3);
        }

        .status-cerrado {
            background: rgba(162, 155, 254, 0.15);
            color: #A29BFE;
            border: 1px solid rgba(162, 155, 254, 0.3);
        }

        /* ESTILOS PARA PRIORIDADES (COLORES) */
        .priority-tag {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid transparent;
        }

        .priority-alta {
            background: rgba(255, 71, 87, 0.15);
            color: #FF4757;
            border: 1px solid rgba(255, 71, 87, 0.3);
        }

        .priority-media {
            background: rgba(255, 193, 7, 0.15);
            color: #FFC107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .priority-baja {
            background: rgba(40, 167, 69, 0.15);
            color: #28A745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        /* Estilos para el modal de imágenes */
        .image-modal {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(12px);
        }

        .modal-content {
            background: rgba(23, 23, 26, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        /* Estilos para la sección de conversación */
        .conversation-container {
            background: rgba(40, 42, 54, 0.7);
            border: 1px solid rgba(68, 71, 90, 0.3);
            color: #f3f4f6;
        }

        .message-user {
            color: #50fa7b;
            font-weight: 600;
        }

        .message-time {
            color: #6272a4;
            font-size: 0.75rem;
        }

        .message-content {
            color: #f8f8f2;
        }

        /* Estilos para el historial de cambios */
        .history-container {
            background: rgba(40, 42, 54, 0.7);
            border: 1px solid rgba(68, 71, 90, 0.3);
        }

        .history-user {
            color: #bd93f9;
            font-weight: 600;
        }

        .history-time {
            color: #6272a4;
            font-size: 0.75rem;
        }

        .history-content {
            color: #f8f8f2;
        }

        .history-change {
            color: #ff79c6;
        }

        .comment-closure {
            color: #8be9fd;
            font-style: italic;
            background: rgba(139, 233, 253, 0.1);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }

        /* Ajustes para textarea */
        textarea {
            background: rgba(40, 42, 54, 0.9);
            border: 1px solid rgba(68, 71, 90, 0.5);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            width: 100%;
        }

        textarea:focus {
            border-color: #bd93f9;
            box-shadow: 0 0 0 2px rgba(189, 147, 249, 0.2);
            outline: none;
        }

        /* Botón de enviar mensaje más pequeño y centrado */
        .btn-enviar-mensaje {
            background: rgba(80, 250, 123, 0.1);
            color: #50fa7b;
            border: 1px solid rgba(80, 250, 123, 0.3);
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: block;
            margin: 0.5rem auto 0;
            width: auto;
            min-width: 150px;
            text-align: center;
        }

        .btn-enviar-mensaje:hover {
            background: rgba(80, 250, 123, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(80, 250, 123, 0.15);
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .table-cell {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Título modificado para que coincida con el de index -->
        <h2 class="text-5xl md:text-6xl !text-5xl !md:text-6xl font-bold text-center text-white mb-10 md:mb-12 tracking-normal" style="font-size: 3rem !important; line-height: 1 !important; margin-bottom:2%;">
            Detalles del Ticket
        </h2>

        <div class="glass-card p-6 mb-8">
            <h3 class="text-2xl font-bold mb-4 text-center text-white">{{ $ticket->asunto }}</h3>

            @if(!Auth::user()->isUser())
            <form wire:submit.prevent="actualizar">
                @csrf
                @method('PUT')
                <!-- Tabla para mostrar los detalles del ticket -->
                <table class="w-full mt-4">
                    <thead class="table-header">
                        <tr>
                            <th class="table-cell text-center">Estado</th>
                            <th class="table-cell text-center">Prioridad</th>
                            <th class="table-cell text-center">Derivar</th>
                            <th class="table-cell text-center">Fecha de Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-row">
                            <td class="table-cell">
                                <select wire:model="estado" name="estado" class="custom-select @if($estado) estado-{{ $estado }} @endif" required>
                                    <option value="" disabled selected>Seleccione estado</option>
                                    <option value="abierto">Abierto</option>
                                    <option value="en_progreso">En Progreso</option>
                                    <option value="cerrado">Cerrado</option>
                                </select>
                                @if($showComentarioField)
                                <div class="mt-4">
                                    <label class="block text-white">Comentario de Cierre (Obligatorio)</label>
                                    <textarea wire:model="comentario" class="w-full"
                                        placeholder="Ingrese el motivo del cierre" required></textarea>
                                </div>
                                @endif
                            </td>
                            <td class="table-cell">
                                <select wire:model="prioridad" name="prioridad" class="custom-select @if($prioridad) prioridad-{{ $prioridad }} @endif" required>
                                    <option value="" disabled selected>Seleccione prioridad</option>
                                    <option value="baja">Baja</option>
                                    <option value="media">Media</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </td>
                            <td class="table-cell">
                                <select wire:model="tipo" name="tipo" class="custom-select" required>
                                    <option value="" disabled selected>Seleccione tipo</option>
                                    @foreach ($roles as $role => $name)
                                    @foreach ($tiposPorRol[$role] as $tipoOption)
                                    <option value="{{ $tipoOption }}">
                                        {{ $name }}: {{ $tipoOption }}
                                    </option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </td>
                            <td class="table-cell text-center">{{ $ticket->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-white text-center">Descripción</h3>
                    <!-- Recuadro de descripción mejorado -->
                    <div class="descripcion-box">
                        <p class="text-white">{{ $ticket->descripcion }}</p>
                    </div>
                </div>

                <!-- Sección para visualizar archivos adjuntos -->
                @if($files && count($files) > 0)
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-white text-center">Archivos Adjuntos y Capturas</h3>
                    <div class="flex flex-wrap justify-center gap-4 mt-4">
                        @foreach($files as $file)
                        <div class="text-white">
                            @if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ asset('storage/' . $file) }}" alt="Adjunto" style="max-width: 150px;"
                                class="mb-2 cursor-pointer rounded border border-gray-700"
                                onclick="openModal('{{ asset('storage/' . $file) }}')">
                            @else
                            <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                class="action-btn inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                {{ basename($file) }}
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <p class="mt-4 text-white text-center">No hay archivos adjuntos.</p>
                @endif

                <div class="mt-6 flex justify-center gap-4">
                    <button type="button" wire:click="volverALaLista"
                        class="btn-volver px-6 py-2 rounded-lg font-semibold">
                        Volver a la lista
                    </button>
                    <button type="submit"
                        class="action-btn px-6 py-2 font-semibold">
                        Guardar cambios
                    </button>
                </div>
            </form>

            @if(Auth::user()->clase == 'jefe')
            <form wire:submit.prevent="asignarEncargado" class="mt-6">
                @csrf
                <div class="text-center">
                    <label for="encargado_id" class="block text-white mb-2">Asignar encargado:</label>
                    <select wire:model="encargado_id" id="encargado_id" class="custom-select w-full max-w-md mx-auto">
                        <option value="" selected>Seleccione un encargado</option>
                        @foreach ($usuariosMismoRol as $usuario)
                        <option value="{{ $usuario->id }}" {{ $ticket->encargado_id == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="action-btn px-6 py-2 font-semibold">
                        Asignar
                    </button>
                </div>
            </form>
            @endif

            @else
            <!-- Vista para usuarios normales -->
            <table class="w-full mt-4">
                <thead class="table-header">
                    <tr>
                        <th class="table-cell text-center">Estado</th>
                        <th class="table-cell text-center">Tipo</th>
                        <th class="table-cell text-center">Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-row">
                        <td class="table-cell text-center">
                            <span class="status-pill status-{{ $ticket->estado }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}
                            </span>
                        </td>
                        <td class="table-cell text-center">{{ ucfirst($ticket->tipo) }}</td>
                        <td class="table-cell text-center">{{ $ticket->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-white text-center">Descripción</h3>
                <!-- Recuadro de descripción mejorado para usuarios normales -->
                <div class="descripcion-box">
                    <p class="text-white">{{ $ticket->descripcion }}</p>
                </div>
            </div>

            <!-- Sección para visualizar archivos adjuntos y capturas de pantalla -->
            @if($ticket->archivos)
            @if($files && count($files) > 0)
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-white text-center">Archivos Adjuntos y Capturas de Pantalla</h3>
                <div class="flex flex-wrap justify-center gap-4 mt-4">
                    @foreach($files as $file)
                    <div class="text-white">
                        @if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ asset('storage/' . $file) }}" alt="Adjunto" style="max-width: 150px;"
                            class="mb-2 cursor-pointer rounded border border-gray-700"
                            onclick="openModal('{{ asset('storage/' . $file) }}')">
                        @else
                        <a href="{{ asset('storage/' . $file) }}" target="_blank"
                            class="action-btn inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            {{ basename($file) }}
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <p class="mt-4 text-white text-center">No hay archivos adjuntos.</p>
            @endif
            @else
            <p class="mt-4 text-white text-center">No hay archivos adjuntos.</p>
            @endif

            <div class="mt-6 text-center">
                <button wire:click="volverALaLista"
                    class="action-btn px-6 py-2 font-semibold">
                    Volver a la lista
                </button>
            </div>
            @endif
        </div>

        <!-- Sección de conversación -->
        <div class="glass-card p-6 mb-8">
            <h3 class="text-xl font-semibold text-white text-center mb-4">Conversación</h3>
            <div class="conversation-container p-4 rounded-lg max-h-60 overflow-y-auto" id="messagesContainer">
                @foreach ($messages as $message)
                <div class="mb-4 pb-4 border-b border-gray-600 last:border-b-0">
                    <div class="flex justify-between items-start">
                        <strong class="message-user">{{ $message['user']['name'] }}</strong>
                        <small class="message-time">{{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</small>
                    </div>
                    <p class="message-content mt-1">{{ $message['content'] }}</p>
                </div>
                @endforeach
            </div>

            <!-- Formulario de mensaje -->
            <div class="mt-4">
                <form wire:submit.prevent="enviarMensaje">
                    <textarea wire:model="messageContent" class="w-full"
                        placeholder="Escribe tu mensaje..." rows="3" required></textarea>
                    <button type="submit" class="btn-enviar-mensaje">
                        Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>

        <!-- Historial de cambios -->
        @if(Auth::user()->rol !== 'usuario')
        <div class="glass-card p-6">
            <h3 class="text-xl font-semibold text-white text-center mb-4">Historial de Cambios</h3>
            <div class="history-container p-4 rounded-lg max-h-60 overflow-y-auto">
                @foreach ($ticket->ticketChanges as $change)
                <div class="mb-4 pb-4 border-b border-gray-600 last:border-b-0">
                    <div class="flex justify-between">
                        <strong class="history-user">{{ $change->user->name }}</strong>
                        <span class="history-time">{{ $change->created_at->diffForHumans() }}</span>
                    </div>

                    <p class="history-content mt-1">
                        @if($change->change_type === 'comentario_cierre')
                        <span class="comment-closure">Agregó comentario de cierre:</span>
                        @else
                        Cambió <span class="history-change">{{ $change->change_type }}</span> de
                        <span class="font-bold">{{ strtoupper($change->old_value) }}</span> a
                        <span class="font-bold">{{ strtoupper($change->new_value) }}</span>
                        @endif
                    </p>

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

    <!-- Modal para imágenes -->
    <div id="imageModal" class="fixed inset-0 flex justify-center items-center bg-gray-900 bg-opacity-90 hidden z-[9999] backdrop-blur-sm p-4 image-modal">
        <div class="relative bg-lujoNeg rounded-lg shadow-xl w-full h-full max-w-[95vw] max-h-[95vh] md:max-w-[90vw] md:max-h-[90vh] flex flex-col modal-content">
            <!-- Header del modal -->
            <div class="flex justify-between items-center p-3 md:p-4 border-b border-gray-700">
                <h3 class="text-sm md:text-lg font-semibold text-lujoYel truncate max-w-[50%]" id="modalTitle">Vista previa</h3>
                <div class="flex space-x-2">
                    <a id="downloadLink" href="" download
                        class="action-btn px-3 py-1 md:px-4 md:py-2 text-xs md:text-base font-medium rounded-md flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 mr-1 md:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="hidden sm:inline">Descargar</span>
                    </a>
                    <button onclick="closeModal()"
                        class="btn-volver px-3 py-1 md:px-4 md:py-2 text-xs md:text-base font-medium rounded-md flex items-center">
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

            // Actualizar clases de selects cuando cambian
            Livewire.hook('message.processed', (message, component) => {
                // Para estado
                const estadoSelect = document.querySelector('select[name="estado"]');
                if (estadoSelect) {
                    estadoSelect.className = 'custom-select';
                    if (estadoSelect.value) {
                        estadoSelect.classList.add(`estado-${estadoSelect.value}`);
                    }
                }

                // Para prioridad
                const prioridadSelect = document.querySelector('select[name="prioridad"]');
                if (prioridadSelect) {
                    prioridadSelect.className = 'custom-select';
                    if (prioridadSelect.value) {
                        prioridadSelect.classList.add(`prioridad-${prioridadSelect.value}`);
                    }
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
</div>