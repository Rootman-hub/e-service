<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marque;
use App\Models\SousCategorie;
use App\Models\article;
use App\Http\Traits\Hashidable;

class article extends Model
{
    use Hashidable;
    protected $cryp=['hashed_id'];
    protected $Attribut=['nom_article',
                         'prix_article',
                         'image1_article',
                         'image2_article',
                         'image3_article',
                         'image4_article',
                         'description_article',
                         'caraterisque_article',
                         'poid_article',
                         'taille_tee_shirt',
                         'col_tee_shirt',
                         'pilage_brochure',
                         'relire_brochure',
                         'couleur',
                         'type_papier',
                         'type_impression',
                         'type_plascification',
                         'format_papier',
                         'Nb_page_depliant',
                         'Largeur',
                         'Hateur',
                         'status',
                         'id_sous_categorie',
                         'id_marque',
                ];

    public function SousCategorie(){
        return $this->belongsTo('App\Models\SousCategorie');
    }
    public function Marque(){
        return $this->belongsTo('App\Models\Marque');
    }
    public function getHashedIdAttribute($value){
        return \Hashids::connection(get_called_class())->encode($this->getKey());
    }

}
