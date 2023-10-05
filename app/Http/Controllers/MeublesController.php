<?php

namespace App\Http\Controllers;

use App\Models\Meuble;
use Illuminate\Http\Request;

class MeublesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('new-meuble-form');
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
        $meuble -> save();

        return back();
    }
    

}
