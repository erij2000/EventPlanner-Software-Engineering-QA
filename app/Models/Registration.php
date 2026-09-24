<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // Autoriser le mass-assignment pour ces champs
    protected $fillable = [
        'user_id',
        'event_id',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec l'événement
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
