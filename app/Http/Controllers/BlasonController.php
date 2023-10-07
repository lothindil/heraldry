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

        $aff_meuble=false;
        $couleurs=Couleur::all();
        $meubles=Meuble::all();

        $couleur_champs=$couleurs->random();

        if(mt_rand(0,$meubles->count())!=0)
        {
            $aff_meuble=true;
            $meuble_objet=$meubles->random();
            $couleur_meuble=$couleurs->where('type','<>',$couleur_champs->type)->random();
        }

        $blason=new Blason;
        $blason->generate_image($couleur_champs, $meuble_objet, $couleur_meuble);
        $blason->descriptif($couleur_champs, $meuble_objet, $couleur_meuble);

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

        $blason=new Blason;
        $blason->generate_image($couleur_champs, $meuble, $couleur_meuble);
        $blason->descriptif($couleur_champs, $meuble, $couleur_meuble);

        return response()->json([
            'description' => $blason->description,
            'img' => $blason->image            
        ]);
    }
}
