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

    public function generate_image(Couleur $couleur_champs, ?Meuble $meuble, ?Couleur $couleur_meuble, ?Array $attributs)
    {
        $img = Image::make(public_path().'/images/champs/plein.png');
        $img->colorize($couleur_champs->red_for_colo,$couleur_champs->green_for_colo,$couleur_champs->blue_for_colo, );
        $img->insert(public_path().'/images/champs/plein-c.png');

        if($meuble!=null)
        {
            $img_meuble=Image::make(public_path().'/images/meubles/'.$meuble->fichier.'.png');
            $img_meuble->colorize($couleur_meuble->red_for_colo,$couleur_meuble->green_for_colo,$couleur_meuble->blue_for_colo);
            
            if($attributs!=null)
            {
                foreach($attributs as $ajout)
                {
                    $attribut = $ajout['attribut'];
                   // dd($attribut);
                    $c = $ajout['couleur'];
                        $img_att=Image::make(public_path().'/images/meubles/'.$meuble->fichier.'-'.$attribut->fichier.'.png');
                        $img_att->colorize($c->red_for_colo,$c->green_for_colo,$c->blue_for_colo);
                        $img_meuble->insert($img_att);
                }
            }

            $cadre=$meuble->cadre($couleur_meuble);
            $vieux=$meuble->vieillissement($couleur_champs);

            $img_meuble->insert($cadre);
            
            $img->insert($img_meuble);
            $img->insert($vieux);

        }
        //$img=$img->resize(512,512);
        $this->image=$img->encode('data-url');
        return $this->image;
    }

    public function descriptif(Couleur $couleur_champs, ?Meuble $meuble, ?Couleur $couleur_meuble, ?Array $attributs)
    {
        $retour = $this->start_by_voyelle($couleur_champs->nom)?"D'":'De ';
        $retour.=$couleur_champs->nom." ";
        if($meuble != null)
        {
            if($this->start_by_voyelle($meuble->nom))
            {
                $retour.=" à l'";
            }
            elseif($meuble->genre=="M")
            {
                $retour.=" au ";
            }
            else
            {
                $retour .=" à la ";
            }
            $retour.=$meuble->nom." ";
            $retour.= $this->start_by_voyelle($couleur_meuble->nom)?"d'":'de ';
            $retour.=$couleur_meuble->nom."";
            if($attributs != null)
            {
                $i=0;
                foreach($attributs as $ajout)
                {
                    if(++$i==count($attributs)&&$i!=1){$retour.=" et";}
                    elseif($i!=1){$retour.=",";}
                    $retour.=" ".$ajout['attribut']->nom." ";
                    $retour.= $this->start_by_voyelle($ajout['couleur']->nom)?"d'":'de ';
                    $retour.=$ajout['couleur']->nom."";
                }
            }
        }
        else
        {
            $retour.=" plein";
        }
        $this->description=$retour;
        return $this->description;
    }
    private function start_by_voyelle($string)
    {
        $voyelle=['a','e','i','o','u','y','h'];

        return in_array($string[0],$voyelle);
    }
}
