<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class site extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address'];

    public function vacation(){
        return $this->hasMany(Vacation::class);
    }
}
