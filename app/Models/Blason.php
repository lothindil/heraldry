<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Blason extends Model
{
    use HasFactory;

    protected $attributes = [
        'image',
        'description'
    ];
    private function IM()
    {
        return $manager = ImageManager::withDriver(Driver::class);
    }

    public function generate_image(Couleur $couleur_champs, ?String $champs_secondaire, ?Couleur $couleur_champs2,
            ?Meuble $meuble, ?Couleur $couleur_meuble,?Array $attributs)
    {
        $manager=self::IM();
        $img = $manager->read(public_path().'/images/champs/plein.png');
        $img->colorize($couleur_champs->red_for_colo,$couleur_champs->green_for_colo,$couleur_champs->blue_for_colo, );
        

        if($champs_secondaire != null)
        {
            $img_chp = $manager->read(public_path().'/images/champs/chp-'.$champs_secondaire.'.png');
            $img_chp->colorize($couleur_champs2->red_for_colo,$couleur_champs2->green_for_colo,$couleur_champs2->blue_for_colo);
            $img->place($img_chp);
        }
        $img->place(public_path().'/images/champs/plein-c.png');

        if($meuble!=null)
        {
            $img_meuble=$manager->read(public_path().'/images/meubles/'.$meuble->fichier.'.png');
            $img_meuble->colorize($couleur_meuble->red_for_colo,$couleur_meuble->green_for_colo,$couleur_meuble->blue_for_colo);
            
            if($attributs!=null)
            {
                foreach($attributs as $ajout)
                {
                    $attribut = $ajout['attribut'];
                   // dd($attribut);
                    $c = $ajout['couleur'];
                        $img_att=$manager->read(public_path().'/images/meubles/'.$meuble->fichier.'-'.$attribut->fichier.'.png');
                        $img_att->colorize($c->red_for_colo,$c->green_for_colo,$c->blue_for_colo);
                        $img_meuble->place($img_att);
                }
            }

            $cadre=$meuble->cadre($couleur_meuble);
            $vieux=$meuble->vieillissement($couleur_champs);

            $img_meuble->place($cadre);
            
            $img->place($img_meuble);
            $img->place($vieux);

        }
        $img=$img->resize(512,512);
        $this->image=$img->toPng()->toDataUri();
        return $this->image;
    }

    public function descriptif(Couleur $couleur_champs, ?String $champs_secondaire, ?Couleur $couleur_champs2,
             ?Meuble $meuble, ?Couleur $couleur_meuble, ?Array $attributs)
    {
        $retour="";
        if($champs_secondaire==null)
        {
            $retour.= $this->start_by_voyelle($couleur_champs->nom)?"D'":'De ';
            $retour.=$couleur_champs->nom." ";
        }
        else
        {
            $retour.=ucfirst($champs_secondaire)." ";
            $retour.= $this->start_by_voyelle($couleur_champs->nom)?"d'":'de ';
            $retour.=$couleur_champs->nom." et ";
            $retour.= $this->start_by_voyelle($couleur_champs2->nom)?"d'":'de ';
            $retour.=$couleur_champs2->nom." ";
        }
        
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
