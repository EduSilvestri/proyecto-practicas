<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    
    public function index(Request $request)
    {
        // Obtener el rol del usuario autenticado
        $userRol = Auth::user()->rol;
        $userId = Auth::id(); // ID del usuario autenticado
    
        // Filtrar los tickets basados en el rol del usuario
        $tickets = Ticket::query();
    
        // Si el rol es "usuario", solo puede ver sus propios tickets
        if ($userRol == 'usuario') {
            $tickets->where('usuario_id', $userId);
        } else {
            // Filtrado según el rol
            switch ($userRol) {
                case 'it':
                    $tickets->whereIn('tipo', ['Problemas de Pagina Web']); // Solo puede ver 'Problemas de Pagina Web'
                    break;
                case 'finanzas':
                    $tickets->whereIn('tipo', ['Pagos']); // Solo puede ver 'Pagos'
                    break;
                case 'copyright':
                    $tickets->whereIn('tipo', ['Peticion de Copyright', 'Peticion de Takedown']); // Solo puede ver 'Peticion de Copyright' y 'Peticion de Takedown'
                    break;
                case 'contenidos':
                    $tickets->whereIn('tipo', ['Problemas de lanzamiento', 'Peticion de Actualizacion de Lanzamiento']); // Solo puede ver 'Problemas de Lanzamiento' y 'Peticion de Actualizacion de Lanzamiento'
                    break;
                case 'atencion':
                    $tickets->whereIn('tipo', ['Preguntas generales']); // Solo puede ver 'Preguntas Generales'
                    break;
                case 'admin':
                    // El admin puede ver todos los tickets, no hay restricciones
                    break;
                default:
                    // Si el rol no coincide con ninguno de los anteriores, puede que no vean ningún ticket o todos dependiendo de lo que necesites.
                    break;
            }
        }
    
        // Agregar el filtro de estado si se proporciona
        if ($request->filled('estado')) {
            $tickets->where('estado', $request->input('estado'));
        }
    
        // Obtener los tickets según los filtros y paginarlos
        $tickets = $tickets->with('user')->paginate(10)->appends($request->query());
    
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
        $data['estado'] = 'esperando';
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
    
        $ticket = Ticket::create($data);
    
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket creado correctamente.');
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
        $validatedData = $request->validate([
            // 'titulo' => 'required',        
            // 'descripcion' => 'required',   
            'estado' => 'required',
            'prioridad' => 'required',
            'tipo' => 'required',
        ]);
    
        // Actualizas sólo los campos modificables
        $ticket->estado = $validatedData['estado'];
        $ticket->prioridad = $validatedData['prioridad'];
        $ticket->tipo = $validatedData['tipo'];
        $ticket->save();
    
        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado correctamente.');
    }

    
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('exito', 'Ticket eliminado correctamente.');
    }
}
