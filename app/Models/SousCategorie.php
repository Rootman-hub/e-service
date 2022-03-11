<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\categorie;
use App\Model\article;

class SousCategorie extends Model
{
    protected $Attribut=['nom_sous_categorie','id_categorie' ];

    public function article(){
        return $this->hasMany('App\Models\article');
    }

    public function categorie(){
        // $SousCategorie = SousCategorie::find(1)->SousCategorie;
        return $this->belongsTo('App\Models\categorie');
    }
}
