@extends('template')
@section('contenu')
    <h1>Blason aléatoire</h1>
<div class='flex-vertical'>
    <div class='flex-vertical'>
        <p>De {{$couleur_champs->nom}} ({{$couleur_champs->hexadecimal}})
        @if($aff_meuble)
        au {{$meuble->nom}} de {{$couleur_meuble->nom}} ({{$couleur_meuble->hexadecimal}})
        @else
        plein
        @endif
        </p>
    </div>
    <div class='flex-horizontal'>
        <img src='{{$blason}}' />
    <div class='flex-vertical'>
    
    </div>
    </div>
</div>
    
@endsection
