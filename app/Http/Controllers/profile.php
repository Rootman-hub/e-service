<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\article;
use App\Models\categorie;
use App\Models\SousCategorie;
use App\Models\commander_tee_shirt;
use App\Models\Mode_livraison;
use App\panier;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\email;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Commande;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\image;
use Illuminate\Http\Request;

class profile extends Controller
{
   public function profile($id){
    $users=Auth::user();
    $commander_tee_shirts=commander_tee_shirt::join('mode_livraisons','commander_tee_shirts.id_mode_livraison','=','mode_livraisons.id')
                                               ->join('users','commander_tee_shirts.id_user','=','users.id')
        // ->where('Auth::user()','=','Auth::user()->name')
        // ->where('commander_tee_shirts.id_user',Session::get('users.id'))
        ->where('commander_tee_shirts.id_user','=',Auth::user()->id)
        // ->get(['commander_tee_shirts.*','mode_livraisons.mode','users.*']);
        ->get('*');
        // ->get(['*'])->find($id);
    // $users = User::get();
    return view('auth.profile')->with('commander_tee_shirts',$commander_tee_shirts);
   }
//    public function profile_edit(Request $request){
//     // Logic for user upload of avatar
//     // $users = Auth::user();
//     // $users=new User();
//     // if($request->hasFile('photo')){
//     //     $photo = $request->file('photo');
//     //     $filename = time() . '.' . $photo->getClientOriginalExtension();
//     //     Image::make($photo)->resize(300, 300)
//     //     ->save( public_path('/profil/photo/' . $filename ) );
//     //     $users = Auth::user();
//     //     $users->photo = $filename;
//     //     $users->save();
//     // }
//     // $users->Auth::user()$request->name;
//     $users=User::find($request->input('name'));
//         $users->first_name=$request->input('first_name');
//         $users->last_name=$request->input('last_name');
//         $users->email=$request->input('email');
//         $users->apropos=$request->input('apropos');
//         $users->adresse=$request->input('adresse');
//         $users->ville=$request->input('ville');
//         $users->telephone=$request->input('telephone');
//         $users->photo=$request->input('photo');
//     if($request->hasFile('photo')){
//         $file=$request->file('photo')->getClientOriginalName();
//         $file=pathinfo($file ,PATHINFO_FILENAME);
//         $extension=$request->file('photo')->getClientOriginalExtension();
//         $fileName=$file.'_'.time().'.'.$extension;
//         $path=$request->file('photo')->storeAs('public/image_users',$fileName);
//         $users->photo=$fileName;
//         $users->save();
        
//         }  
//         else{
//         $fileName='noimage.jpg';
//         $users->photo=$fileName;
//         $users->save();
//         }
//         if($users->photo =!'noimage.jpg'){
//             Storage::delete(['public/image_users/'.$users->photo]);
//         }
//         $users->photo=$fileName;
//         $users->update();
//     return view('auth.profile', ['users' => Auth::user()] );
// }
}
