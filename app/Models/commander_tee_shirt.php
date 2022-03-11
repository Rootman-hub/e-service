<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commander_tee_shirt extends Model
{
    protected $primaryKey='id_c';
    // use Hashidable;  use HasHashSlug;
    // protected $appends = ['hashid'];
    protected $Attribut=['nom',
    'id_c',
    'prenom',
    'email',
    'couleur',
    'col',
    'taille',
    'modele',
    'qte',
    'note',
    'rdv',
    'marque',
    'prix',
    // 'id_user',
    'id_mode_livraison',
    'id_user'
];
public function users(){
return $this->belongsTo('App\Models\users');
}
public function User(){
    return $this->belongsTo('App\Models\User');
    }
public function Mode_livraison(){
return $this->belongsTo('App\Models\Mode_livraison');
}

// public function getHashidAttribute()
// {
//     return Hashids::encode($this->attributes['id']);
// }
}
