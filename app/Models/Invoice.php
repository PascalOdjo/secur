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

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function vacation()
    {
        return $this->belongsTo(Vacation::class);
    }

    public function getAgentsAttribute()
    {
        if (!$this->demande) return collect();
        
        return Agent::whereIn('id', function($query) {
            $query->select('agent_id')
                  ->from('contrats')
                  ->where('demande_id', $this->demande_id)
                  ->whereNotNull('agent_id');
        })->get();
    }
}
