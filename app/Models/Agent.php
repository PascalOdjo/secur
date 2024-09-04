<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'addresse',
        'sexe',
        'nationalite',
        'taille',
        'type_contrat',
        'date_debut_contrat',
        'date_fin_contrat',
        'carte_identite',
        'passport_photo',
        'casier_judiciaire',
        'certificat_naissance',
        'certificat_medical',
        'permit_residence',
        'role',
        'status',
        'password',
        'created_at',
        'updated_at',
        
    ];
    
}
