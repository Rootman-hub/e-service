<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\email;

class emailController extends Controller
{
    public function email(){
    Mail::to('abdoulnassseroumarou4@gmail.com')->send(new email());
    return view('Mail.email');
    }
}
