<div>
    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="actualizar">
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
                        <select wire:model="estado" class="border rounded p-2 w-full">
                            <option value="abierto">Abierto</option>
                            <option value="en_progreso">En Progreso</option>
                            <option value="cerrado">Cerrado</option>
                        </select>

                        @if($estado === 'cerrado')
                            <div class="mt-4">
                                <label class="text-white">Comentario de Cierre</label>
                                <textarea wire:model="comentario" class="border rounded p-2 w-full"></textarea>
                            </div>
                        @endif
                    </td>
                    <td class="border p-2 text-center">
                        <select wire:model="prioridad" class="border rounded p-2 w-full">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </td>
                    <td class="border p-2 text-center">
                        <select wire:model="tipo" class="border rounded p-2 w-full">
                            <option value="soporte">Soporte</option>
                            <option value="facturacion">Facturación</option>
                            <option value="it">IT</option>
                        </select>
                    </td>
                    <td class="border p-2 text-center text-white">{{ $ticket->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 text-center">
            <button type="submit" class="px-6 py-2 bg-lujoYel text-black font-semibold rounded-lg hover:bg-blue-800 transition">
                Guardar cambios
            </button>
        </div>
    </form>
</div>
