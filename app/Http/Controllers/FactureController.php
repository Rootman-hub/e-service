<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function facture(){
        return view('client.facture.facture');
    }
    public function imprimerFacture(){
        return view('client/facture/imprimer_facture');
    }
}
