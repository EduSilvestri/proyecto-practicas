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
        'comentario',
        'encargado_id'
    ];

    // Relación con el usuario que creó el ticket
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function encargado()
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function ticketChanges()
    {
        return $this->hasMany(TicketChange::class);
    }

    public function recordChange(User $user, string $changeType, ?string $oldValue, ?string $newValue)
{
    return $this->ticketChanges()->create([
        'user_id' => $user->id,
        'change_type' => $changeType,
        'old_value' => $oldValue,
        'new_value' => $newValue
    ]);
}

public function getArchivosAdjuntosAttribute()
{
    if (empty($this->archivos)) {
        return [];
    }
    
    // Decodificar el JSON y asegurarse de que es un array
    $archivos = json_decode($this->archivos, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Si no es JSON válido, tratar como string simple
        $archivos = [$this->archivos];
    }
    
    // Filtrar y mapear a URLs válidas
    return collect($archivos)->filter()->map(function ($archivo) {
        // Eliminar comillas si existen
        $archivo = trim($archivo, '"\'');
        
        return [
            'path' => $archivo,
            'url' => asset('storage/'.$archivo),
            'exists' => Storage::disk('public')->exists($archivo)
        ];
    })->toArray();
}
    
}
