<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categorie;

class categorieController extends Controller
{
    public function ajouterCategorie(){
        return view('admin/Categories/Ajouter_categorie');
    }
  
    public function modifier_categorie($id){
        // $categorie=DB::table('categories')
        $categories=categorie::findOrFail($id);
        //           ->select('categories.nom_categorie')
        //           ->get();
        return view('admin/Categories/Modifier_categorie')->with('categories',$categories);
    }
    public function modifierCategorie(Request $requette){
        $this->validate($requette,['nom_categorie'=>'required|unique:categories']);
        $categorie=categorie::find($requette->input('id'));
        $categorie->nom_categorie=$requette->nom_categorie;
        $categorie->update();
        return redirect('/Afficher_categorie')->with('modifier','la categorie '.$categorie->nom_categorie.'a été modifier avec succés');
    }
    public function SupprimerCategorie($id){
        $categorie=categorie::find($id);
        $categorie->delete();
        return redirect('/Afficher_categorie')->with('supprimer','la categorie '.$categorie->nom_categorie.'a été supprimer avec succés');
    }
    public function sauvergarderCategorie(Request $request){
        $this->validate($request,['nom_categorie'=>'required|unique:categories']);
        $categorie=new categorie();
        $categorie->nom_categorie=$request->input('nom_categorie');
        $categorie->save();
        return redirect('/Afficher_categorie')->with('ajouter','la categorie '.$categorie->nom_categorie.'a été ajouter avec succés');
    }
    #---------------------- END CRUD ---------------------------------------------#
    public function Afficher_categorie(){
        $categorie=categorie::get();
         return view('admin/Categories/Afficher_categorie')->with('categorie', $categorie);
     }
}
