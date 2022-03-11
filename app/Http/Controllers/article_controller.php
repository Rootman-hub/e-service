<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\champ;
use App\Models\article;
use App\Models\Slider;
use App\Models\categorie;
use Illuminate\Support\Facades\Auth;
use App\Models\Marque;
use App\Models\SousCategorie;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;

class article_controller extends Controller
{
    

    public function commande_carte(){
        $categories=categoie::get();
        $articles=article::where('status',1)->get();
        $sliders=Slider::where('status',1)->get();
        return view('client/commande_carteVisite')->with('categories',$categories)->with('sliders',$sliders)->with('articles',$articles);
    }
    s
    public function filtre_sous_categorie($id){
        $categories=categorie::get();
        $marques=Marque::get(); n
        $SousCategories=SousCategorie::get();
        $articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                          ->join('marques','articles.id_marque','=','marques.id') 
                          ->join('categories','sous_categories.id_categorie','=','categories.id') 
                          ->where('id_sous_categorie',$id)
                          ->where('status',1)
                          ->get(['*']);
        return view('client/boutique/grille')->with('SousCategories',$SousCategories)
                                             ->with('articles',$articles)
                                             ->with('categories',$categories)
                                             ->with('marques',$marques);
    }
    public function filtre_marque($id){
        $categories=categorie::get();
        $SousCategories=SousCategorie::get();
        $marques=Marque::get();
        $articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                           ->join('marques','articles.id_marque','=','marques.id') 
                           ->join('categories','sous_categories.id_categorie','=','categories.id') 
                          ->where('id_marque',$id)
                          ->where('status',1)
                          ->get([   ]);
        return view('client/boutique/grille')->with('marques',$marques)
                                             ->with('SousCategories',$SousCategories)
                                             ->with('categories',$categories)
                                             ->with('articles',$articles);
    }
    public function filtre_categorie($id){
        $categories=categorie::get();
        $marques=Marque::get();
        $SousCategories=SousCategorie::get();
        $articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                          ->join('marques','articles.id_marque','=','marques.id') 
                          ->join('categories','sous_categories.id_categorie','=','categories.id') 
                          ->where('id_categorie',$id)
                          ->where('status',1)
                          ->get(['*']);
        return view('client/boutique/grille')->with('SousCategories',$SousCategories)
                                             ->with('articles',$articles)
                                             ->with('categories',$categories)
                                             ->with('marques',$marques);
    }
    public $sorting;
    public $pagesize;
    public function mount()
{
	$this->sorting = "default";
	$this->pagesize = 12;                 
}
public function render()
    {  
        if($this->sorting=='date')   
        {
            $articles = article::orderBy('created_at','DESC')->paginate($this->pagesize);  
        }
        else if($this->sorting=="price")
        {
            $articles = article::orderBy('regular_price','ASC')->paginate($this->pagesize); 
        }
        else if($this->sorting=="price-desc")
        {
            $articles = article::orderBy('regular_price','DESC')->paginate($this->pagesize); 
        }
        else{
            $articles = article::paginate($this->pagesize);  
        }
        return view('client/boutique/grille',['articles'=> $articles]);
    }
   
    public function detaille_Article($id){
        $users=Auth::user();
        // $articles=article::findOrFail($id);
         $articles=article::find($id);
        //  $articlesCrypt=Cry::find($id);
        return view('client/detaille_Article')->with('articles',$articles)->with('users',$users);;
    }
    public function achat($id){
        // $Article=DB::table('Articles')
        // ->where('id',$id)
        // ->first();

        $Articles=Article::find($id);
        return view('/achat')->with('$Articles',$Articles);
    }
#################        Création      ######################################################################
    public function ajouterArticle(){
        $categories=SousCategorie::get()->pluck('nom_sous_categorie','id');
        $marques=Marque::get()->pluck('nom_marque','id');
        return view('admin/Articles/Ajouter_article')->with('categories',$categories)->with('marques',$marques);
    }
###############################################################################################
    
    public function sauvergarderArticle(champ $request){

        $this->validate($request,[
            // 'nom_article'=>'required|unique:Articles',
            // // 'prix_Article'=>'required',
            // // 'nom_categorie'=>'required',
            // 'image1_article'=>'image|nullable|max:4999',
            // 'image2_article'=>'image|nullable|max:4999',
            // 'image3_article'=>'image|nullable|max:4999',
            // 'image4_article'=>'image|nullable|max:4999',
        ]);  
        $Article=new article();
        $Article->nom_article=$request->input('nom_article');
        $Article->prix_article=$request->input('prix_article');
        $Article->description_article=$request->input('description_article');
        $Article->caraterisque_article=$request->input('caraterisque_article');
        $Article->poid_article=$request->input('poid_article');
        $Article->couleur=$request->input('couleur');
        $Article->id_sous_categorie=$request->input('id_sous_categorie');
        $Article->id_marque=$request->input('id_marque');

        if($request->hasFile('image1_article')){
            $file=$request->file('image1_article')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('image1_article')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('image1_article')->storeAs('public/image_Article',$fileName);
            $Article->image1_article=$fileName;
            $Article->save();
            }   else{
            $fileName='noimage.jpg';
            $Article->image1_article=$fileName;
            $Article->save();
            } 
            if($Article->image1_article =!'noimage.jpg'){
                Storage::delete(['public/image_Article/'.$Article->image1_article]);
            }
            $Article->image1_article=$fileName;

        if($request->hasFile('image2_article')){
            $file=$request->file('image2_article')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('image2_article')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('image2_article')->storeAs('public/image_Article',$fileName);
            $Article->image2_article=$fileName;
            $Article->save();
            }   else{
            $fileName='noimage.jpg';
            $Article->image2_article=$fileName;
            $Article->save();
            } 
            if($Article->image2_article =!'noimage.jpg'){
                Storage::delete(['public/image_Article/'.$Article->image2_article]);
            }
            $Article->image2_article=$fileName;
            
        if($request->hasFile('image3_article')){
            $file=$request->file('image3_article')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('image3_article')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('image3_article')->storeAs('public/image_Article',$fileName);
            $Article->image3_article=$fileName;
            $Article->save();
            }   else{
            $fileName='noimage.jpg';
            $Article->image3_article=$fileName;
            $Article->save();
            } 
            if($Article->image3_article =!'noimage.jpg'){
                Storage::delete(['public/image_Article/'.$Article->image3_article]);
            }
            $Article->image3_article=$fileName;

        if($request->hasFile('image4_article')){
            $file=$request->file('image4_article')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('image4_article')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('image4_article')->storeAs('public/image_Article',$fileName);
            $Article->image4_article=$fileName;
            $Article->save();
            }  
            else{
            $fileName='noimage.jpg';
            $Article->image4_article=$fileName;
            $Article->save();
            }
            if($Article->image4_article =!'noimage.jpg'){
                Storage::delete(['public/image_Article/'.$Article->image4_article]);
            }
            $Article->image4_article=$fileName;
            // AfficherArticle
        return redirect('/ajouterArticle')->with("ajouter","l'article"."  ".$Article->nom_article. " a été ajouter avec succés");
        }

        // Vers page modification
    public function modifier_Article($id){
        $Article=article::findOrFail($id);
        $categories=SousCategorie::get()->pluck('nom_sous_categorie','id');
        $marques=Marque::get()->pluck('nom_marque','id');
        return view('admin/Articles/Modifier_article')->with('Article',$Article)->with('categories',$categories)->with('marques',$marques);
    }

    // Script de modificaion
    public function modifierArticle(Request $request){
        // $this->validate($request,[
        //     'nom_Article'=>'required',
        //     'prix_Article'=>'required',
        //     'nom_categorie'=>'required',
        //     'image1_article'=>'image|nullable|max:1999',
        // ]);  
        // $Article=Hashids::encode($id);
        $Article=article::find($request->input('id'));
        $Article->nom_article=$request->input('nom_article');
        $Article->prix_article=$request->input('prix_article');
        $Article->description_article=$request->input('description_article');
        $Article->caraterisque_article=$request->input('caraterisque_article');
        $Article->poid_article=$request->input('poid_article');
        $Article->couleur=$request->input('couleur');
        $Article->id_sous_categorie=$request->input('id_sous_categorie');
        $Article->id_marque=$request->input('id_marque');

        if($request->hasFile('image1_article')){
            $file=$request->file('image1_article')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('image1_article')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('image1_article')->storeAs('public/image_Article',$fileName);
            $Article->image1_article=$fileName;
            $Article->save();
            }   else{
            $fileName='noimage.jpg';
            $Article->image1_article=$fileName;
            $Article->save();
            } 
            if($Article->image1_article =!'noimage.jpg'){
                Storage::delete(['public/image_Article/'.$Article->image1_article]);
            }
            $Article->image1_article=$fileName;

        if($request->hasFile('image2_article')){
            $file=$request->file('image2_article')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('image2_article')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('image2_article')->storeAs('public/image_Article',$fileName);
            $Article->image2_article=$fileName;
            $Article->save();
            }   else{
            $fileName='noimage.jpg';
            $Article->image2_article=$fileName;
            $Article->save();
            } 
            if($Article->image2_article =!'noimage.jpg'){
                Storage::delete(['public/image_Article/'.$Article->image2_article]);
            }
            $Article->image2_article=$fileName;
            
        if($request->hasFile('image3_article')){
            $file=$request->file('image3_article')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('image3_article')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('image3_article')->storeAs('public/image_Article',$fileName);
            $Article->image3_article=$fileName;
            $Article->save();
            }   else{
            $fileName='noimage.jpg';
            $Article->image3_article=$fileName;
            $Article->save();
            } 
            if($Article->image3_article =!'noimage.jpg'){
                Storage::delete(['public/image_Article/'.$Article->image3_article]);
            }
            $Article->image3_article=$fileName;

        if($request->hasFile('image4_article')){
            $file=$request->file('image4_article')->getClientOriginalName();
            $file=pathinfo($file ,PATHINFO_FILENAME);
            $extension=$request->file('image4_article')->getClientOriginalExtension();
            $fileName=$file.'_'.time().'.'.$extension;
            $path=$request->file('image4_article')->storeAs('public/image_Article',$fileName);
            $Article->image4_article=$fileName;
            $Article->save();
            }  
            else{
            $fileName='noimage.jpg';
            $Article->image4_article=$fileName;
            $Article->save();
            }
            if($Article->image4_article =!'noimage.jpg'){
                Storage::delete(['public/image_Article/'.$Article->image4_article]);
            }
            $Article->image4_article=$fileName;

        $Article->update();
        return redirect('/AfficherArticle')->with("modifier","l'article"."  ".$Article->nom_article. " a été modifié avec succés");
    }

    public function SupprimerArticle($id){
        $Article=Article::find($id);
        $Article->delete();
        return redirect('/AfficherArticle')->with("supprimer","l'article"."  ".$Article->nom_article. " a été supprimer avec succés");
    }

    public function activer_Article($id){
        $Article=article::find($id);
        $Article->status=1;
        $Article->update();
        return redirect('/AfficherArticle')->with("activer","l'article"."  ".$Article->nom_article. " a été activer avec succés");

    }
    public function desactiver_Article($id){
        $Article=article::find($id);
        $Article->status=0;
        $Article->update();
        return redirect('/AfficherArticle')->with('desactiver',"l'article"."  ".$Article->nom_article. " a été desactiver avec succés");
    }
####################### Affichage  ########################################################################
    public function Afficher_Article(){
        $Articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                           ->join('marques','articles.id_marque','=','marques.id') 
                         ->get(['articles.*','sous_categories.nom_sous_categorie','marques.nom_marque']);
        return view('admin/Articles/Afficher_article')->with('Articles',$Articles);
    }
    public function Liste_Teeshirt(){
        $Articles=article::join('sous_categories','articles.id_sous_categorie','=','sous_categories.id')
                          ->join('marques','articles.id_marque','=','marques.id') 
                                 ->where('nom_sous_categorie','=','Tee-shirt')  
                                 ->get(['*']);
        return view('admin/Articles/Liste_Teeshirt')->with('Articles',$Articles);
    }
###############################################################################################
}
