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
    public $ticketId;
    public $ticket;
    public $estado;
    public $prioridad;
    public $tipo;
    public $comentario;
    public $usuariosMismoRol;
    public $files;

    // Cambiar el tipo de parámetro a solo ID del ticket
    public function mount($ticketId)
    {
        // Asignar el ID y cargar el ticket con el ID
        $this->ticketId = $ticketId;
        $this->ticket = Ticket::find($ticketId);

        // Verificar si el ticket existe
        if ($this->ticket) {
            $this->estado = $this->ticket->estado;
            $this->prioridad = $this->ticket->prioridad;
            $this->tipo = $this->ticket->tipo;
            $this->comentario = $this->ticket->comentario;
            $this->files = is_array($this->ticket->archivos) ? $this->ticket->archivos : explode(',', $this->ticket->archivos); // Convertir a array si es necesario
        }

        // Lógica de roles (igual que antes)
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
            'admin' => [], // El admin tiene acceso a todos los tickets
        ];

        $rolActual = Auth::user()->rol;

        $this->usuariosMismoRol = User::where('rol', $rolActual)
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

        $this->ticket->update([
            'estado' => $this->estado,
            'prioridad' => $this->prioridad,
            'tipo' => $this->tipo,
            'comentario' => $this->comentario,
        ]);

        session()->flash('message', '¡Ticket actualizado correctamente!');
    }


    public function render()
    {
        return view('livewire.ticket-show', [
            'roles' => $this->roles,
            'tiposPorRol' => $this->tiposPorRol,
            'usuariosMismoRol' => $this->usuariosMismoRol,
            'files' => $this->files
        ]);
    }
}
