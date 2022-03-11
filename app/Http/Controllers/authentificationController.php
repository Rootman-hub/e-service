<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class authentificationController extends Controller
{
    public function client_login(){
        return view('Authentification.client_login');
    }
    public function inscription(){
        return view('Authentification.inscription');
    }
}
