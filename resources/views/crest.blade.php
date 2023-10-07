@extends('template')
@section('contenu')
    <h1>Blason aléatoire</h1>
<div class='flex-vertical'>
    <div class='flex-vertical'>
        <p id="desc_blason">{{$blason->description}}</p>
    </div>
    <div class='flex-horizontal'>
        <img id='blason' src='{{$blason->image}}' />
        <div class='flex-vertical'>
            <input type="hidden" name='couleur_champs' value="{{$couleur_champs_id }}">
            @if($aff_meuble)
            <input type="hidden" name='couleur_meuble' value="{{$couleur_meuble_id }}">
            <input type="hidden" name='meuble' value="{{$meuble_id }}">
            @else
            <input type="hidden" name='couleur_meuble' value="0">
            <input type="hidden" name='meuble' value="0">
            @endif
            <p>Couleur du champs :</p> 
            <div class='flex-horizontal'> 
            @foreach($couleurs as $c)
                <div class="carre @if($c->id==$couleur_champs_id) choiced @endif" style='background-color:{{$c->hexadecimal}}'>&nbsp;</div>
            @endforeach
            </div>
            <p>Couleur du meuble : {{$couleur_meuble_id}}</p>
            <div class='flex-horizontal'> 
            @foreach($couleurs as $c)
                <div class="carre @if($c->id==$couleur_meuble_id) choiced @endif" style='background-color:{{$c->hexadecimal}}'>&nbsp;</div>
            @endforeach
            </div>
            <p>Meuble : </p>
            <div class='flex-horizontal flex-wrap'> 
            @foreach($meubles as $m)
                    <img class="meuble gdcarre @if($m->id==$meuble_id) choiced @endif" 
                    data-id="{{$m->id}}"
                    src="images/meubles/{{$m->fichier}}-c.png" />
            @endforeach
            </div>
        </div>
    </div>
</div>
    
@endsection
