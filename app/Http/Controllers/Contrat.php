<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    protected $fillable = [
        'demande_id',
        'type',
        'nombre_agents',
        'valeur_exploitation',
        'valeur_tresorerie',
        'statut',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}