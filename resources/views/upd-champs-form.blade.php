@extends('template')

@section('contenu')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h1>Édition d'une partition</h1>
<div class='flex-vertical'>
    <div class='flex-horizontal'>
    <x-form method="PUT" action="{{ url('upd_champs') }}">
        @csrf
        <label for="nom">Nom du fichier : </label>
        <input type="text" name="fichier" id="fichier" value="{{$champs->fichier}}" >
        <label for="nom">Nom du meuble : </label>
        <input type="text" name="nom" id="nom" value="{{$champs->nom}}">
        <input type="hidden" name="id" id="id" value="{{$champs->id}}">

        <br />
        <input type="submit" value="Envoyer !">
    </x-form>
    </div>
    <br />
    <div class='flex-horizontal flex-wrap'> 
    @foreach($allChamps as $c)
        <a href="{{ url('upd_champs') }}/{{$c->id}}"><img class="gdcarre" 
            data-id="{{$c->id}}"
            src="{{asset('/images/champs/chp-'.$c->fichier.'.png')}}" /></a>
    @endforeach
    </div>
</div>
@endsection