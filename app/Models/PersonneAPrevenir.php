<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonneAPrevenir extends Model
{
    protected $table = 'personne_a_prevenir'; // Spécifiez le nom de la table si nécessaire  
    protected $fillable = ['nom', 'prenom', 'contact', 'profession', 'adresse', 'agent_id'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
