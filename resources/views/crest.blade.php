@extends('template')
@section('contenu')
    <h1>Blason aléatoire</h1>
    <p>La couleur choisie pour votre blason est : {{$couleur_champs->nom}}, ({{$couleur_champs->hexadecimal}}). Il s'agit d'un {{$couleur_champs->type_for_human}}</p>
    @if($aff_meuble)
    <p>La couleur choisie pour le meuble est : {{$couleur_meuble->nom}}, ({{$couleur_meuble->hexadecimal}})</p>
    @endif
    <img src='{{$blason}}' />
    
@endsection
