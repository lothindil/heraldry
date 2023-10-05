<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Couleur extends Model
{
    protected $table = 'couleurs';

    public function getTypeForHumanAttribute(){
        if($this->type=="M")
        {
            return "métal";
        }
        return "émail";
    }

    public function getRedForColoAttribute(){
        $red=substr($this->hexadecimal,1,2);
        return $this->valForColorize(hexdec($red));
    }
    public function getGreenForColoAttribute(){
        $green=substr($this->hexadecimal,3,2);
        return $this->valForColorize(hexdec($green));
    }
    public function getBlueForColoAttribute(){
        $blue=substr($this->hexadecimal,5,2);
        return $this->valForColorize(hexdec($blue));
    }
    public function valForColorize($valeur){
        return $valeur/256*100;
    }
}
