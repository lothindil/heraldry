<?php

namespace App\Http\Controllers;

use App\Models\Meuble;
use Illuminate\Http\Request;

class MeublesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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

    /**
     * Display the specified resource.
     */
    public function show(meubles $meubles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(meubles $meubles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, meubles $meubles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(meubles $meubles)
    {
        //
    }
}
