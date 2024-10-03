<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    // Définir les champs pouvant être assignés en masse
    protected $fillable = [
        'demande_id',
        'total_amount',
        'agent_payment',
        'agency_payment',
        'status',
        'vacation_id'
    ];
    public function vacation(){
        return $this->belongsTo(Vacation::class);
    }

    public function agents(){
        return $this->hasMany(Agent::class);
    }
}
