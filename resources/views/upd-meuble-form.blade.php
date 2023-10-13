@extends('template')

@section('contenu')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class='flex-vertical'>
    <div class='flex-horizontal'>
    <x-form method="PUT" action="{{ url('upd_meuble') }}">
        @csrf
        <label for="nom">Nom du fichier : </label>
        <input type="text" name="fichier" id="fichier" value="{{$meuble->fichier}}" >
        <label for="nom">Nom du meuble : </label>
        <input type="text" name="nom" id="nom" value="{{$meuble->nom}}">
        <label for="genre">Féminin ? </label>
        @if($meuble->genre=="F")
        <x-checkbox name="genre" value="1" checked />
        @else
        <x-checkbox name="genre" value="1" />
        @endif
        <input type="hidden" name="id" id="id" value="{{$meuble->id}}">

        <div class='flex-vertical' id='attributs_form'><br />
            <input type='button' value='Ajouter un attribut' id='add_attr'>
        @php($i=0)
        @foreach($meuble->attributs as $attr)
        @php($i++)
            <div class='flex-horizontal attribut_form' data-num='{{$i}}' id='attribut[{{$i}}]'>
                <label for="nomAtt[{{$i}}]">Nom de l'attribut n°<span class='num_attr'>{{$i}}</span> : </label>
                <input type="text" name="nomAtt[{{$i}}]" id="nomAtt[{{$i}}]" value="{{$attr->nom}}">
                <input type='hidden' name='idAtt[{{$i}}]' id="idAtt[{{$i}}]" value="{{$attr->id}}">
            </div>
        @endforeach
        @if($i==0)
                <div class='flex-horizontal attribut_form' data-num='1' id='attribut[1]'>
                <label for="nomAtt[1]">Nom de l'attribut n°<span class='num_attr'>1</span> : </label>
                <input type="text" name="nomAtt[1]" id="nomAtt[1]" value="">
                <input type='hidden' name='idAtt[1]' id="idAtt[1]" value="">
            </div>
        @endif
        </div>
        <br />
        <input type="submit" value="Envoyer !">
    </x-form>
    </div>
    <div class='flex-horizontal flex-wrap'> 
    @foreach($meubles as $m)
        <a href="{{ url('upd_meuble') }}/{{$m->id}}"><img class="gdcarre" 
            data-id="{{$m->id}}"
            src="/images/meubles/{{$m->fichier}}-c.png" /></a>
    @endforeach
    </div>
</div>
@endsection