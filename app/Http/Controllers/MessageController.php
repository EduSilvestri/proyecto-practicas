<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class MessageController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);
    
        $message = $ticket->messages()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);
    
        
    
        return back()->with('success', 'Mensaje enviado correctamente.');
    }
    
    

}
