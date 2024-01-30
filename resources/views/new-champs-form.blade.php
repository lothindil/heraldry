@extends('template')

@section('contenu')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h1>Nouvelle partition</h1>
<div class='flex-vertical'>
<div class='flex-horizontal'>
    <form action="{{ url('new_champs') }}" method="POST">
        @csrf
        <label for="nom">Nom du fichier : </label>
        <input type="text" name="fichier" id="fichier">
        <label for="nom">Nom du champs : </label>
        <input type="text" name="nom" id="nom">

        <br /><input type="submit" value="Envoyer !">
    </form>
</div>
    <h2>Champs déjà encodés</h2>
    <div class='flex-horizontal flex-wrap'> 
        
    @foreach($champs as $c)
        <a href="{{ url('upd_champs') }}/{{$c->id}}"><img class="gdcarre" 
            data-id="{{$c->id}}"
            src="{{asset('/images/champs/chp-'.$c->fichier.'.png')}}" /></a>
    @endforeach
    </div>
</div>
@endsection