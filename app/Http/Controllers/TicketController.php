<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    
    public function index()
    {
        $tickets = Ticket::where('usuario_id', Auth::id())->paginate(10);
        return view('tickets.index', compact('tickets'));
    }

    
    public function create()
    {
        return view('tickets.create');
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'usuario_id'  => 'required|exists:users,id',
            'asunto'      => 'required|string|max:255',
            'tipo'        => 'required|string',
            'descripcion' => 'required|string',
            // Aquí podrías validar archivos si lo necesitas
        ]);
    
        // Asigna un estado por defecto y prioridad si es necesario
        $data['estado'] = 'abierto';
        $data['prioridad'] = 'media';

        if ($request->hasFile('archivos')) {
            $archivos = [];
            foreach ($request->file('archivos') as $archivo) {
                // Guarda el archivo en la carpeta "tickets" dentro del disco "public"
                $path = $archivo->store('tickets', 'public');
                $archivos[] = $path;
            }
            // Guarda las rutas de los archivos en formato JSON
            $data['archivos'] = json_encode($archivos);
        }
    
        Ticket::create($data);
    
        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente.');
    }
    

    
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'estado' => 'required|in:abierto,en_progreso,cerrado',
            'prioridad' => 'required|in:baja,media,alta'
        ]);
        $ticket->update($request->all());

        return redirect()->route('tickets.index')->with('exito','Ticket actualizado correctamente.');
    }

    
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('exito', 'Ticket eliminado correctamente.');
    }
}
