<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;

class TicketShow extends Component
{
    public Ticket $ticket; // Usamos el modelo directamente
    public $estado;
    public $prioridad;
    public $tipo;
    public $comentario;
    public $usuariosMismoRol;
    public $files = [];
    public $encargado_id;
    public $messageContent = ''; // Para almacenar el mensaje nuevo
    public $messages = []; // Para almacenar los mensajes existentes
    
    // Definimos las propiedades para roles y tipos
    public $roles = [];
    public $tiposPorRol = [];

    public function mount($ticketId)
    {
        $this->ticket = Ticket::findOrFail($ticketId);
        $this->loadTicketData();
        $this->loadRolesAndTypes();
        $this->loadUsersSameRole();
        $this->encargado_id = $this->ticket->encargado_id;
        $this->loadMessages();
    }

    protected function loadMessages()
{
    $this->messages = $this->ticket->messages()
        ->with('user')
        ->latest()
        ->get()
        ->toArray();
}

    protected function loadTicketData()
    {
        $this->estado = $this->ticket->estado;
        $this->prioridad = $this->ticket->prioridad;
        $this->tipo = $this->ticket->tipo;
        $this->comentario = $this->ticket->comentario;
        
        // Procesamiento seguro de archivos
        $this->files = $this->ticket->archivos 
            ? (is_array($this->ticket->archivos) 
                ? $this->ticket->archivos 
                : explode(',', $this->ticket->archivos))
            : [];
    }

    public function enviarMensaje()
{
    $this->validate([
        'messageContent' => 'required|string|max:1000'
    ]);

    // Crear el mensaje
    $message = $this->ticket->messages()->create([
        'user_id' => auth()->id(),
        'content' => $this->messageContent
    ]);

    // Cargar relación de usuario
    $message->load('user');

    // Agregar el nuevo mensaje al array
    $this->messages = collect($this->messages)
        ->prepend($message->toArray())
        ->all();

    // Limpiar el campo de mensaje
    $this->messageContent = '';

    // Opcional: Desplazarse al nuevo mensaje
    $this->dispatch('scrollToMessage');
}

    public function asignarEncargado()
    {
        $this->validate([
            'encargado_id' => 'required|exists:users,id'
        ]);
    
        // Obtener nombres antes de actualizar
        $oldEncargadoName = $this->ticket->encargado ? $this->ticket->encargado->name : 'Ninguno';
        $newEncargado = User::find($this->encargado_id);
        
        // Guardar el ID original para comparación
        $oldEncargadoId = $this->ticket->encargado_id;
    
        // Actualizar el ticket
        $this->ticket->update([
            'encargado_id' => $this->encargado_id
        ]);
    
        // Solo registrar cambio si realmente hubo modificación
        if ($oldEncargadoId != $this->encargado_id) {
            $this->ticket->recordChange(
                Auth::user(),
                'encargado',
                $oldEncargadoName,
                $newEncargado->name
            );
        }
    
        return $this->redirect(route('tickets.index'), navigate: true);
    }

    protected function loadRolesAndTypes()
    {
        $this->roles = [
            'it' => 'IT',
            'facturacion' => 'Facturación',
            'copyright' => 'Copyright',
            'desarrollo' => 'Desarrollo',
            'soporte' => 'Soporte',
        ];

        $this->tiposPorRol = [
            'it' => ['Problemas de Pagina Web'],
            'facturacion' => ['Pagos'],
            'copyright' => ['Peticion de Copyright', 'Peticion de Takedown'],
            'desarrollo' => ['Problemas de lanzamiento', 'Peticion de Actualizacion de Lanzamiento'],
            'soporte' => ['Preguntas generales'],
            'admin' => [],
        ];
    }

    protected function loadUsersSameRole()
    {
        $this->usuariosMismoRol = User::where('rol', Auth::user()->rol)
                                    ->where('clase', 'empleado')
                                    ->get();
    }

    public function actualizar()
{
    $this->validate([
        'estado' => 'required',
        'prioridad' => 'required',
        'tipo' => 'required',
        'comentario' => $this->estado === 'cerrado' ? 'required' : 'nullable'
    ]);

    // Guardar valores antiguos antes de actualizar
    $oldEstado = $this->ticket->estado;
    $oldPrioridad = $this->ticket->prioridad;
    $oldTipo = $this->ticket->tipo;

    $this->ticket->update([
        'estado' => $this->estado,
        'prioridad' => $this->prioridad,
        'tipo' => $this->tipo,
        'comentario' => $this->estado === 'cerrado' ? $this->comentario : null,
    ]);

    // Registrar cambios en el historial
    if ($oldEstado !== $this->estado) {
        $this->ticket->recordChange(
            Auth::user(),
            'estado',
            $oldEstado,
            $this->estado
        );
    }

    if ($oldPrioridad !== $this->prioridad) {
        $this->ticket->recordChange(
            Auth::user(),
            'prioridad',
            $oldPrioridad,
            $this->prioridad
        );
    }

    if ($oldTipo !== $this->tipo) {
        $this->ticket->recordChange(
            Auth::user(),
            'tipo',
            $oldTipo,
            $this->tipo
        );
    }

    // Redirigir a la lista de tickets después de guardar
    return $this->redirect(route('tickets.index'), navigate: true);
}
    public function volverALaLista()
    {
        // Opción 1: Redirección SPA (recomendado)
        return $this->redirect(route('tickets.index'), navigate: true);
        
        // Opción 2: Emitir evento (alternativa)
        // $this->dispatch('showTicketIndex');
    }

    public function render(): View
    {
        return view('livewire.ticket-show');
    }
}