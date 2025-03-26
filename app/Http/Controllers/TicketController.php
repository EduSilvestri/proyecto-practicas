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

        $archivos = [];

        // Procesa los archivos adjuntos enviados a través del input "archivos[]"
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $path = $archivo->store('tickets', 'public');
                $archivos[] = $path;
            }
        }
    
        // Procesa la captura de pantalla enviada en el campo "screenshot"
        if ($request->filled('screenshot')) {
            // El dato viene con el prefijo "data:image/png;base64,...."
            $screenshotData = $request->input('screenshot');
            if (preg_match('/^data:image\/(\w+);base64,/', $screenshotData, $type)) {
                $screenshotData = substr($screenshotData, strpos($screenshotData, ',') + 1);
                $type = strtolower($type[1]); // p.ej. png
                $screenshotData = base64_decode($screenshotData);
                if ($screenshotData === false) {
                    return back()->withErrors(['screenshot' => 'La captura no es válida.']);
                }
            } else {
                return back()->withErrors(['screenshot' => 'Formato de captura inválido.']);
            }
            // Guarda la imagen en "public/tickets" con un nombre único
            $screenshotName = 'tickets/' . uniqid() . '.' . $type;
            \Storage::disk('public')->put($screenshotName, $screenshotData);
            $archivos[] = $screenshotName;
        }
    
        // Si se han subido archivos o se generó una captura, guarda las rutas como JSON
        if (count($archivos) > 0) {
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
