<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Slider;
use App\Models\article;
use App\Models\categorie;
use App\Models\SousCategorie;
use App\Models\commander_tee_shirt;
use App\Models\Mode_livraison;
use App\panier;
use App\Models\Marque;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\email;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Commande;
class ClientController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
// public function header(){
//     $users=Auth::user();
//     return view('client/include/Frontend')
//     ->with('users',$users);
// }
   
public function new(){
    $users=Auth::user();
    $categories=categorie::get();
    $marques=Marque::get();
    $SousCategories=SousCategorie::get();
    $articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
    ->join('marques','articles.id_marque','=','marques.id') 
    ->join('categories','sous_categories.id_categorie','=','categories.id') 
    ->where('status',1)
    ->orderBy('articles.created_at','desc')
 //    ->paginate()
    ->get('*');
    return view('client/boutique/grille')->with('categories',$categories)
    ->with('articles',$articles)
    ->with('SousCategories',$SousCategories)
    ->with('marques',$marques)
    ->with('users',$users);
}
    public function boutique(){
        $users=Auth::user();
        $categories=categorie::get();
        $marques=Marque::get();
        $SousCategories=SousCategorie::get();
        // $products = Product::paginate(12);
        $articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                           ->join('marques','articles.id_marque','=','marques.id') 
                           ->join('categories','sous_categories.id_categorie','=','categories.id') 
                           ->where('status',1)
                           
                        //    ->paginate()
                           ->get('*');
                           
                           $count=SousCategorie::join('categories','sous_categories.id_categorie','=','categories.id') 
                        //    ->where('sous_categories.id_categorie','=','categories.id')
                           ->count('sous_categories.id');
        return view('client/boutique/grille')->with('categories',$categories)
                                      ->with('articles',$articles)
                                      ->with('SousCategories',$SousCategories)
                                      ->with('marques',$marques)
                                      ->with('users',$users)
                                      ->with('count',$count);
    }
    public function mode_liste(){
        $users=Auth::user();
        $categories=categorie::get();
        $marques=Marque::get();
        $SousCategories=SousCategorie::get();
        $articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                           ->join('marques','articles.id_marque','=','marques.id') 
                           ->where('status',1)
                           ->get(['articles.*','sous_categories.nom_sous_categorie','marques.nom_marque']);
        $sliders=Slider::where('status',1)->get();
        return view('client/boutique/liste')->with('categories',$categories)
                                      ->with('sliders',$sliders)
                                      ->with('articles',$articles)
                                      ->with('SousCategories',$SousCategories)
                                      ->with('marques',$marques)
                                      ->with('users',$users);
    }
    // public function service(){
    //     $categories=categorie::get();
    //     $articles=article::where('status',1)->get();
    //     $sliders=Slider::where('status',1)->get();
    //     return view('client/service')->with('categories',$categories)->with('sliders',$sliders)->with('articles',$articles);
    // }
    
    ######################### ANNULATION COMMANDE
    public function annuler_commande($id){
        $commander_tee_shirts=commander_tee_shirt::find($id);
        $commander_tee_shirts->status="Annuler";
        $commander_tee_shirts->update();
        return redirect('/commande_teeshirt')->with("activer","l'article"."  ".$commander_tee_shirts->nom. " a été activer avec succés");

    }
    
    ######################### LE CLIENT ACCEPTE DE COMMANDER
    public function commander($id){
        $commander_tee_shirts=commander_tee_shirt::find($id);
        $commander_tee_shirts->status="Commander";
        $commander_tee_shirts->update();
        return redirect('/commande_teeshirt')->with('desactiver',"l'article"."  ".$commander_tee_shirts->nom. " a été desactiver avec succés");
    }
    ################################## BON DE COMMANDE  ################################################
    public function bon_teeshirt (){
        $users=Auth::user();
        // $commander_tee_shirts=commander_tee_shirt::join('mode_livraisons','commander_tee_shirts.id_mode_livraison','=','mode_livraisons.id')
        // ->join('users','commander_tee_shirts.id_user','=','users.id')
        // ->where('commander_tee_shirts.id','=','commander_tee_shirts.id')
        //  ->where('commander_tee_shirts.created_at','=','commander_tee_shirts.created_at')

        $commander_tee_shirts=commander_tee_shirt::join('mode_livraisons','commander_tee_shirts.id_mode_livraison','=','mode_livraisons.id')
                                               ->join('users','commander_tee_shirts.id_user','=','users.id')
        // ->where('Auth::user()','=','Auth::user()->name')
        // ->where('commander_tee_shirts.id_user',Session::get('users.id'))
        ->where('commander_tee_shirts.id_user','=',Auth::user()->id)
      ->get(['*']);
      
    //   Mail::to('abdoulnassseroumarou4@gmail.com')->send(new email());
        return view('client/bon_commandeTeeshirt')->with('commander_tee_shirts',$commander_tee_shirts);
    }
    ######################################## FORMUALAIRE DE COMMANDE ##################################
    public function commande_teeshirt (){
        $users=Auth::user();
        // $users=commander_tee_shirt::findOrFail($id_user);
        $commander_tee_shirts=commander_tee_shirt::get();
        $articles=Article::where('status',1)->get();
        $Mode_livraisons=Mode_livraison::get()->pluck('mode','id');
    //     $Mode_livraisons=commander_tee_shirt::join('mode_livraisons','commander_tee_shirts.id_mode_livraison','=','mode_livraisons.id')
    //   ->get(['commander_tee_shirts.*','mode_livraisons.mode']);
        return view('client/commande_teeshirt')
        ->with('Mode_livraisons',$Mode_livraisons)
        ->with('articles',$articles)
        ->with('commander_tee_shirts',$commander_tee_shirts);
        // ->with('users',$users);
    }
    #############################################################  SAUVEGARDER LA COMMANDE
    public function commande_teeshirt_sauver (Request $request){
        // $users=Auth::user();
        // $users->id_user==Auth::user()->id;
       

        $commander_tee_shirts=new commander_tee_shirt();
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('id'));
        // $users->Auth::user()->id=$request==$commander_tee_shirts->id_user;
        $commander_tee_shirts->id_user=Auth::user()->id;
        // $commander_tee_shirts->id_user=$request->input(Auth::user()->id);
        // $commander_tee_shirts=commander_tee_shirt::find($request->input(Auth::user()->id));
        // $commander_tee_shirts->nom=Auth::user()->name;
        // $commander_tee_shirts->prenom=Auth::user()->first_name;
        // $commander_tee_shirts->email=Auth::user()->email;
        $commander_tee_shirts->couleur=$request->input('couleur');
        $commander_tee_shirts->col=$request->input('col');
        $commander_tee_shirts->taille=$request->input('taille');
        $commander_tee_shirts->modele=$request->input('modele');
        // $commander_tee_shirts->telephone=Auth::user()->telephone;
        $commander_tee_shirts->adresse=$request->input('adresse');
        $commander_tee_shirts->qte=$request->input('qte');
        $commander_tee_shirts->rdv=$request->input('rdv');
        $commander_tee_shirts->note=$request->input('note');
        $commander_tee_shirts->marque=$request->input('marque');
        $commander_tee_shirts->prix=$request->input('prix');
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('id_user'));
        $commander_tee_shirts->nom=$request->input('nom');
        $commander_tee_shirts->prenom=$request->input('prenom');
        $commander_tee_shirts->email=$request->input('email');
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('couleur'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('col'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('taille'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('modele'));
        $commander_tee_shirts->telephone=$request->input('telephone');
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('adresse'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('qte'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('rdv'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('note'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('marque'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('prix'));
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('id_mode_livraison'));
        // $commander_tee_shirts->id_user=$request->input('id_user');

        // $commander_tee_shirts->id_user=$request->input($users);
        // $commander_tee_shirts->$request->id_user==Auth::user()->id;

        $commander_tee_shirts->id_mode_livraison=$request->input('id_mode_livraison');
        // $commander_tee_shirts->id_user=$request->input('id_user');
        if($request->hasFile('modele')){
            $file=$request->file('modele')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('modele')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('modele')->storeAs('public/modele_commande',$fileName);
            $commander_tee_shirts->modele=$fileName;
            $commander_tee_shirts->save();
            }   else{
            $fileName='noimage.jpg';
            $commander_tee_shirts->commander_tee_shirts=$fileName;
            $commander_tee_shirts->save();
            } 
            if($commander_tee_shirts->modele =!'noimage.jpg'){
                Storage::delete(['public/modele_commande/'.$commander_tee_shirts->modele]);
            }
            $commander_tee_shirts->modele=$fileName;
            return redirect(url('/bon_teeshirt'))->with("ajouter","l'article"."".$commander_tee_shirts->nom. " a été ajouter avec succés");
    }
    ##################################################  FORMULAIRE DE MODIFICATION COMMANDE
    public function  commande_teeshirt_edit($id){
        $articles=Article::where('status',1)->get();
        $commander_tee_shirts=commander_tee_shirt::findOrFail($id);
        $Mode_livraisons=Mode_livraison::get()->pluck('mode','id');
        return view('admin/Commande/commande_teeshirt_modifier')
        ->with('Mode_livraisons',$Mode_livraisons)
        ->with('commander_tee_shirts',$commander_tee_shirts)
        ->with('articles',$articles);
    }
    ###############################################################  MODIFICATION DU COMMANDE
    public function  commande_teeshirt_modifier(Request $request){
        $commander_tee_shirts=commander_tee_shirt::find($request->input('id_c'));
        // $commander_tee_shirts->id_user=Auth::user()->id; 
        // $commander_tee_shirts=commander_tee_shirt::find($request->input('name'));
        // $commander_tee_shirts->nom=Auth::user()->name;
        // $commander_tee_shirts->prenom=Auth::user()->first_name;
       
        // $commander_tee_shirts->email=Auth::user()->email;
        $commander_tee_shirts->nom=$request->input('nom');
        $commander_tee_shirts->prenom=$request->input('prenom'); 
        $commander_tee_shirts->email=$request->input('email');
        $commander_tee_shirts->couleur=$request->input('couleur');
        $commander_tee_shirts->col=$request->input('col');
        $commander_tee_shirts->taille=$request->input('taille');
        $commander_tee_shirts->modele=$request->input('modele');
        $commander_tee_shirts->telephone=$request->input('telephone');
        $commander_tee_shirts->adresse=$request->input('adresse');
        $commander_tee_shirts->qte=$request->input('qte');
        $commander_tee_shirts->rdv=$request->input('rdv');
        $commander_tee_shirts->note=$request->input('note');
        $commander_tee_shirts->marque=$request->input('marque');
        $commander_tee_shirts->prix=$request->input('prix');
        $commander_tee_shirts->status="En attente";
        // $commander_tee_shirts->id_user=$request->input('id_user');
        $commander_tee_shirts->id_user=$request->input('id_user');  
        $commander_tee_shirts->id_mode_livraison=$request->input('id_mode_livraison');
        if($request->hasFile('modele')){
            $file=$request->file('modele')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('modele')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('modele')->storeAs('public/modele_commande',$fileName);
            $commander_tee_shirts->modele=$fileName;
            $commander_tee_shirts->save();
            }   else{
            $fileName='noimage.jpg';
            $commander_tee_shirts->commander_tee_shirts=$fileName;
            $commander_tee_shirts->save();
            } 
            if($commander_tee_shirts->modele =!'noimage.jpg'){
                Storage::delete(['public/modele_commande/'.$commander_tee_shirts->modele]);
            }
            $commander_tee_shirts->modele=$fileName;
            $commander_tee_shirts->update();
            return redirect(url('/bon_teeshirt/'.$commander_tee_shirts->id))->with("ajouter","l'article"."  ".$commander_tee_shirts->nom. " a été ajouter avec succés");
    }
    ############################## PAGE SERVICE
    public function service(){
        $categories=categorie::get();
        $Articles=Article::where('status',1)->get();
        $sliders=Slider::where('status',1)->get();
        return view('client/service')->with('categories',$categories)->with('sliders',$sliders)->with('Articles',$Articles);
    }
    // public function boutique(){
    //     $categories=categorie::get();
    //     $Articles=Article::where('status',1)->get();
    //     $sliders=Slider::where('status',1)->get();
    //     return view('client/boutique')->with('categories',$categories)->with('sliders',$sliders)->with('Articles',$Articles);
    // }
    public function panier(){
        $users=Auth::user();
        // $SousCategories=SousCategorie::get();
        // $categories=categorie::get();
        // $articles=article::where('status',1)->get();
        // Si le panier est vide ,renvoi nous au panier
        if(!Session::has('panier')){
            return view('client.panier') ;//->with('categories',$categories)->with('articles',$articles)->with('SousCategories',$SousCategories);
        }   
        // $Articles=Article::get();
        $ancienPanier = Session::has('panier')? Session::get('panier'):null;
        $panier = new panier($ancienPanier);
        return view('client.panier')->with('articles', $panier->articles)
                                     ->with('users',$users);  
    }

    public function favoris(){
        $sliders=Slider::where('status',1)->get();
        $categories=categorie::get();
        $Articles=Article::where('status',1)->get();
        // Si le panier est vide ,renvoi nous au panier
        if(!Session::has('panier')){
            return view('client.favoris')->with('categories',$categories)->with('Articles',$Articles)->with('sliders',$sliders);
        }   
        // $Articles=Article::get();
        $ancienPanier = Session::has('panier')? Session::get('panier'):null;
        $panier = new panier($ancienPanier);
        return view('client.favoris', ['Articles' => $panier->Article]);  
    }
  
    public function paiement(){
         // Si le panier est vide ,renvoi nous au panier
         if(!Session::has('panier')){
            return view('client.panier');
        }
        return view('client.paiement');
    }


    // public function payer(Request $request){
    //       // Si le panier est vide ,renvoi nous au panier
    //       if(!Session::has('panier')){
    //         return view('client.panier');
    //     }
    //     $ancienPanier = Session::has('panier')? Session::get('panier'):null;
    //     $panier = new panier($ancienPanier);
    //     try{
    //             $commande=new Commande();
    //             $commande->nom->$request->input('name');
    //             $commande->adresse->$request->input('address');
    //             $commande->panier->  serialize($panier);
    //             $commande->paiemnt_id=$charge->id;

    //             $commande->save();

    //     } catch(\Exception $e){
    //         //Session::put('error', $e->getMessage());
    //         return redirect('/paiement')->with('error', $e->getMessage());

    // }
     public function payer(Request $request){
         // Si le panier est vide ,renvoi nous au panier
        if(!Session::has('panier')){
            return view('client.panier');
        }
        $ancienPanier = Session::has('panier')? Session::get('panier'):null;
        $panier = new panier($ancienPanier);
        try{
                $commande=new Commande();
                $commande->nom->$request->input('name');
                $commande->adresse->$request->input('address');
                $commande->$request->panier;

                $commande->save();
          

        } catch(\Exception $e){
            //Session::put('error', $e->getMessage());
            return redirect('/paiement')->with('error', $e->getMessage());
        }

        Session::forget('panier');
        Session::put('success', 'Purchase accomplished successfully !');
        return redirect('/panier');
   }

    public function select_par_cat($nom){
        $categories=categorie::get();
        $Articles=Article::where('nom_categorie',$nom)->where('status',1)->get();
        return view('client.shop')->with('categories',$categories)->with('Articles',$Articles);
    }
    public function  Ajouter_au_panier($id){
       $Article=Article::find($id);
       $ancienArticle=Session::has('panier')? Session::get('panier'):null;
       $panier=new panier($ancienArticle);
       $panier->Ajouter($Article,$id);
       Session::put('panier',$panier);
    //    dd(Session::get('panier'));#dd pour afficher ce qui ce trouve dans le 
    return redirect('/index');
    }
    public function  modifier_quantite(Request $request,$id){
        $ancienPanier = Session::has('panier')? Session::get('panier'):null;
        $panier = new panier($ancienPanier);
        $panier->ModifierQuantite($id, $request->input('quantite'));
        Session::put('panier', $panier);
        return redirect('/panier');
     }

     public function retirer_Article($id){
        $ancienPanier = Session::has('panier')? Session::get('panier'):null;
        $panier = new panier($ancienPanier);
        $panier->SupprimerArticle($id);
       
        if(count($panier->articles) > 0){
            Session::put('panier', $panier);
        }
        else{
            Session::forget('panier');
        }

        return redirect('/panier');
    }
    
   
}
