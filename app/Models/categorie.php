<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\categorie;
use App\Models\SousCategorie;

class categorie extends Model
{
    public function SousCategorie(){
        return $this->hasMany('App\Models\SousCategorie');
    }
}
