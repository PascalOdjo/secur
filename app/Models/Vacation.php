<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_vacation',
        'type_vacation',
        'shift',
        'agent_1_id',
        'agent_2_id',
        'start_time',
        'end_time',
        'status',
        'site_id',
    ];

    public function agent1(){
        return $this->belongsTo(Agent::class, 'agent_1_id');
    }
    public function agent2(){
        return $this->belongsTo(Agent::class, 'agent_2_id');
    }

    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function invoice(){
        return $this->hasOne(Invoice::class);
    }
}
