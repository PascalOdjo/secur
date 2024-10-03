<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'entreprise',
    ];

    public function site()
    {
        return $this->hasMany(Site::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
