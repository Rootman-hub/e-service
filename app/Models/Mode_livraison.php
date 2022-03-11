<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\commander_tee_shirt;
class Mode_livraison extends Model
{
    public function commander_tee_shirt(){
        return $this->hasMany('App\Models\commander_tee_shirt');
    }
}
