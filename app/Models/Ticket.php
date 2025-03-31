<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id', 
        'asunto',
        'tipo',
        'descripcion',
        'estado',
        'prioridad',
        'archivos',
        'comentario'
    ];

    // Relación con el usuario que creó el ticket
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function ticketChanges()
    {
        return $this->hasMany(TicketChange::class);
    }

    
}
