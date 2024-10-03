<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class site extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'client_id'];

    public function vacation(){
        return $this->hasMany(Vacation::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
