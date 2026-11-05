<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contrat extends Model
{
    use HasFactory;
    protected $fillable = [
        'demande_id',
        'agent_id',
        'vacation_id',
        'group',
        'sub_pair',
        'code',
        'type',
        'is_real',
        'nombre_agents',
        'nombre_contrats_journee_entiere',
        'nombre_contrats_demi_journee',
        'valeur_exploitation',
        'valeur_tresorerie',
        'statut',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function vacation()
    {
        return $this->belongsTo(Vacation::class);
    }
}
