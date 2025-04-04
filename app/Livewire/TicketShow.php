<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;

class TicketShow extends Component
{
    public $ticket;
    public $estado;
    public $prioridad;
    public $tipo;
    public $comentario;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->estado = $ticket->estado;
        $this->prioridad = $ticket->prioridad;
        $this->tipo = $ticket->tipo;
        $this->comentario = $ticket->comentario;

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
            'tiposPorRol' => $this->tiposPorRol
        ]);
    }
}
