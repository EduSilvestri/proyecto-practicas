<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeTicketForm extends Component
{
    use WithFileUploads;

    // Propiedades para enlazar con el formulario
    public $usuario_id;
    public $nombre;
    public $email;
    public $asunto;
    public $tipo;
    public $descripcion;
    public $screenshot;  // Captura de pantalla en base64
    public $archivos = []; // Para múltiples archivos (imágenes)

    // Reglas de validación
    protected $rules = [
        'asunto' => 'required|string|max:255',
        'tipo' => 'required|string',
        'descripcion' => 'required|string',
        'archivos.*' => 'file|max:10240', // Máximo 10MB por archivo
    ];

    // Inicializa los datos del usuario autenticado
    public function mount()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Acceso denegado. Inicia sesión para continuar.');
        }
        $this->usuario_id = $user->id;
        $this->nombre = $user->name;
        $this->email = $user->email;
    }

    // Procesa el envío del formulario
    public function submit()
{
    // Validar los datos según las reglas definidas
    $this->validate();
    

    $archivosPaths = [];

    // Procesa los archivos subidos (si existen)
    if ($this->archivos) {
        foreach ($this->archivos as $archivo) {
            // Mover el archivo a la carpeta deseada
            $path = $archivo->store('tickets', 'public');
            $archivosPaths[] = $path;
        }
    }

    // Procesa la captura de pantalla (si se envía)
    if ($this->screenshot) {
        if (preg_match('/^data:image\/(\w+);base64,/', $this->screenshot, $type)) {
            $this->screenshot = substr($this->screenshot, strpos($this->screenshot, ',') + 1);
            $type = strtolower($type[1]);
            $this->screenshot = base64_decode($this->screenshot);
            if ($this->screenshot === false) {
                session()->flash('error', 'La captura de pantalla no es válida.');
                return;
            }
            $screenshotName = 'tickets/' . uniqid() . '.' . $type;
            Storage::disk('public')->put($screenshotName, $this->screenshot);
            $archivosPaths[] = $screenshotName;
        }
    }

    // Crea el ticket y guarda las rutas de los archivos adjuntos
    $ticket = Ticket::create([
        'usuario_id'  => $this->usuario_id,
        'asunto'      => $this->asunto,
        'tipo'        => $this->tipo,
        'descripcion' => $this->descripcion,
        'estado'      => 'abierto',
        'prioridad'   => 'media',
        'archivos'    => !empty($archivosPaths) ? json_encode($archivosPaths) : null,
    ]);

    // Reinicia los campos del formulario (excepto los de usuario)
    $this->reset(['asunto', 'tipo', 'descripcion', 'screenshot', 'archivos']);

    // Muestra un mensaje de éxito
    session()->flash('exito', 'Ticket creado correctamente.');

    // Redirige a la vista show del ticket recién creado
    return redirect()->route('tickets.show', $ticket->id);
}


    public function render()
    {
        return view('livewire.home-ticket-form');
    }
}


