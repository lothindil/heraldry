<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
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
    private function IM()
    {
        return new ImageManager(new Driver());
    }
   public function cadre(Couleur $couleur)
    {
        $manager=self::IM();
        $cadre=$manager->read(public_path().'/images/meubles/'.$this->fichier.'-c.png');
        if($couleur->hexadecimal=="#020202")
        {
            $cadre->colorize(20,20,20);
        }
        return $cadre;
    }
    public function vieillissement(Couleur $couleur)
    {
        $manager=self::IM();
        $vieux=$manager->read(public_path().'/images/champs/vieux.png');
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
