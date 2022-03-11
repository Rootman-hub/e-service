<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marque;
class marqueController extends Controller
{
   #---------------------- CRUD ---------------------------------------------#
   public function ajoutermarque(){
    return view('admin/marques/Ajouter_marque');
}
public function sauverMarque(Request $request){
    $this->validate($request,['nom_marque'=>'required|unique:marques']);
    $marque=new Marque();
    $marque->nom_marque=$request->input('nom_marque');

        if($request->hasFile('image_marque')){
        $file=$request->file('image_marque')->getClientOriginalName();
        $file=pathinfo($file ,PATHINFO_FILENAME);
        $extension=$request->file('image_marque')->getClientOriginalExtension();
        $fileName=$file.'_'.time().'.'.$extension;
        $path=$request->file('image_marque')->storeAs('public/image_marque',$fileName);
        $marque->image_marque=$fileName;
        $marque->save();
        }   else{
        $fileName='noimage.jpg';
        $marque->image_marque=$fileName;
        $marque->save();
        }
       
        //   return redirect('/Afficher_Marque')->with("<script> Swal.fire({
        //     position: 'top-end',
        //     icon: 'success',
        //     title: 'Your work has been saved',
        //     showConfirmButton: false,
        //     timer: 1500
        //   })</script>);
        toastr ()-> success ( 'la marque '.$marque->nom_marque.'  a été ajouter avec succés' );
        return redirect('/Afficher_Marque')->with('ajouter','la marque '.$marque->nom_marque.'  a été ajouter avec succés');

}
public function modifier_marque($id){
    $marques=Marque::find($id);
    return view('admin/marques/Modifier_marque')->with('marques',$marques);
}
public function editer_Marque(Request $request){
    $marques=Marque::find($request->input('id'));
    $marques->nom_marque=$request->nom_marque;

    if($request->hasFile('image_marque')){

        $file=$request->file('image_marque')->getClientOriginalName();
        $file=pathinfo($file ,PATHINFO_FILENAME);
        $extension=$request->file('image_marque')->getClientOriginalExtension();
        $fileName=$file.'_'.time().'.'.$extension;
        $path=$request->file('image_marque')->storeAs('public/image_marque',$fileName);
        $marques->image_marque=$fileName;
        $marques->save();
        }   

    else{
            $fileName='noimage.jpg';
            $marques->image_marque=$fileName;
            $marques->save();
        }
        
         if($marques->image_marque =!'noimage.jpg'){
            Storage::delete(['public/image_marque/'.$marques->image_marque]);
        }
        $marques->image_marque=$fileName;
        
    $marques->update('la marque '.$marques->nom_marque.'  a été modifier avec succés');
    toastr()->info('An error has occurred please try again later.');
    return redirect('/Afficher_Marque')->with('modifier','la marque '.$marques->nom_marque.'  a été modifier avec succés');
}
public function modifierMarque(Request $request){
    $marques=Marque::find($request->input('id'));
    $marques->nom_marque=$request->nom_marque;

    if($request->hasFile('image_marque')){

        $file=$request->file('image_marque')->getClientOriginalName();
        $file=pathinfo($file ,PATHINFO_FILENAME);
        $extension=$request->file('image_marque')->getClientOriginalExtension();
        $fileName=$file.'_'.time().'.'.$extension;
        $path=$request->file('image_marque')->storeAs('public/image_marque',$fileName);
        $marques->image_marque=$fileName;
        $marques->save();
        }   

    else{
            $fileName='noimage.jpg';
            $marques->image_marque=$fileName;
            $marques->save();
        }
        
         if($marques->image_marque =!'noimage.jpg'){
            Storage::delete(['public/image_marque/'.$marques->image_marque]);
        }
        $marques->image_marque=$fileName;
        
    $marques->update();

    return redirect('/Afficher_Marque')->with('modifier','la marque '.$marques->nom_marque.'  a été modifier avec succés');
}
public function SupprimerMarque($id){
    $marque=Marque::find($id);
    $marque->delete();
    toastr()->error('la marque '.$marque->nom_marque.'  a été supprimer avec succés');
    return redirect('/Afficher_Marque')->with('supprimer','la marque '.$marque->nom_marque.'  a été supprimer avec succés');
}
#---------------------- END CRUD ---------------------------------------------#
public function Afficher_marque(){
    $marques=Marque::get();
     return view('admin/marques/Afficher_Marque')->with('marques', $marques);
 }
}
