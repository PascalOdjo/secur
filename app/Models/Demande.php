<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = ['client_id', 'site_id', 'description', 'nombre_agents', 'type_vacation', 'status'];

    // Valeur âr defaut pour le champ type_vacation
    protected $attributes = ['type_vacation' => 'sys_12'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
