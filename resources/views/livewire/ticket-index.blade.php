<div class="flex flex-col items-center">
    <h2 class="mt-5 text-2xl font-bold mb-4">Mis Tickets</h2>

    <!-- VISTA PARA USUARIOS -->
    @if(Auth::user()->isUser())
        @if($selectedTicketId)
        <!-- Mostrar el componente de TicketShow solo si hay un ticket seleccionado -->
        <livewire:ticket-show :ticketId="$selectedTicketId" />
        @else
<table class="w-full mt-4 border-collapse border">
    <thead>
        <tr class="bg-lujoNeg text-white">
            <th class="border p-2">Asunto</th>
            <th class="border p-2">Estado</th>
            <th class="border p-2">Tipo</th>
            <th class="border p-2">Fecha de Creación</th>
            <th class="border p-2">Acciones</th>
        </tr>
    </thead>
    <tbody class="bg-gray-800 text-white">
        @foreach($tickets as $ticket)
            <tr class="border">
                <td class="border p-2 text-center">{{ $ticket->asunto }}</td>
                <td class="border p-2 text-center">{{ ucfirst($ticket->estado) }}</td>
                <td class="border p-2 text-center">{{ ucfirst($ticket->tipo) }}</td>
                <td class="border p-2 text-center">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                <td class="border p-2 text-center">
                <button wire:click="showTicket({{ $ticket->id }})" class="text-blue-500">Ver</button>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
        @endif
@else

<!-- VISTA PARA TECNICOS -->
    <!-- Caja del formulario con borde -->
    <div class="bg-lujoNeg rounded p-4 mb-4">
    @if($selectedTicketId)
        <!-- Mostrar el componente de TicketShow solo si hay un ticket seleccionado -->
        <livewire:ticket-show :ticketId="$selectedTicketId" />
    @else
        <!-- Formulario de búsqueda y filtrado -->
        <form wire:submit.prevent="search">
            <div class="flex flex-wrap gap-4 justify-center">
                <!-- Buscar por asunto -->
                <div>
                    <input 
                        type="text" 
                        wire:model.debounce.500ms="q" 
                        placeholder="Buscar por asunto" 
                        class="border rounded p-2">
                </div>
                <!-- Botón de búsqueda -->
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
                </div>
            </div>
        </form>
    </div>


    <!-- Tabla de datos -->
    <div class="w-full max-w-4xl m-0 p-0">
        @if(session('exito'))
            <p class="text-green-500">{{ session('exito') }}</p>
        @endif
        <table class="w-full mt-0 border-collapse border">
            <thead>
            <tr class="bg-lujoNeg text-white">
                    <div class="flex justify-start gap-2">
                        <th wire:click="setEstado('esperando')" class="px-4 py-2 border cursor-pointer {{ $estado == 'esperando' ? 'bg-blue-500' : '' }}" style="background-color: #333;">
                            Esperando
                        </th>
                        <th wire:click="setEstado('abierto')" class="px-4 py-2 border cursor-pointer {{ $estado == 'abierto' ? 'bg-blue-500' : '' }}" style="background-color: #333;">
                            Abiertos
                        </th>
                        <th wire:click="setEstado('en_progreso')" class="px-4 py-2 border cursor-pointer {{ $estado == 'en_progreso' ? 'bg-blue-500' : '' }}" style="background-color: #333;">
                            Proceso
                        </th>
                        <th wire:click="setEstado('cerrado')" class="px-4 py-2 border cursor-pointer {{ $estado == 'cerrado' ? 'bg-blue-500' : '' }}" style="background-color: #333;">
                            Cerrados
                        </th>
                    </div>
                    <th colspan="4" style="background-color: #333;"></th>
                </th>

            </tr>

                <tr class="bg-lujoNeg text-white">
                    <th class="border bg-gray-500 text-white px-4 py-2 rounded-l-none border-r-0">Usuario</th>
                    <th class="border bg-gray-500 text-white px-4 py-2">Asunto</th>
                    <th class="border bg-gray-500 text-white px-4 py-2">Estado</th>
                    <th class="border bg-gray-500 text-white px-4 py-2">Prioridad</th>
                    <th class="border bg-gray-500 text-white px-4 py-2">Tipo</th>
                    @if(Auth::user()->clase == 'jefe' || Auth::user()->rol == 'admin')
                        <th class="border bg-gray-500 text-white px-4 py-2">Encargado</th>
                    @endif
                    <th class="border bg-gray-500 text-white px-4 py-2">Fecha de Creación</th>
                    <th class="border bg-gray-500 text-white px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 text-white">
                @foreach($tickets as $ticket)
                    <tr class="border">
                        <td class="border p-2 text-center">{{ $ticket->user ? $ticket->user->name : 'Usuario no encontrado' }}</td>
                        <td class="border p-2 text-center">{{ $ticket->asunto }}</td>
                        <td class="border p-2 text-center">{{ ucfirst($ticket->estado) }}</td>
                        <td class="border p-2 text-center">{{ ucfirst($ticket->prioridad) }}</td>
                        <td class="border p-2 text-center">{{ ucfirst($ticket->tipo) }}</td>
                        @if(Auth::user()->clase == 'jefe' || Auth::user()->rol == 'admin')
                            <td class="border p-2 text-center">
                                @if($ticket->encargado)
                                    {{ $ticket->encargado->name }}
                                @else
                                    No asignado
                                @endif
                            </td>
                        @endif
                        <td class="border p-2 text-center">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        <td class="border p-2 text-center">
                        <button wire:click="showTicket({{ $ticket->id }})" class="text-blue-500">Ver</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Paginación -->
        <div class="mt-8">
            {{ $tickets->links('vendor.livewire.tailwind') }}
        </div>
    </div>
    @endif
</div>
