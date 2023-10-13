@extends('template')

@section('contenu')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h1>Nouveau meuble</h1>
<div class='flex-vertical'>
<div class='flex-horizontal'>
    <form action="{{ url('new_meuble') }}" method="POST">
        @csrf
        <label for="nom">Nom du fichier : </label>
        <input type="text" name="fichier" id="fichier">
        <label for="nom">Nom du meuble : </label>
        <input type="text" name="nom" id="nom">
        <label for="genre">Féminin ? </label>
        <x-checkbox name="genre"/>

        <div class='flex-vertical' id='attributs_form'><br />
            <input type='button' value='Ajouter un attribut' id='add_attr'>
            <div class='flex-horizontal attribut_form' data-num=1 id='attribut[1]'>
                <label for="nomAtt[1]">Nom de l'attribut n°<span class='num_attr'>1</span> : </label>
                <input type="text" name="nomAtt[1]" id="nomAtt[1]" value="">
            </div>
        </div>
        <br /><input type="submit" value="Envoyer !">
    </form>
</div>
    <h2>Meubles déjà encodés</h2>
    <div class='flex-horizontal flex-wrap'> 
        
    @foreach($meubles as $m)
        <a href="{{ url('upd_meuble') }}/{{$m->id}}"><img class="gdcarre" 
            data-id="{{$m->id}}"
            src="/images/meubles/{{$m->fichier}}-c.png" /></a>
    @endforeach
    </div>
</div>
@endsection