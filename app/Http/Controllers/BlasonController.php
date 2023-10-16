<?php

namespace App\Http\Controllers;

use App\Models\Blason;
use App\Models\Couleur;
use App\Models\Meuble;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class BlasonController extends Controller
{
    /**      */
    public function create_random()
    {
        $couleur_meuble=null;
        $couleur_champs=null;
        $meuble_objet=null;
        $attributs=null;

        $aff_meuble=false;
        $couleurs=Couleur::all();
        $meubles=Meuble::all();

        $couleur_champs=$couleurs->random();

        if(mt_rand(0,$meubles->count())!=0)
        {
            $aff_meuble=true;
            $meuble_objet=$meubles->random();
            $couleur_meuble=$couleurs->where('type','<>',$couleur_champs->type)->random();

            //si y a des attributs, aléatoire pour savoir si on en colore
            if(mt_rand(0,9)<5&&$meuble_objet->attributs->count()!=0) 
            {
                $cAtt = $couleurs->whereNotIn('id',[$couleur_champs->id,$couleur_meuble->id]);
                $shuffled = $meuble_objet->attributs->shuffle();
                $nb_attributs = mt_rand(1,$meuble_objet->attributs->count());
                $i=1;
                $attributs=Array();
                foreach($shuffled as $item)
                {
                    $attributs[]=['attribut'=>$item,'couleur'=>$cAtt->random()];
                    if(++$i>$nb_attributs)
                    {
                        break;
                    }
                };
            }
        }

        $blason=new Blason;
        $blason->generate_image($couleur_champs, $meuble_objet, $couleur_meuble, $attributs);
        $blason->descriptif($couleur_champs, $meuble_objet, $couleur_meuble, $attributs);

        $var_retour=['couleur_champs_id'=>$couleur_champs->id, 
        'blason'=>$blason,
        'aff_meuble'=>$aff_meuble,
        'couleurs'=>$couleurs->sortBy(['type','desc'],['nom','asc']),
        'meubles'=>$meubles->sortBy(['nom','asc']) ];

        if($aff_meuble)
        {
            $var_retour['couleur_meuble_id']=$couleur_meuble->id;
            $var_retour['meuble_id']=$meuble_objet->id;
        }
        else
        {
            $var_retour['couleur_meuble_id']=0;
            $var_retour['meuble_id']=0;
        }
        return view('crest',$var_retour);
    }
    

    public function generate_api(Request $r)
    {
        $meuble=Meuble::find($r->meuble);
        $couleur_champs=Couleur::find($r->couleur_champs);
        $couleur_meuble=Couleur::find($r->couleur_meuble);
        $couleur_meuble_id=$r->couleur_meuble;

        if($r->meuble!=0&&$r->couleur_meuble==0) 
            // si le blason d'origine n'avait pas de meuble
        {
            $couleur_meuble=Couleur::where('type','<>',$couleur_champs->type)->get()->random(); 
            $couleur_meuble_id=$couleur_meuble->id;
        }
        elseif($r->couleur_meuble!=0&&$couleur_champs->type==$couleur_meuble->type) 
            //si en changeant de couleur on enfreint les règles de couleurs
        {
            if($r->change=="couleur_champs")
            {
                $couleur_meuble=Couleur::where('type','<>',$couleur_champs->type)->get()->random(); 
                $couleur_meuble_id=$couleur_meuble->id;
            }
            else
            {
                $couleur_champs=Couleur::where('type','<>',$couleur_meuble->type)->get()->random(); 
                $couleur_champs_id=$couleur_champs->id;
            }
            
        }

        $blason=new Blason;
        $blason->generate_image($couleur_champs, $meuble, $couleur_meuble);
        $blason->descriptif($couleur_champs, $meuble, $couleur_meuble);

        return response()->json([
            'description' => $blason->description,
            'img' => $blason->image,
            'couleur_meuble' =>$couleur_meuble_id,
            'couleur_champs' =>$couleur_champs->id   
        ]);
    }
}
