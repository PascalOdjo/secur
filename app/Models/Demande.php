<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = [
        'client_id',
        'site_id',
        'description',
        'nombre_agents',
        'type_vacation',
        'montant',
        'status',
        'start_date',
        'end_date',
        'valeur_base',
        'prix_par_agent',
        'valeur_contrat',
        'montant_brut',
        'montant_exploitation',
        'montant_tresorerie',
        'status_validation',
        'montant_par_agent',
        'salaire_par_agent',
        'montant_par_vacation',
    ];

    // Valeur par défaut pour le champ type_vacation
    protected $attributes = ['type_vacation' => 'sys_12'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
