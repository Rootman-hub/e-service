<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\article;
use App\Models\commander_tee_shirt;
use App\Models\Mode_livraison;
use panier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class pdfController extends Controller
{
    // public function voir_pdf($id){
    //     Session::put('id', $id);
    //     try{
    //         $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape');
    //         // $pdf->loadView('admin.Afficher_artivlcd');
    //         $pdf->loadHTML($this->Conversion_mes_article());

    //         return $pdf->stream();
    //     }
    //     catch(Exception $e){
    //         return redirect('/article')->with('error', $e->getMessage());
    //     }
    // }

    // public function Conversion_mes_article(){
    //     $articles = article::where('id',Session::get('id'))->get();
    //     foreach($articles as $article){
    //         $nom_article = $article->nom_article;
    //         $prix_article = $article->prix_article;
    //         $created_at = $article->created_at;
    //     }

    //     $articles->transform(function($article, $key){
    //         $article->panier = unserialize($article->panier);

    //         return $article;
    //     });
    //     $output ='<link rel="stylesheet" href="frontend/style.css">
    //                     <table class="table">
    //                         <thead class="thead">
    //                             <tr class="text-left">
    //                                 <th>Client Name : '.$nom_article.'<br> Client adresse : '.$prix_article.' <br> Date : '.$created_at.'</th>
    //                             </tr>
    //                         </thead>
    //                     </table>
    //                     <table class="table">
    //                         <thead class="thead-primary">
    //                             <tr class="text-center">
    //                                 <th>Image</th>
    //                                 <th>Product name</th>
    //                                 <th>Price</th>
    //                                 <th>Quantity</th>
    //                                 <th>Total</th>
    //                             </tr>
    //                         </thead>
    //                         <tbody>';
        
    //     foreach($articles as $item){
    //         // foreach($article->panier->items as $item){
    //             $output .= '<tr class="text-center">
    //                             <td class="image-prod"><img src="storage/image_article/'.$item['image1_article'].'" alt="" style = "height: 80px; width: 80px;"></td>
    //                             <td class="product-name">
    //                                 <h3>'.$item['nom_article'].'</h3>
    //                             </td>
    //                             <td class="price">$ '.$item['prix_article'].'</td>
    //                         </tr><!-- END TR-->
    //                         </tbody>';
    //                         // <td class="qty">'.$item['Quantite'].'</td>
    //                         // <td class="total">$ '.$item['prixTotal']*$item['Quantite'].'</td>
    //         // }
    //         // $prixTotal = $article->panier->prixTotal; 
    //     }
    //     $output .='</table>';
    //     $output .='<table class="table">
    //                     <thead class="thead">
    //                         <tr class="text-center">
    //                                 <th>Total</th>
    //                                 <
    //                         </tr>
    //                     </thead>
    //                 </table>';
    //                 // th>$ '.$prixTotal.'</th>
    //     return $output;
    // }


    public function voir_pdf($id){
        Session::put('id_c', $id);
        try{
            $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape');
            $pdf->loadHTML($this->Conversion_mes_article());
            return $pdf->stream();
        }
        catch(Exception $e){
            return redirect('/')->with('error', $e->getMessage());
        }
    }
    public function Conversion_mes_article(){
        $commander_tee_shirts =DB::table('commander_tee_shirts')
        ->join('mode_livraisons','commander_tee_shirts.id_mode_livraison','=','mode_livraisons.id')
    ->where('commander_tee_shirts.id_c',Session::get('id_c'))->get();

        foreach($commander_tee_shirts as $commander_tee_shirt){
            $nom = $commander_tee_shirt->nom;
            $prenom = $commander_tee_shirt->prenom;
            $email = $commander_tee_shirt->email;
            $couleur = $commander_tee_shirt->couleur;
            $col = $commander_tee_shirt->col;
            $taille = $commander_tee_shirt->taille;
            $modele = $commander_tee_shirt->modele;
            $telephone = $commander_tee_shirt->telephone;
            $adresse = $commander_tee_shirt->adresse;
            $qte = $commander_tee_shirt->qte;
            $rdv = $commander_tee_shirt->rdv;
            $note = $commander_tee_shirt->note;
            $marque = $commander_tee_shirt->marque;
            $modele = $commander_tee_shirt->modele;
            $mode = $commander_tee_shirt->mode;
            $tva=0.19;
            $prix=1500;
            $created_at = $commander_tee_shirt->created_at;
        }
        $output ='<link rel="stylesheet" href="frontend/style.css">
                        <img src="frontend/images/cropped-ms-i_logo.png" alt="">
                        <table class="table">
                          <thead class="thead">
                             <tr class="text-left">
                                <th>Nom : '.$nom.'<br>
                                Prenom : '.$prenom.' <br>
                                E-mail : '.$email.'</th> <br>
                                 
                                <th class="text-right">Telephone : '.$telephone.' <br>
                                Client adresse : '.$adresse.' <br>
                                Date : '.$created_at.'</th>
                            </tr>
                           
                            </thead>
                        </table>

                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>Modele</th>
                                    <th>Marque</th>
                                    <th>Col</th>
                                    <th>Taille</th>
                                    <th>Quantité</th>
                                    <th>Couleur choisi</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>';
        
                foreach($commander_tee_shirts as $item){
                $output .= '<tr class="text-center">
                                <td class="image-prod"><img src="storage/modele_commande/'.$item->modele.'" alt="" style = "height: 80px; width: 80px;"></td>
                                <td colspan="1" class="product-name">
                                    <h3>'.$item->marque.'</h3>
                                </td>
                                <td colspan="1" class="product-name">
                                    <h3>'.$item->col.'</h3>
                                </td>
                                <td colspan="1" class="product-name">
                                    <h3>'.$item->taille.'</h3>
                                </td>
                                <td colspan="1" class="product-name">
                                    <h3>'.$item->qte.'</h3>
                                </td>
                                <td colspan="1"  class="product-name">
                                    <h3>'.$item->couleur.'</h3>
                                </td>
                                <td class="product-name">
                                    <h3>'.$item->note.'</h3>
                                </td>
                            </tr><!-- END TR-->
                            </tbody>';
                            // <td class="qty">'.$item['Quantite'].'</td>
                            // <td class="total">$ '.$item['prixTotal']*$item['Quantite'].'</td>
            // }
            // $prixTotal = $article->panier->prixTotal; 
       
        $output .='</table>';
        if ($item->mode=="A domicile"){
        $output .='<table class="table">
        <thead>
        <tr class="text-left">
        <th><strong>Mode de livraison : '.$item->mode.'</strong></th>
        <th class="text-right">Rendez-vous le: '.$item->rdv.'</th>
        </tr>
      
                        <tr class="text-right">
                            <th></th>
                            <th>
                                HT : '.($item->qte*1500).'&nbsp;XOF<br> 
                                TVA (19%) :'.$item->qte*1500*0.19.'&nbsp;XOF<br> <hr>
                                A domicile (1000 XOF) :1000 XOF <br>
                                <strong>TTC</strong>:'.($item->qte*1500*1.19)+1000 .'&nbsp;
                            </th>
                                </tr>
                            </thead>
                    </table>';
        } elseif ($item->mode=="Boutique"){
            $output .='<table class="table">
            <thead>
            <tr class="text-left">
            <th><strong>Mode de livraison : '.$item->mode.'</strong></th>
            <th class="text-right">Rendez-vous le: '.$item->rdv.'</th>
            </tr>
          
                            <tr class="text-right">
                                <th></th>
                                <th>
                                    HT : '.($item->qte*1500).'&nbsp;XOF<br> 
                                    TVA (19%) :'.$item->qte*1500*0.19.'&nbsp;XOF<br> <hr>
                                    <strong>TTC</strong>:'.$item->qte*1500*1.19.'&nbsp;
                                </th>
                                    </tr>
                                </thead>
                        </table>';
            }
            }

            
        return $output;
    }}


//     public function panier_pdf(){
//         // Session::put('id', $id);
//         try{
//             $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape');
//             $pdf->loadHTML($this->panier());
//             return $pdf->stream();
//         }
//         catch(Exception $e){
//             return redirect('/')->with('error', $e->getMessage());
//         }
//     }
//     public function panier(){
//         $commander_tee_shirts =DB::table('commander_tee_shirts')
//         ->join('mode_livraisons','commander_tee_shirts.id_mode_livraison','=','mode_livraisons.id')
//     // ->where('commander_tee_shirts.id',Session::get('id'))->get();
//     ->get(['*']);

//         foreach($commander_tee_shirts as $commander_tee_shirt){
//             $nom = $commander_tee_shirt->nom;
//             $prenom = $commander_tee_shirt->prenom;
//             $email = $commander_tee_shirt->email;
//             $couleur = $commander_tee_shirt->couleur;
//             $col = $commander_tee_shirt->col;
//             $taille = $commander_tee_shirt->taille;
//             $modele = $commander_tee_shirt->modele;
//             $telephone = $commander_tee_shirt->telephone;
//             $adresse = $commander_tee_shirt->adresse;
//             $qte = $commander_tee_shirt->qte;
//             $rdv = $commander_tee_shirt->rdv;
//             $note = $commander_tee_shirt->note;
//             $marque = $commander_tee_shirt->marque;
//             $modele = $commander_tee_shirt->modele;
//             $mode = $commander_tee_shirt->mode;
//             $tva=0.19;
//             $prix=1500;
//             $created_at = $commander_tee_shirt->created_at;
//         }
//         $output ='<link rel="stylesheet" href="frontend/style.css">
//                         <img src="frontend/images/cropped-ms-i_logo.png" alt="">
//                         <table class="table">
//                           <thead class="thead">
//                              <tr class="text-left">
//                                 <th>Nom : '.$nom.'<br>
//                                 Prenom : '.$prenom.' <br>
//                                 E-mail : '.$email.'</th> <br>
                                 
//                                 <th class="text-right">Telephone : '.$telephone.' <br>
//                                 Client adresse : '.$adresse.' <br>
//                                 Date : '.$created_at.'</th>
//                             </tr>
                           
//                             </thead>
//                         </table>

//                         <table class="table">
//                             <thead class="thead-primary">
//                                 <tr class="text-center">
//                                     <th>Modele</th>
//                                     <th>Marque</th>
//                                     <th>Col</th>
//                                     <th>Taille</th>
//                                     <th>Quantité</th>
//                                     <th>Couleur choisi</th>
//                                     <th>Note</th>
//                                 </tr>
//                             </thead>
//                             <tbody>';
        
//                 foreach($commander_tee_shirts as $item){
//                     // foreach($commander_tee_shirt->Panier->item as $items){
//                 $output .= '<tr class="text-center">
//                                 <td class="image-prod"><img src="storage/modele_commande/'.$item->modele.'" alt="" style = "height: 80px; width: 80px;"></td>
//                                 <td colspan="1" class="product-name">
//                                     <h3>'.$item->marque.'</h3>
//                                 </td>
//                                 <td colspan="1" class="product-name">
//                                     <h3>'.$item->col.'</h3>
//                                 </td>
//                                 <td colspan="1" class="product-name">
//                                     <h3>'.$item->taille.'</h3>
//                                 </td>
//                                 <td colspan="1" class="product-name">
//                                     <h3>'.$item->qte.'</h3>
//                                 </td>
//                                 <td colspan="1"  class="product-name">
//                                     <h3>'.$item->couleur.'</h3>
//                                 </td>
//                                 <td class="product-name">
//                                     <h3>'.$item->note.'</h3>
//                                 </td>
//                             </tr><!-- END TR-->
//                             </tbody>';
//                             // <td class="qty">'.$item['Quantite'].'</td>
//                             // <td class="total">$ '.$item['prixTotal']*$item['Quantite'].'</td>
//             // }
//             // $prixTotal = $article->panier->prixTotal; 
       
//         $output .='</table>';
//         // $output .='<table class="table">
//         // <thead>
//         // <tr class="text-left">
//         // <th><strong>Mode de livraison : '.$item->mode.'</strong></th>
//         // <th class="text-right">Rendez-vous le: '.$item->rdv.'</th>
//         // </tr>
      
//         //                 <tr class="text-right">
//         //                     <th></th>
//         //                     <th>
//         //                         HT : '.($item->qte*1500).'&nbsp;XOF<br> 
//         //                         TVA (19%) :'.$item->qte*1500*0.19.'<br> <hr>
//         //                         <strong>TTC</strong>:'.$item->qte*1500*1.19 .'&nbsp;XOF
//         //                     </th>
//         //                         </tr>
//         //                     </thead>
//         //             </table>';
//             // }
//         }
//         return $output;
//     }

    
// }
