<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contrat extends Model
{
    use HasFactory;
    protected $fillable = [
        'demandei_id',
        'type',
        'nombre_agents',
        'nombre_contrats_journee_entiere',
        'nombre_contrats_demi_journee',
        'valeur_exploitation',
        'valeur_tresorerie',
        'statut',
    ];
}