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
      'nom', 'fichier'
   ];

   public function cadre(Couleur $couleur)
    {
        $cadre=Image::make(resource_path().'/images/meubles/'.$this->fichier.'-c.png');
        if($couleur->hexadecimal=="#020202")
        {
            $cadre->colorize(20,20,20);
        }
        return $cadre;
    }
}
