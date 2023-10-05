@extends('template')
@section('contenu')
    <h1>Blason aléatoire</h1>
    <p>De {{$couleur_champs->nom}} ({{$couleur_champs->hexadecimal}})
    @if($aff_meuble)
    au {{$meuble->nom}} de {{$couleur_meuble->nom}} ({{$couleur_meuble->hexadecimal}})
    @else
    plein
    @endif
    </p>
    <img src='{{$blason}}' />
    
@endsection
