$("body").on("click",".meuble", function(){
    console.log($(this).attr("data-id"));
    console.log($("input[name=couleur_champs]").val());
    console.log($("input[name=couleur_meuble]").val());

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
            $("#blason").attr("src",data.img.encoded);
            $(".meuble").removeClass("choiced");
            $(this).addClass("choiced");
            $("input[name=meuble]").val($(this).attr("data-id"));
            
            if($("input[name=couleur_meuble]").val()!=data.couleur_meuble)
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
$("body").on("click",".c_champs", function(){
    console.log($("input[name=meuble]").val());
    console.log($(this).attr("data-id"));
    console.log($("input[name=couleur_meuble]").val());

    $.ajax({
        context: this,
        url: "api/generate_blason",
        method: "POST",
        dataType : "json",
        data:{"meuble":$("input[name=meuble]").val(), 
            "couleur_champs":$(this).attr("data-id"),
            "couleur_meuble":$("input[name=couleur_meuble]").val(),
            "change":"couleur_champs"
        },
        success: function(data){
            $("#desc_blason").html(data.description);
            $("#blason").attr("src",data.img.encoded);
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

    $.ajax({
        context: this,
        url: "api/generate_blason",
        method: "POST",
        dataType : "json",
        data:{"meuble":$("input[name=meuble]").val(), 
            "couleur_meuble":$(this).attr("data-id"),
            "couleur_champs":$("input[name=couleur_champs]").val(),
            "change":"couleur_meuble"
        },
        success: function(data){
            $("#desc_blason").html(data.description);
            $("#blason").attr("src",data.img.encoded);
            $(".c_meuble").removeClass("choiced");
            $(this).addClass("choiced");
            $("input[name=couleur_meuble]").val($(this).attr("data-id"));
            if(data.couleur_champs!=$("input[name=couleur_champs]").val())
            {
                $("input[name=couleur_champs]").val(data.couleur_champs);
                $(".c_champs").removeClass("choiced");
                $(".c_champs[data-id="+data.couleur_champs+"]").addClass("choiced");
            }
        },
        error : function(error){
            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        }
    })
})
