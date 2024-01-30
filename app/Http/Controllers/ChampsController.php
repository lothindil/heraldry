<?php

namespace App\Http\Controllers;

use App\Models\Champs;
use Illuminate\Http\Request;

class ChampsController extends Controller
{
    public function create()
    {
        //
        return view('new-champs-form',['champs'=>Champs::all()->sortBy(['fichier','asc'])]);
    }
        /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        //
        $champs = new Champs;
        $champs->nom = $request -> nom;
        $champs->fichier = $request -> fichier;

        $champs -> save();

        return back();
    }
    
    public function edit(Request $request)
    {
        if($request->id!=null)
        {
            $champs=Champs::find($request->id);
        }
        else
        {
            $champs=Champs::find(1);
        }
        
        return view('upd-champs-form',['champs'=>$champs,'allChamps'=>Champs::all()->sortBy(['nom','asc']) ]);
    }
    public function update(Request $request)
    {
        
        $champs =Champs::find($request->id);
        $champs->nom = $request -> nom;
        $champs->fichier = $request -> fichier;
        $champs -> save();

        $attributs = array();
        
        return $this->edit($request);
    }
}
