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
            "couleur_meuble":$("input[name=couleur_meuble]").val()
        },
        success: function(data){
            $("#desc_blason").html(data.description);
            $("#blason").attr("src",data.img.encoded);
            $(".meuble").removeClass("choiced");
            $(this).addClass("choiced");
            $("input[name=meuble]").val($(this).attr("data-id"));
        },
        error : function(error){
            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        }
    })
})
