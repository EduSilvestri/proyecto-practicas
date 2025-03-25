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
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:baja,media,alta'
        ]);

        Ticket::create([
            'usuario_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => 'abierto',
            'prioridad' => $request->prioridad,
        ]);
        return redirect()->route('ticket.index')->with('exito','Ticket creado correctamente.');
    }

    
    public function show(Ticket $ticket)
    {
        return view('ticket.show', compact('ticket'));
    }

    
    public function edit(Ticket $ticket)
    {
        return view('ticket.edit', compact('ticket'));
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

        return redirect()->route('ticket.index')->with('exito','Ticket actualizado correctamente.');
    }

    
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('exito', 'Ticket eliminado correctamente.');
    }
}
