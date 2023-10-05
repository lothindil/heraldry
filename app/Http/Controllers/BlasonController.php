<?php

namespace App\Http\Controllers;

use App\Models\Blason;
use App\Models\Couleur;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class BlasonController extends Controller
{
    /**      */
    public function create_random()
    {
        $couleurs=Couleur::all();

        $couleur_champs=$couleurs->random();
        $couleur_meuble=$couleurs->where('type','<>',$couleur_champs->type)->random();

        $img = Image::make(resource_path().'/images/champs/plein.png');
        $img->colorize($couleur_champs->red_for_colo,$couleur_champs->green_for_colo,$couleur_champs->blue_for_colo, );
        $img->insert(resource_path().'/images/champs/plein-c.png');

        if(mt_rand(0,1)==1)
        {
            $meuble=Image::make(resource_path().'/images/meubles/fleche.png');
            $meuble->colorize($couleur_meuble->red_for_colo,$couleur_meuble->green_for_colo,$couleur_meuble->blue_for_colo, );
            $meuble->insert(resource_path().'/images/meubles/fleche-c.png');
            $img->insert($meuble);
        }

        $img->resize(512,512)->encode('data-url');;

        return view('crest',['couleur_champs'=>$couleur_champs, 
            'couleur_meuble'=>$couleur_meuble,
            'blason'=>$img->encoded]);
    }
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(blason $blason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(blason $blason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, blason $blason)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(blason $blason)
    {
        //
    }
}
