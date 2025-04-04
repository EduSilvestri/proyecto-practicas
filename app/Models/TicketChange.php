<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketChange extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'change_type',
        'old_value',
        'new_value',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
