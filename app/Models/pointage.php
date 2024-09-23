<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pointage extends Model
{
    use HasFactory;
    protected $fillable = ['vacation_id', 'site_id', 'status', 'debut_vacation', 'fin_vacation'];

    public function vacation(){
        return $this->belongsTo(Vacation::class);
    }

    public function site(){
        return $this->belongsTo(Site::class);
    }
}
