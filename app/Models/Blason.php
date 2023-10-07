<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;

class Blason extends Model
{
    use HasFactory;

    protected $attributes = [
        'image',
        'description'
    ];

    public function generate_image(Couleur $couleur_champs, ?Meuble $meuble, ?Couleur $couleur_meuble)
    {
        $img = Image::make(public_path().'/images/champs/plein.png');
        $img->colorize($couleur_champs->red_for_colo,$couleur_champs->green_for_colo,$couleur_champs->blue_for_colo, );
        $img->insert(public_path().'/images/champs/plein-c.png');

        if($meuble!=null)
        {
            $img_meuble=Image::make(public_path().'/images/meubles/'.$meuble->fichier.'.png');
            $img_meuble->colorize($couleur_meuble->red_for_colo,$couleur_meuble->green_for_colo,$couleur_meuble->blue_for_colo, );
            
            $cadre=$meuble->cadre($couleur_meuble);
            
            $img_meuble->insert($cadre);
            $img->insert($img_meuble);
        }
        $this->image=$img->resize(512,512)->encode('data-url');
        return $this->image;
    }

    public function descriptif(Couleur $couleur_champs, ?Meuble $meuble, ?Couleur $couleur_meuble)
    {
        $retour = "De ".$couleur_champs->nom." (".$couleur_champs->hexadecimal.")";
        if($meuble != null)
        {
            $retour.=" au ".$meuble->nom." de ".$couleur_meuble->nom." (".$couleur_meuble->hexadecimal.")";
        }
        else
        {
            $retour.=" plein";
        }
        $this->description=$retour;
        return $this->description;
    }
}
