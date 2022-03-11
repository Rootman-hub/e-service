<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SousCategorie;
use App\Models\categorie;
use Illuminate\Support\Facades\DB;

class SousCategorieController extends Controller
{
   public function ajouterSousCategorie(){
         $categorie=categorie::get()->pluck('nom_categorie','id');
        return view('admin/SousCategorie/ajouterSousCategorie')->with('categorie',$categorie);
    }
    public function sauverSousCategorie(Request $request){
        // $this->validate($request,['nom_sous_cat'=>'required|unique:categories']);
        $SousCategorie=new SousCategorie();
        $SousCategorie->nom_sous_categorie=$request->input('nom_sous_categorie');
        $SousCategorie->id_categorie=$request->input('id_categorie');
        $SousCategorie->save();
        return redirect('/AfficherSousCategorie')->with('status','la sous categorie '.$SousCategorie->nom_sous_categorie.'a été ajouter avec succés');
    }
    public function modifier_SousCategorie($id){
        $SousCategories=SousCategorie::find($id);
        $Categories=Categorie::get()->pluck('nom_categorie','id');
        return view('admin/SousCategorie/ModifierSousCategorie')->with('SousCategories',$SousCategories)->with('Categories',$Categories);;
    }
    public function ModifierSousCategorie(Request $request){
        // $this->validate($request,['nom_categorie'=>'required|unique:categories']);
       
        $SousCategorie=SousCategorie::find($request->input('id'));
        $SousCategorie->nom_sous_categorie=$request->nom_sous_categorie;
        $SousCategorie->id_categorie=$request->input('id_categorie');
        $SousCategorie->update();
        return redirect('/AfficherSousCategorie')->with('status','la categorie '.$SousCategorie->nom_sous_categorie.'a été modifier avec succés');
    }
    public function SupprimereSousCategorie($id){
        $categorie=SousCategorie::find($id);
        $categorie->delete();
        return redirect('/AfficherSousCategorie')->with('status','la categorie '.$categorie->nom_sous_categorie.'a été supprimer avec succés');
    }
    #---------------------- END CRUD ---------------------------------------------#

    // afficher la liste des sous des categories
    public function AfficherSousCategorie(){
        // $SousCategories=DB::table('sous_categories')
        // sous_categories.id_categories as id_categorie
                        // ->select('categories.*','sous_categories.*')
                        // ->join('categories','sous_categories.id_categorie','=','categories.id')
                        // ->get(['*']);
        // $SousCategories=SousCategorie::get();
        // $Categories=categorie::where('nom_categorie','nom_categorie');   
        $SousCategories=SousCategorie::join('categories','sous_categories.id_categorie','=','categories.id') 
               ->get(['sous_categories.*','categories.nom_categorie']);
         return view('admin/SousCategorie/AfficherSousCategorie')->with('SousCategories', $SousCategories); 
     }
}
