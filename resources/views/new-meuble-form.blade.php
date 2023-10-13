@extends('template')

@section('contenu')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<form action="{{ url('new_meuble') }}" method="POST">
        @csrf
        <label for="nom">Nom du fichier : </label>
        <input type="text" name="fichier" id="fichier">
        <label for="nom">Nom du meuble : </label>
        <input type="text" name="nom" id="nom">
        <label for="genre">Féminin ? </label>
        <x-checkbox name="genre"/>
        <input type="submit" value="Envoyer !">
    </form>
<ul>
    @foreach($meubles as $meuble)
        <li>{{$meuble->nom}}</li>

    @endforeach
@endsection