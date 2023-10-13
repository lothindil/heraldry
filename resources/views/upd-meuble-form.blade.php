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