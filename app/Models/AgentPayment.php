<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'vacation_id',
        'date',
        'amount',
        'status',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function vacation()
    {
        return $this->belongsTo(Vacation::class);
    }
}
