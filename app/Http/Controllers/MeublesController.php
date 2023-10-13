<?php

namespace App\Http\Controllers;

use App\Models\Meuble;
use App\Models\Attribut;
use Illuminate\Http\Request;

class MeublesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('new-meuble-form',['meubles'=>Meuble::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        //
        $meuble = new Meuble;
        $meuble->nom = $request -> nom;
        $meuble->fichier = $request -> fichier;
        if($request->has('genre')){$meuble->genre='F';}else{$meuble->genre='M';}

        $meuble -> save();

        $attributs = array();
        foreach($request->nomAtt as $nom)
        {
            if($nom!='')
            {
                $attributs[]=['nom'=>$nom];
            }            
        }
        
        $meuble->attributs()->createMany($attributs);

        return back();
    }
    
    public function edit(Request $request)
    {
        if($request->id!=null)
        {
            $meuble=Meuble::find($request->id);
        }
        else
        {
            $meuble=Meuble::find(1);
        }
        $meuble->genreChk='';
        if($meuble->genre=="F"){$meuble->genreChk='checked';}


        return view('upd-meuble-form',['meuble'=>$meuble,'meubles'=>Meuble::all()->sortBy(['nom','asc']) ]);
    }
    public function update(Request $request)
    {
        
        $meuble =Meuble::find($request->id);
        $meuble->nom = $request -> nom;
        $meuble->fichier = $request -> fichier;
        if($request->has('genre')){$meuble->genre='F';}else{$meuble->genre='M';}
        $meuble -> save();

        $attributs = array();
        foreach($request->nomAtt as $k=>$nom)
        {
            if($nom!='')
            {
                if($request->idAtt[$k]==''){$id=null;}
                else{$id=$request->idAtt[$k];}

                $attributs[]=['id'=>$id,'meuble_id'=>$meuble->id,'nom'=>$nom];
            }            
        }
        $meuble->attributs()->upsert($attributs, ['id']);

        return $this->edit($request);
    }
}
