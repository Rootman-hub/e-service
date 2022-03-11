<?php

namespace App\Http\Livewire;
namespace App\Http\Controllers;
use App\Models\article;
use App\Models\Slider;
use App\Models\categorie;
use App\Models\Marque;
use App\Models\SousCategorie;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SearchComponent extends Component
{
    public $sorting;
    public $pagesize;
    public $search;
    public $sous_categories;
    public $id_sous_categorie;

    public function mount()
    {
        $this->sorting = "default";
        $this->pagesize = 12;
        $this->fill(request()->only('search','sous_categories','id_sous_categorie'));
    }

    // public function store($article_id,$nom_article,$article_prix)
    // {
    //     Cart::add($article_id,$nom_article,1,$article_prix)->associate('App\Models\article');
    //     session()->flash('success_message','Item added in Cart');
    //     return redirect()->route('article.cart');
    // }

    // use WithPagination;
    public function render()
    {  
        if($this->sorting=='date')   
        {
            $articles = article::where('nom_article','like','%'.$this->search .'%')->where('id_sous_categorie','like','%'.$this->id_sous_categorie.'%')->orderBy('created_at','DESC')->paginate($this->pagesize);  
        }
        else if($this->sorting=="prix")
        {
            $articles = article::where('nom_article','like','%'.$this->search .'%')->where('id_sous_categorie','like','%'.$this->id_sous_categorie.'%')->orderBy('regular_prix','ASC')->paginate($this->pagesize); 
        }
        else if($this->sorting=="prix-desc")
        {
            $articles = article::where('nom_article','like','%'.$this->search .'%')->where('id_sous_categorie','like','%'.$this->id_sous_categorie.'%')->orderBy('regular_prix','DESC')->paginate($this->pagesize); 
        }
        else{
            $articles = article::where('nom_article','like','%'.$this->search .'%')->where('id_sous_categorie','like','%'.$this->id_sous_categorie.'%')->paginate($this->pagesize);  
        }   
        
        $SousCategories = SousCategorie::all();
        $categories = categorie::all();
        $marques = marque::all();
        return view('livewire.search-component',['articles'=> $articles,'SousCategories'=>$SousCategories,'categories'=>$categories,'marques'=>$marques]);//->layout("layouts.base");
    }
}
