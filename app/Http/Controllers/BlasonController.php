<?php

namespace App\Http\Controllers;

use App\Models\Blason;
use App\Models\Couleur;
use App\Models\Meuble;
use App\Models\Champs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlasonController extends Controller
{
    /**      */
    public function create_random()
    {
        $couleur_meuble=null;
        $couleur_champs=null;
        $champs_secondaire=null;
        $couleur_champs2=null;
        $meuble_objet=null;
        $attributs=null;

        $aff_meuble=false;
        $couleurs=Couleur::all();
       // $meubles=Meuble::all()->where('free','=','1');
       $meubles=Meuble::all();

        $couleur_champs=$couleurs->random();
        if(mt_rand(0,1)==1)
        {
            $champs_secondaire=Champs::all()->random();
            $couleur_champs2=$couleurs->random();
        }

        if(mt_rand(0,$meubles->count())!=0)
        {
            $aff_meuble=true;
            $meuble_objet=$meubles->random();
            $couleur_meuble=$couleurs->where('type','<>',$couleur_champs->type);
            if($champs_secondaire!=null){
                $couleur_meuble=$couleur_meuble->where('id','<>',$couleur_champs2->id);
            }
            $couleur_meuble=$couleur_meuble->random();
            $attributs=Array();
            //si y a des attributs, aléatoire pour savoir si on en colore
            if(mt_rand(0,9)<5&&$meuble_objet->attributs->count()!=0) 
            {
                $cAtt = $couleurs->whereNotIn('id',[$couleur_champs->id,$couleur_meuble->id]);
                $shuffled = $meuble_objet->attributs->shuffle();
                $nb_attributs = mt_rand(1,$meuble_objet->attributs->count());
                $i=1;
                
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
        $blason->generate_image($couleur_champs, $champs_secondaire,$couleur_champs2, $meuble_objet, $couleur_meuble, $attributs);
        $blason->descriptif($couleur_champs, $champs_secondaire,$couleur_champs2, $meuble_objet, $couleur_meuble, $attributs);

        $var_retour=['couleur_champs_id'=>$couleur_champs->id, 
        'blason'=>$blason,
        'aff_meuble'=>$aff_meuble,
        'couleurs'=>$couleurs->sortBy(['type','desc'],['nom','asc']),
        'meubles'=>$meubles->sortBy(['nom','asc']) ];

        if($aff_meuble)
        {
            $var_retour['couleur_meuble_id']=$couleur_meuble->id;
            $var_retour['meuble_id']=$meuble_objet->id;
            $var_retour['meuble_fichier']=$meuble_objet->fichier;
            $var_retour['all_attributs']=$meuble_objet->attributs->all();
            $var_retour['attributs']=[];
            foreach($attributs as $a)
            {
                $var_retour['attributs'][$a['attribut']->id]=$a['couleur']->id;
            }
        }
        else
        {
            $var_retour['couleur_meuble_id']=0;
            $var_retour['meuble_id']=0;
            $var_retour['all_attributs']=[];
            $var_retour['attributs']=[];
        }
        return view('crest',$var_retour);
    }
    

    public function generate_api(Request $r)
    {
        $meuble=Meuble::find($r->meuble);
        $couleur_champs=Couleur::find($r->couleur_champs);
        $couleur_meuble=Couleur::find($r->couleur_meuble);
        $couleur_meuble_id=$r->couleur_meuble;
        $couleurs=Couleur::all();
        $all_attributs=$meuble->attributs;
        $attributs=null;
        $couleurs_attributs=[];
        $all_attributs_array=[];

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
        if($r->attributs!=null&&count($r->attributs)>0)
        {
            $couleurs_attributs=$r->attributs;
            $attributs=Array();
            foreach($r->attributs as $attribut=>$couleur)
            {
                if($couleur==0)
                {
                    continue;
                }
                if($couleur==$couleur_meuble_id)
                {
                    $new_color=$couleurs->random();
                    $attributs[]=['attribut'=>$all_attributs->where('id','=',$attribut)->first(),'couleur'=>$new_color];
                    $couleurs_attributs[$attribut]=$new_color->id;
                }
                else
                {
                    $attributs[]=['attribut'=>$all_attributs->where('id','=',$attribut)->first(),'couleur'=>$couleurs->where('id','=',$couleur)->first()];
                }
                
            }
        }
        foreach($all_attributs as $a)
        {
            $all_attributs_array[$a->id]='/images/meubles/'.$meuble->fichier.'-'.$a->fichier.'.png';
        }
        

        $blason=new Blason;
        $blason->generate_image($couleur_champs, $meuble, $couleur_meuble,$attributs);
        $blason->descriptif($couleur_champs, $meuble, $couleur_meuble,$attributs);

        return response()->json([
            'description' => $blason->description,
            'img' => $blason->image,
            'couleur_meuble' =>$couleur_meuble_id,
            'couleur_champs' =>$couleur_champs->id,
            'meuble'=>'/images/meubles/'.$meuble->fichier.".png",
            'attributs' => $couleurs_attributs,
            'all_attributs' => $all_attributs_array
        ]);
    }
};