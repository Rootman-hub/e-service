<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\article;
use App\Models\Slider;
use App\Models\categorie;
use App\Models\Marque;
use App\Models\SousCategorie;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;

class header extends Controller
{
    public $search;
    public $sous_categories;
    public $id_sous_categorie;
    public function mount()
    {
        // $this->$sous_categories = 'Catégories';
        // $this->fill(request()->only('search','sous_categories','id_sous_categorie'));
        // return view('client.header')->with('sous_categories',$sous_categories);
    }
    public function rechercher()
    {
        $categories=categorie::get();
        $marques=Marque::get();
        $SousCategories=SousCategorie::get();
        $articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                           ->join('marques','articles.id_marque','=','marques.id') 
                           ->join('categories','sous_categories.id_categorie','=','categories.id') 
                           ->where('nom_article','like','%'.$this->search.'%')
                           ->where('id_sous_categorie',$this->id_sous_categorie)
                           ->where('status',1)
                           ->get(['*']);
        $sliders=Slider::where('status',1)->get('*');
        return view('client/boutique/grille')->with('categories',$categories)
                                      ->with('sliders',$sliders)
                                      ->with('articles',$articles)
                                      ->with('SousCategories',$SousCategories)
                                      ->with('marques',$marques);
    }
}
