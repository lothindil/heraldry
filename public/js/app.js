const existant_crest_att=function()
{
    var attr={};
    $(".c_att.choiced").each(function(){
        attr[$(this).attr("data-attr")]=$(this).attr("data-color");
    })
    return attr;
}
$("body").on("click",".meuble", function(){
    $.ajax({
        context: this,
        url: "api/generate_blason",
        method: "POST",
        dataType : "json",
        data:{"meuble":$(this).attr("data-id"), 
            "couleur_champs":$("input[name=couleur_champs]").val(),
            "couleur_meuble":$("input[name=couleur_meuble]").val(),
            "change":"meuble"
        },
        success: function(data){
            $("#desc_blason").html(data.description);
            $("#blason").attr("src",data.img);
            $(".meuble").removeClass("choiced");
            $(this).addClass("choiced");
            $("input[name=meuble]").val($(this).attr("data-id"));
            $("#icon_meuble").attr("src",data.meuble);

            $("#color_attributes").empty();
            $.each(data.all_attributs,function(id,src){
                $("#color_sample").clone(true).appendTo("#color_attributes");
                $("#color_attributes #color_sample .c_att").attr("data-attr",id);
                $("#color_attributes #color_sample img").attr('src',src);
                $("#color_attributes #color_sample").removeAttr("style");
                $("#color_attributes #color_sample").removeAttr("id");
            });
        },
        error : function(error){
            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        }
    })
})
$("body").on("click",".c_champs", function(){
  
    var attr=existant_crest_att();

    $.ajax({
        context: this,
        url: "api/generate_blason",
        method: "POST",
        dataType : "json",
        data:{"meuble":$("input[name=meuble]").val(), 
            "couleur_champs":$(this).attr("data-id"),
            "couleur_meuble":$("input[name=couleur_meuble]").val(),
            "change":"couleur_champs",
            "attributs":attr
        },
        success: function(data){
            $("#desc_blason").html(data.description);
            $("#blason").attr("src",data.img);
            $(".c_champs").removeClass("choiced");
            $(this).addClass("choiced");
            $("input[name=couleur_champs]").val($(this).attr("data-id"));
            if(data.couleur_meuble!=$("input[name=couleur_meuble]").val())
            {
                $("input[name=couleur_meuble]").val(data.couleur_meuble);
                $(".c_meuble").removeClass("choiced");
                $(".c_meuble[data-id="+data.couleur_meuble+"]").addClass("choiced");
            }
        },
        error : function(error){
            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        }
    })
})
$("body").on("click",".c_meuble", function(){
    console.log($("input[name=meuble]").val());
    console.log($("input[name=couleur_champs]").val());
    console.log($(this).attr("data-id"));

    if($("input[name=meuble]").val()==0)
    {
        return false;
    }
    var attr=existant_crest_att();

    $.ajax({
        context: this,
        url: "api/generate_blason",
        method: "POST",
        dataType : "json",
        data:{"meuble":$("input[name=meuble]").val(), 
            "couleur_meuble":$(this).attr("data-id"),
            "couleur_champs":$("input[name=couleur_champs]").val(),
            "change":"couleur_meuble",
            "attributs":attr
        },
        success: function(data){
            $("#desc_blason").html(data.description);
            $("#blason").attr("src",data.img);
            $(".c_meuble").removeClass("choiced");
            $(this).addClass("choiced");
            $("input[name=couleur_meuble]").val($(this).attr("data-id"));
            if(data.couleur_champs!=$("input[name=couleur_champs]").val())
            {
                $("input[name=couleur_champs]").val(data.couleur_champs);
                $(".c_champs").removeClass("choiced");
                $(".c_champs[data-id="+data.couleur_champs+"]").addClass("choiced");
            }
            var attributs= data.attributs;
            console.log(attributs);
            $.each(attributs,function(attribute,couleur){
                $("[data-attr="+attribute+"]").removeClass("choiced");
                $("[data-attr="+attribute+"][data-color="+couleur+"]").addClass("choiced");
            })
        },
        error : function(error){
            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        }
    })
})
$("body").on("click",".c_att", function(){
    if($("input[name=meuble]").val()==0)
    {
        return false;
    }
    var attr=existant_crest_att();
    attr[$(this).attr("data-attr")]=$(this).attr("data-color");
    $.ajax({
        context: this,
        url: "api/generate_blason",
        method: "POST",
        dataType : "json",
        data:{"meuble":$("input[name=meuble]").val(), 
            "couleur_meuble":$("input[name=couleur_meuble]").val(),
            "couleur_champs":$("input[name=couleur_champs]").val(),
            "change":"couleur_attr",
            "attributs":attr
        },
        success: function(data){
            $("#desc_blason").html(data.description);
            $("#blason").attr("src",data.img);
            $("input[name=couleur_meuble]").val(data.couleur_meuble);
            $(".c_meuble").removeClass("choiced");
            $(".c_meuble[data-id="+data.couleur_meuble+"]").addClass("choiced");
            if(data.couleur_champs!=$("input[name=couleur_champs]").val())
            {
                $("input[name=couleur_champs]").val(data.couleur_champs);
                $(".c_champs").removeClass("choiced");
                $(".c_champs[data-id="+data.couleur_champs+"]").addClass("choiced");
            }
            var attributs= data.attributs;
            console.log(attributs);
            $.each(attributs,function(attribute,couleur){
                $("[data-attr="+attribute+"]").removeClass("choiced");
                $("[data-attr="+attribute+"][data-color="+couleur+"]").addClass("choiced");
            })
        },
        error : function(error){
            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        }
    })
});

$("body").on("click",'#add_attr', function(){
    var $tr = $(".attribut_form:last-of-type").clone(); 
    $tr.appendTo("#attributs_form");
    console.log($(".attribut_form:last-of-type").attr('data-num'));
    var numero = parseInt($(".attribut_form:last-of-type").attr('data-num'))+1;
    $(".attribut_form:last-of-type").attr('data-num',numero);
    $(".attribut_form:last-of-type").attr('id','attribut['+numero+']');
    $(".attribut_form:last-of-type span").text(numero);
    $(".attribut_form:last-of-type input[type=text]").attr('name', 'nomAtt['+numero+']');
    $(".attribut_form:last-of-type input[type=text]").attr('id', 'nomAtt['+numero+']');
    $(".attribut_form:last-of-type input[type=hidden]").attr('name', 'idAtt['+numero+']');
    $(".attribut_form:last-of-type input[type=hidden]").attr('id', 'idAtt['+numero+']');
    $(".attribut_form:last-of-type input").val('');
    $(".attribut_form:last-of-type label").attr('for', 'nomAtt['+numero+']');
});
