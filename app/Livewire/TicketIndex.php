<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketIndex extends Component
{
    use WithPagination;
    public $selectedTicketId = null;

    // Escuchar el evento emitido desde TicketShow
    protected $listeners = ['refreshTickets' => 'refresh']; // Escucha eventos

    public $estado = null;  // Variable para el filtro de estado
    public $q = null;       // Variable para el filtro de búsqueda

    protected $paginationTheme = 'bootstrap';  // Usar el tema de paginación bootstrap

    public function mount(Request $request)
    {
        // Inicializar las variables si existen en el request
        $this->estado = $request->input('estado');
        $this->q = $request->input('q');
    }

    public function render()
    {
        // Obtener el rol y clase del usuario autenticado
        $userRol = Auth::user()->rol;
        $userClase = Auth::user()->clase;
        $userId = Auth::id();  // ID del usuario autenticado

        // Inicializar la consulta para los tickets
        $tickets = Ticket::query();

        // Filtrar los tickets según el rol del usuario
        if ($userRol == 'usuario') {
            $tickets->where('usuario_id', $userId);
        } elseif ($userClase == 'jefe' || $userRol == 'admin') {
            switch ($userRol) {
                case 'it':
                    $tickets->whereIn('tipo', ['Problemas de Pagina Web']);
                    break;
                case 'facturacion':
                    $tickets->whereIn('tipo', ['Pagos']);
                    break;
                case 'copyright':
                    $tickets->whereIn('tipo', ['Peticion de Copyright', 'Peticion de Takedown']);
                    break;
                case 'desarrollo':
                    $tickets->whereIn('tipo', ['Problemas de lanzamiento', 'Peticion de Actualizacion de Lanzamiento']);
                    break;
                case 'soporte':
                    $tickets->whereIn('tipo', ['Preguntas generales']);
                    break;
                case 'admin':
                    // El admin puede ver todos los tickets, no hay restricciones
                    break;
                default:
                    break;
            }
        } elseif ($userClase == 'empleado') {
            $tickets->where('encargado_id', $userId);
        }

        // Filtrar por estado, si se ha proporcionado
        if ($this->estado) {
            $tickets->where('estado', $this->estado);
        }

        // Filtrar por búsqueda de asunto
        if ($this->q) {
            $tickets->where('asunto', 'like', '%' . $this->q . '%');
        }

        // Obtener los tickets con paginación y pasar los filtros de búsqueda
        $tickets = $tickets->with('user', 'encargado')->paginate(10)->appends(request()->query());

        return view('livewire.ticket-index', [
            'tickets' => $tickets,
            'selectedTicket' => $this->selectedTicketId ? Ticket::find($this->selectedTicketId) : null,
        ]);
    }

    // Este método se llama cuando el usuario hace clic en el botón "Ver"
    public function showTicket($ticketId)
    {
        // Asigna el ticket seleccionado
        // $this->selectedTicketId = $ticketId;
        return $this->redirect(route('tickets.show', $ticketId), navigate: true);

        // Esto hace que Livewire actualice la vista de manera reactiva
        // Puedes usar una propiedad para indicar si deberías mostrar el TicketShow
    }

    // Función para actualizar el estado
    public function setEstado($estado)
    {
        $this->estado = $estado;
        $this->resetPage();  // Reiniciar la paginación cuando se cambie el estado
    }

    // Función de búsqueda
    public function search()
    {
        $this->resetPage();  // Reiniciar la paginación al realizar una búsqueda
    }
}

