<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marque;
use App\Models\article;

class Marque extends Model
{
    public function article(){
        return $this->hasMany('App\Models\article');
    }
}
