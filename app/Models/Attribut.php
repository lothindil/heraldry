<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribut extends Model
{
    protected $table = 'attributs';

    protected $fillable = [
       'nom'
    ];

    protected $appends=['fichier'];

    public function meuble()
    {
        return $this->belongsTo(Meuble::class);
    }

    public function getFichierAttribute()
    {
        $fichier = $this->clean_accent($this->nom);
        return substr($fichier,0,3);
    }

    public function getFichier()
    {
        $fichier = $this->clean_accent($this->nom);
        return substr($fichier,0,3);
    }
    
    private function clean_accent($string)
    {
        $string = htmlentities($string, ENT_NOQUOTES, 'utf-8');
        $string = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $string);
        $string = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string); // pour les ligatures e.g. 'œ'
        $string = html_entity_decode($string); 
        return $string;
    }
}
