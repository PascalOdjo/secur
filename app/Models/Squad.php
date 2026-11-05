<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    protected $fillable = ['name', 'contrat_id'];

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }}
