@extends('template')
@section('contenu')
    <h1>Blason aléatoire</h1>
<div id="crest_container">
    <div class="flex-vertical" id="flex_crest">
        <p id="desc_blason">{{$blason->description}}</p>
        <input type="hidden" name='couleur_champs' value="{{$couleur_champs_id }}">
        <input type="hidden" name='couleur_meuble' value="{{$couleur_meuble_id }}">
        <input type="hidden" name='meuble' value="{{$meuble_id }}">
        <img id='blason' src='{{$blason->image}}' />
    </div>
        
    <div id="flex_champs">
        <div id="ui_choice_color_champs" class="roue_color">
            <div><img id="icon_champs" src="{{asset('images/champs/plein-t.png')}}" /></div> 
        @foreach($couleurs as $c)
            <div class="c_champs circle @if($c->id==$couleur_champs_id) choiced @endif" 
            data-id="{{$c->id}}" data-type="{{$c->type}}"
            style='background-color:{{$c->hexadecimal}}'>&nbsp;</div>
        @endforeach
        </div>
    </div>

    <div id="flex_meuble">
        @if($aff_meuble)
        <div id='ui_choice_color_meuble' class="roue_color">
            <div><img id="icon_meuble" src="{{asset('images/meubles/'.$meuble_fichier.'.png')}}" /></div>  
        @foreach($couleurs as $c)
            <div class="c_meuble circle @if($c->id==$couleur_meuble_id) choiced @endif" 
                data-id="{{$c->id}}" data-type="{{$c->type}}"
                style='background-color:{{$c->hexadecimal}}'>&nbsp;</div>
        @endforeach
        </div>
        @endif
    </div>
</div>
<div id="attributes_container">
    <div id="color_attributes">
            @foreach($all_attributs as $a)
                @php
                    $cAtt=0;
                    if(array_key_exists($a->id,$attributs))
                    {
                        $cAtt=$attributs[$a->id];
                    }
            @endphp
            <div class="roue_color roue_color_empty">
                <div><img class="icon_attribut" src="{{asset('images/meubles/'.$meuble_fichier.'-'.$a->fichier.'.png')}}" /></div> 
                    @foreach($couleurs as $c)
                <div class="c_att circle @if($c->id==$cAtt) choiced @endif" 
                data-color="{{$c->id}}" data-attr="{{$a->id}}"
                style='background-color:{{$c->hexadecimal}}'>&nbsp;</div>
                    
                @endforeach()
                <div class="c_att circle @if($cAtt==0) choiced @endif"
                data-color="0" data-attr="{{$a->id}}">&nbsp;</div>
            </div>
            @endforeach
    </div>
</div>
<div id="autres_meubles">
        <p>Meuble : </p>
        <div class='flex-horizontal flex-wrap'> 
        @foreach($meubles as $m)
                <img class="meuble gdcarre @if($m->id==$meuble_id) choiced @endif" 
                data-id="{{$m->id}}"
                src="images/meubles/{{$m->fichier}}-c.png" />
        @endforeach
        </div>
    </div>

    <div class="roue_color roue_color_empty" id="color_sample" style="display:none">
        <div><img class="icon_attribut" src="" /></div>
                @foreach($couleurs as $c)
            <div class="c_att circle" 
            data-color="{{$c->id}}" data-attr=""
            style='background-color:{{$c->hexadecimal}}'>&nbsp;</div>
            
        @endforeach()
        <div class="c_att circle"
            data-color="0" data-attr="">&nbsp;</div>
    </div>
    
@endsection
