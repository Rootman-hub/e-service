<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\commander_tee_shirt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\image;
use App\Models\categorie;
use App\Models\User;
use App\Models\article;
use App\Models\Slider;
use App\Models\SousCategorie;
// use App\Http\Controllers\Auth;

class admin extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    

    public function index(Request $users){
        /* Je reuisi mon test 
        * super !
        *pt** cette m'appris 1h de traille
        * (condition si utilisateur est connecter)
        *@Abdoulnasser
        */
        if ($users=Auth::user()){
            $tee_shirt_simples=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                    ->join('marques','articles.id_marque','=','marques.id')
                                    ->where('sous_categories.nom_sous_categorie','=','Tee-shirte-simple')
                                    ->get(['*']);
        $coque_telephones=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                    ->join('marques','articles.id_marque','=','marques.id')
                                    ->where('sous_categories.nom_sous_categorie','=','Coque telephone')
                                    ->get(['*']);                            

        $categories=categorie::get();
        $articles=article::where('status',1)->get();

        $informatiques=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','informatique')
                                ->get(['*']);

        $alimentations=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','Alimentation')
                                ->get(['*']);

        $imprimantes=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','Imprimante')
                                ->get(['*']);

        $baffes=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','Baffe+Bluetooth	')
                                ->get(['*']);

        $outils=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','Outils')
                                ->get(['*']);

        $PCS=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('sous_categories.nom_sous_categorie','=','PC')
                                ->get(['*']);

        $Divers=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('sous_categories.nom_sous_categorie','Clé USB')
                                ->get(['*']);

        $impressions=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','Impression')
                                ->get(['*']);

        $Stokages=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','Stokages')
                                ->get(['*']);

        $offre_du_jours=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','Impression')
                                ->get(['*']);

        $SousCategories=SousCategorie::get();

        $teeshirts=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                            ->join('categories','sous_categories.id_categorie','=','categories.id')
                            ->join('marques','articles.id_marque','=','marques.id')
                            ->where('status',1)
               ->where('nom_sous_categorie','=','Tee-shirte')  
               ->get(['*']);

        $sliders=Slider::where('status',1)->get();
        return view('index')->with('categories',$categories)
                            ->with('sliders',$sliders)
                            ->with('SousCategories',$SousCategories)
                            ->with('articles',$articles)
                            ->with('teeshirts',$teeshirts)
                            ->with('tee_shirt_simples',$tee_shirt_simples)
                            ->with('offre_du_jours',$offre_du_jours)
                            ->with('coque_telephones',$coque_telephones)
                            ->with('PCS',$PCS)
                            ->with('impressions',$impressions)
                            ->with('baffes',$baffes)
                            ->with('outils',$outils)
                            ->with('imprimantes',$imprimantes)
                            ->with('informatiques',$informatiques)
                            ->with('Divers',$Divers)
                            ->with('Stokages',$Stokages)
                            ->with('alimentations',$alimentations)
                            ->with('users',$users);

        }
        else{
            $tee_shirt_simples=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                    ->join('marques','articles.id_marque','=','marques.id')
                                    ->where('sous_categories.nom_sous_categorie','=','Tee-shirte-simple')
                                    ->get(['*']);
        $coque_telephones=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                    ->join('marques','articles.id_marque','=','marques.id')
                                    ->where('sous_categories.nom_sous_categorie','=','Coque telephone')
                                    ->get(['*']);                            

        $categories=categorie::get();
        $articles=article::where('status',1)->get();

        $informatiques=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','informatique')
                                ->get(['*']);

        $alimentations=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','Alimentation')
                                ->get(['*']);

        $imprimantes=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','Imprimante')
                                ->get(['*']);

        $baffes=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','Baffe+Bluetooth	')
                                ->get(['*']);

        $outils=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','=','Outils')
                                ->get(['*']);

        $PCS=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('sous_categories.nom_sous_categorie','=','PC')
                                ->get(['*']);

        $Divers=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('sous_categories.nom_sous_categorie','Clé USB')
                                ->get(['*']);

        $impressions=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','Impression')
                                ->get(['*']);

        $Stokages=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','Stokages')
                                ->get(['*']);

        $offre_du_jours=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                                ->join('categories','sous_categories.id_categorie','=','categories.id')
                                ->join('marques','articles.id_marque','=','marques.id')
                                ->where('status',1)
                                ->where('categories.nom_categorie','Impression')
                                ->get(['*']);

        $SousCategories=SousCategorie::get();

        $teeshirts=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                            ->join('categories','sous_categories.id_categorie','=','categories.id')
                            ->join('marques','articles.id_marque','=','marques.id')
                            ->where('status',1)
               ->where('nom_sous_categorie','=','Tee-shirte')  
               ->get(['*']);

        $sliders=Slider::where('status',1)->get();
        return view('index')->with('categories',$categories)
                            ->with('sliders',$sliders)
                            ->with('SousCategories',$SousCategories)
                            ->with('articles',$articles)
                            ->with('teeshirts',$teeshirts)
                            ->with('tee_shirt_simples',$tee_shirt_simples)
                            ->with('offre_du_jours',$offre_du_jours)
                            ->with('coque_telephones',$coque_telephones)
                            ->with('PCS',$PCS)
                            ->with('impressions',$impressions)
                            ->with('baffes',$baffes)
                            ->with('outils',$outils)
                            ->with('imprimantes',$imprimantes)
                            ->with('informatiques',$informatiques)
                            ->with('Divers',$Divers)
                            ->with('Stokages',$Stokages)
                            ->with('alimentations',$alimentations);
                            // ->with('users',$users);
        }
        
    }
   
    public function dashboard(){
        if (! Gate::allows('acces_admin')) {
            abort(403);
        }
        return view('admin/Dashboard/index');
        
    }
    public function commande(){
        $users=Auth::user();
        $commander_tee_shirts=commander_tee_shirt::join('mode_livraisons','commander_tee_shirts.id_mode_livraison','=','mode_livraisons.id')
        ->join('users','commander_tee_shirts.id_user','=','users.id')
        ->get(['*']);
        return view('admin.Commande.liste_commande_teeshirt')->with('commander_tee_shirts',$commander_tee_shirts);
    }
}
