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
        $couleur_meuble="";
        $couleur_champs="";

        $aff_meuble=false;
        $couleurs=Couleur::all();
        $meubles=Meuble::all();

        $couleur_champs=$couleurs->random();
        

        $img = Image::make(resource_path().'/images/champs/plein.png');
        $img->colorize($couleur_champs->red_for_colo,$couleur_champs->green_for_colo,$couleur_champs->blue_for_colo, );
        $img->insert(resource_path().'/images/champs/plein-c.png');

        if(mt_rand(0,$meubles->count())!=0)
        {
            $aff_meuble=true;
            $meuble_objet=$meubles->random();
            $couleur_meuble=$couleurs->where('type','<>',$couleur_champs->type)->random();
            $meuble=Image::make(resource_path().'/images/meubles/'.$meuble_objet->fichier.'.png');
            $meuble->colorize($couleur_meuble->red_for_colo,$couleur_meuble->green_for_colo,$couleur_meuble->blue_for_colo, );
            
            $cadre=$meuble_objet->cadre($couleur_meuble);
            
            $meuble->insert($cadre);
            $img->insert($meuble);
        }

        $img->resize(512,512)->encode('data-url');;

        return view('crest',['couleur_champs'=>$couleur_champs, 
            'couleur_meuble'=>$couleur_meuble,
            'blason'=>$img->encoded,
            'aff_meuble'=>$aff_meuble]);
    }
}
