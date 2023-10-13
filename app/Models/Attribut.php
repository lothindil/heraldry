<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribut extends Model
{
    protected $table = 'attributs';

    protected $fillable = [
       'nom'
    ];

    public function meuble(): BelongsTo
    {
        return $this->belongsTo(Meuble::class);
    }

    
    private function clean_accent($string)
    {
        $str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. 'œ'
        $str = html_entity_decode($str); 
    }
}
