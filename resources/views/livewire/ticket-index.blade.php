<div class="min-h-screen bg-gray-900 py-8">
    <style>
        /* Estilos personalizados premium mejorados */
        .glass-card {
            background: rgba(23, 23, 26, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.36);
            overflow-x: auto;
        }
        .table-header {
            background: linear-gradient(135deg, rgba(40, 42, 54, 0.95) 0%, rgba(30, 32, 42, 0.95) 100%);
            color: #f8f8f2;
            border-bottom: 1px solid rgba(68, 71, 90, 0.5);
        }
        .table-row {
            background: rgba(40, 42, 54, 0.7);
            border-bottom: 1px solid rgba(68, 71, 90, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .table-row:hover {
            background: rgba(50, 52, 64, 0.9);
        }
        .table-cell {
            border-right: 1px solid rgba(68, 71, 90, 0.2);
            padding: 1.25rem;
        }
        .table-cell:last-child {
            border-right: none;
        }
        .filter-tabs {
            background: rgba(30, 32, 42, 0.9);
            border-bottom: 1px solid rgba(68, 71, 90, 0.3);
        }
        .filter-btn {
            background: transparent;
            color: #6272a4;
            border: none;
            border-radius: 8px 8px 0 0;
            padding: 0.75rem 1.5rem;
            margin: 0 2px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            position: relative;
            white-space: nowrap;
        }
        .filter-btn:hover {
            color: #f8f8f2;
            background: rgba(98, 114, 164, 0.1);
        }
        .filter-btn.active {
            color: #50fa7b;
            background: rgba(40, 42, 54, 0.9);
        }
        .filter-btn.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #50fa7b;
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
        /* Esperando - Color naranja */
        .status-esperando {
            background: rgba(255, 159, 67, 0.15);
            color: #FF9F43;
            border: 1px solid rgba(255, 159, 67, 0.3);
        }
        /* Abierto - Color verde */
        .status-abierto {
            background: rgba(46, 213, 115, 0.15);
            color: #2ED573;
            border: 1px solid rgba(46, 213, 115, 0.3);
        }
        /* En Proceso - Color azul */
        .status-en_progreso {
            background: rgba(30, 144, 255, 0.15);
            color: #1E90FF;
            border: 1px solid rgba(30, 144, 255, 0.3);
        }
        /* Cerrado - Color morado */
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
        /* Alta - Rojo intenso */
        .priority-alta {
            background: rgba(255, 71, 87, 0.15);
            color: #FF4757;
            border: 1px solid rgba(255, 71, 87, 0.3);
        }
        /* Media - Amarillo vibrante */
        .priority-media {
            background: rgba(255, 193, 7, 0.15);
            color: #FFC107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        /* Baja - Verde claro */
        .priority-baja {
            background: rgba(40, 167, 69, 0.15);
            color: #28A745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }
        
        .search-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .search-container {
                flex-direction: row;
            }
        }
        .search-input {
            background: rgba(40, 42, 54, 0.9);
            border: 1px solid rgba(68, 71, 90, 0.5);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            flex-grow: 1;
            transition: all 0.3s ease;
            min-width: 0;
        }
        .search-input:focus {
            border-color: #bd93f9;
            box-shadow: 0 0 0 2px rgba(189, 147, 249, 0.2);
            outline: none;
        }
        .pagination-link {
            color: #6272a4;
            border: 1px solid rgba(68, 71, 90, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .pagination-link:hover {
            background: rgba(98, 114, 164, 0.1);
            color: #f8f8f2;
        }
        .pagination-active {
            background: #bd93f9;
            color: #282a36;
            border-color: #bd93f9;
            font-weight: 600;
        }
        /* Responsive adjustments */
        @media (max-width: 767px) {
            .table-cell {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }
            .filter-btn {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
            .action-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }
            .status-pill, .priority-tag {
                padding: 0.25rem 0.5rem;
                font-size: 0.6875rem;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-green-400 mb-8 md:mb-10 text-center tracking-tight">
            Panel de Tickets
        </h2>

        <!-- VISTA PARA USUARIOS NORMALES -->
        @if(Auth::user()->isUser())
            @if($selectedTicketId)
                <livewire:ticket-show :ticketId="$selectedTicketId" />
            @else
                <div class="glass-card">
                    <table class="w-full">
                        <thead class="table-header">
                            <tr>
                                <th class="table-cell text-left">Asunto</th>
                                <th class="table-cell text-left">Estado</th>
                                <th class="table-cell text-left">Prioridad</th>
                                <th class="table-cell text-left">Tipo</th>
                                <th class="table-cell text-left">Fecha</th>
                                <th class="table-cell text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="table-row">
                                    <td class="table-cell text-white font-medium">{{ $ticket->asunto }}</td>
                                    <td class="table-cell">
                                        <span class="status-pill status-{{ $ticket->estado }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}
                                        </span>
                                    </td>
                                    <td class="table-cell">
                                        <span class="priority-tag priority-{{ strtolower($ticket->prioridad) }}">
                                            {{ ucfirst($ticket->prioridad) }}
                                        </span>
                                    </td>
                                    <td class="table-cell text-gray-300">{{ ucfirst($ticket->tipo) }}</td>
                                    <td class="table-cell text-gray-300">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="table-cell text-right">
                                        <button wire:click="showTicket({{ $ticket->id }})" class="action-btn">
                                            Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-4 py-3 bg-gray-900/50 border-t border-gray-800">
                        {{ $tickets->links('vendor.livewire.tailwind') }}
                    </div>
                </div>
            @endif

        <!-- VISTA PARA TÉCNICOS/ADMINISTRADORES -->
        @else
            @if($selectedTicketId)
                <livewire:ticket-show :ticketId="$selectedTicketId" />
            @else
                <!-- Barra de búsqueda -->
                <div class="mb-6">
                    <form wire:submit.prevent="search" class="search-container">
                        <input type="text" wire:model.debounce.500ms="q" 
                               placeholder="Buscar tickets por asunto, usuario..." 
                               class="search-input">
                        <button type="submit" class="action-btn bg-gradient-to-r from-purple-500 to-blue-500 border-none text-white">
                            Buscar Tickets
                        </button>
                    </form>
                </div>

                <!-- Tabla principal -->
                <div class="glass-card">
                    <div class="filter-tabs px-4 overflow-x-auto">
                        <nav class="flex">
                            <button wire:click="setEstado('')" class="filter-btn {{ $estado === '' ? 'active' : '' }}">
                                Todos
                            </button>
                            <button wire:click="setEstado('esperando')" class="filter-btn {{ $estado === 'esperando' ? 'active' : '' }}">
                                Esperando
                            </button>
                            <button wire:click="setEstado('abierto')" class="filter-btn {{ $estado === 'abierto' ? 'active' : '' }}">
                                Abiertos
                            </button>
                            <button wire:click="setEstado('en_progreso')" class="filter-btn {{ $estado === 'en_progreso' ? 'active' : '' }}">
                                En Proceso
                            </button>
                            <button wire:click="setEstado('cerrado')" class="filter-btn {{ $estado === 'cerrado' ? 'active' : '' }}">
                                Cerrados
                            </button>
                        </nav>
                    </div>
                    <table class="w-full">
                        <thead class="table-header">
                            <tr>
                                <th class="table-cell text-left">Usuario</th>
                                <th class="table-cell text-left">Asunto</th>
                                <th class="table-cell text-center">Estado</th>
                                <th class="table-cell text-center">Prioridad</th>
                                <th class="table-cell text-left">Tipo</th>
                                @if(Auth::user()->clase == 'jefe' || Auth::user()->rol == 'admin')
                                    <th class="table-cell text-left">Encargado</th>
                                @endif
                                <th class="table-cell text-center">Fecha</th>
                                <th class="table-cell text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="table-row">
                                    <td class="table-cell text-white font-medium">{{ $ticket->user ? $ticket->user->name : 'N/A' }}</td>
                                    <td class="table-cell text-white font-medium">{{ $ticket->asunto }}</td>
                                    <td class="table-cell text-center">
                                        <span class="status-pill status-{{ $ticket->estado }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}
                                        </span>
                                    </td>
                                    <td class="table-cell text-center">
                                        <span class="priority-tag priority-{{ strtolower($ticket->prioridad) }}">
                                            {{ ucfirst($ticket->prioridad) }}
                                        </span>
                                    </td>
                                    <td class="table-cell text-gray-300">{{ ucfirst($ticket->tipo) }}</td>
                                    @if(Auth::user()->clase == 'jefe' || Auth::user()->rol == 'admin')
                                        <td class="table-cell text-gray-300">
                                            {{ $ticket->encargado ? $ticket->encargado->name : 'No asignado' }}
                                        </td>
                                    @endif
                                    <td class="table-cell text-center text-gray-300">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="table-cell text-right">
                                        <button wire:click="showTicket({{ $ticket->id }})" class="action-btn">
                                            Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-4 py-3 bg-gray-900/50 border-t border-gray-800">
                        {{ $tickets->links('vendor.livewire.tailwind') }}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>