<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
class SliderController extends Controller
{
###################  AFFICHER MOI LE FORMULAIRE AJOUTER SLIDER ###################################
    public function AjouterSlider(){
        return view('admin/Sliders/Ajouter_slider');
    }
#########################  CRUD ####################################################################
#                                                                                                  #
#########################  #AFFICHE MOI MES SLIDERS ################################################
    public function Afficher_slider(){
        $sliders=Slider::get();
        return view('admin/Sliders/Afficher_slider')->with('sliders',$sliders);
    }

#####################  SAUVEGARDER  #######################################################
    public function sauverSlider(Request $requette){
        $this->validate($requette,[
            'description1'=>'required',
            'description2'=>'required',
            'imageSlider'=>'image|nullable|max:1999',
            ]);  
                $slider=new Slider();
                $slider->description1=$requette->input('description1');
                $slider->description2=$requette->input('description2');
                $slider->status=1;
            if($requette->hasFile('imageSlider')){
                    $file=$requette->file('imageSlider')->getClientOriginalName();
                    $file=pathinfo($file ,PATHINFO_FILENAME);
                    $extension=$requette->file('imageSlider')->getClientOriginalExtension();
                    $fileName=$file.'_'.time().'.'.$extension;
                    $path=$requette->file('imageSlider')->storeAs('public/image_slider',$fileName);
                    $slider->imageSlider=$fileName;
                    $slider->save();
                }else{
                    $fileName='noimage.jpg';
                    $slider->imageSlider=$fileName;
                    $slider->save();
                } 
        return redirect('/Afficher_slider')->with('ajouter','Le slider à été ajouter avec success');   
    }
####################### AFFICHE MOI LE FORMULAIRE MODIFICATION SLIDER ###########################
    public function modifier($id){
        $sliders=Slider::find($id);
        return view('admin/Sliders/Modifier_slider')->with('sliders',$sliders);
    } 

#######################  MODIFICATION SLIDER  ####################################################
        public function modifierSlider(Request $requette){
            $this->validate($requette,[
                'description1'=>'required',
                'description2'=>'required',
                'imageSlider'=>'image|nullable|max:1999',
                ]);   
            $slider=Slider::find($requette->input('id'));
            $slider->description1=$requette->input('description1');
            $slider->description2=$requette->input('description2');
    
            if($requette->hasFile('imageSlider')){
                $file=$requette->file('imageSlider')->getClientOriginalName();
                $file=pathinfo($file ,PATHINFO_FILENAME);
                $extension=$requette->file('imageSlider')->getClientOriginalExtension();
                $fileName=$file.'_'.time().'.'.$extension;
                $path=$requette->file('imageSlider')->storeAs('public/image_slider',$fileName);
                $slider->imageSlider=$fileName;
                $slider->save();
            }else{
                $fileName='noimage.jpg';
                $slider->imageSlider=$fileName;
                $slider->save();
            } 
    
            if($slider->imageSlider =!'noimage.jpg'){
                Storage::delete(['public/image_slider/'.$slider->imageSlider]);
            }
            $slider->imageSlider=$fileName;
    
            $slider->update();
            return redirect('/Afficher_slider')->with('modifier','le slider a été modifier avec succés');
        }
####################### SUPPRIMER  #####################################################
        public function supprimer_slider($id){
            $slider=Slider::find($id);
            if($slider->imageSlider!='noimage.jpg'){
                Storage::delete('public/image_slider/'.$slider->imageSlider);
            }
            $slider->delete();
            return redirect('/Afficher_slider')->with('supprimer','le slider a été supprimer avec succés');
        }
##################### ACTIVER UN SLIDER #######################################################
        public function activer_slider($id){
            $slider=Slider::find($id);
            $slider->status=1;
            $slider->update();
            return redirect('/Afficher_slider')->with('activer','le slider a été activer avec succés');
        }
#################### DESACTIVER SLIDER ##############################################################
        public function desactiver_slider($id){
            $slider=Slider::find($id);
            $slider->status=0;
            $slider->update();
            return redirect('/Afficher_slider')->with('desactiver','le slider a été désactiver avec succés');
        }
}
