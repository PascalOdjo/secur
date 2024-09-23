<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enregistrement extends Model
{
    use HasFactory;

    // Définir la table associée (si différente de 'enregistrements')
    protected $table = 'enregistrements';

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'entreprise',
        'photo_passport',
        'site_name',
        'site_address',
        'nombre_contrat',
        'type_vacation',
        'shift',
    ];

    // Si vous avez besoin de définir des relations, vous pouvez le faire ici
    // Par exemple, si un enregistrement appartient à un client ou à un site
    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function site() {
        return $this->belongsTo(Site::class);
    }
}
