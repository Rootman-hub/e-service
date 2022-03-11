<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categorie;
use App\Models\Article;
use App\Models\Slider;

class CommandeController extends Controller
{
    public function commande(){
        $users=Auth::user();
        $commander_tee_shirts=commander_tee_shirt::join('mode_livraisons','commander_tee_shirts.id_mode_livraison','=','mode_livraisons.id')
        ->join('users','commander_tee_shirts.id_user','=','users.id')
        ->get(['*']);
        return view('admin.commande')->with('commander_tee_shirts',$commander_tee_shirts);
    }
    
}
