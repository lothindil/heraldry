<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Couleur;

class Meuble extends Model
{
   protected $table = 'meubles';

   protected $fillable = [
      'nom', 'fichier', 'genre'
   ];

   public function attributs()
    {
        return $this->hasMany(Attribut::class);
    }

   public function cadre(Couleur $couleur)
    {
        $cadre=Image::make(public_path().'/images/meubles/'.$this->fichier.'-c.png');
        if($couleur->hexadecimal=="#020202")
        {
            $cadre->colorize(20,20,20);
        }
        return $cadre;
    }
    public function vieillissement(Couleur $couleur)
    {
        $vieux=Image::make(public_path().'/images/champs/vieux.png');
        if($couleur->hexadecimal=="#020202")
        {
            $vieux->colorize(10,10,10);
        }
        elseif($couleur->hexadecimal=="#a41619")
        {
            $vieux->colorize(-15,-10,-5);
        }
        return $vieux;
    }
}
