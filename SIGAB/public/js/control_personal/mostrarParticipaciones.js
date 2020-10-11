$(document).ready(function() {
    $("#alert-idiomas").hide();

    // $('#registrar-btn-part').on('click', function () {
    //     $('#participaciones-ref').removeClass('active');
    //     $('#infoParticipaciones').promise().done(function() {
    //         $('#registrar-btn').trigger("click");
    //     });

    // });
    $("#participaciones-ref").on("click", function(e) {
        e.preventDefault();
        var $personalForm = $("#personal-form");

        if (!$personalForm[0].checkValidity()) {
            console.log($personalForm[0].checkValidity());
            $("#registrar-btn").trigger("click");
        } else {
            $("#general").removeClass("active");
            $("#infoParticipaciones").tab("show");
        }
    });

    var i = 0;
    var coleccionIdiomas = [];
    $("#agregar-btn").on("click", function() {
        coleccionIdiomas = obtenerIdiomas();
        if (coleccionIdiomas.includes("")) {
            $("#alert-idiomas")
                .fadeTo(2000, 500)
                .slideUp(500, function() {
                    $("#alert-idiomas").slideUp(500);
                });
        } else {
            $("#lista-idiomas").append(
                '<tr id="row' +
                    i +
                    '" class="idiomaRow"><td><input type="text" name="name[]" placeholder="Nombre de idioma" class="form-control idioma" /></td><td><button type="button" name="eliminar-idioma" id="' +
                    i +
                    '" class="btn btn-gris eliminar-idioma-btn"><i class="fas fa-minus-circle"></i></button></td></tr>'
            );
            i++;
        }
    });

    $(document).on("click", ".eliminar-idioma-btn", function() {
        var boton_id = $(this).attr("id");
        $("#row" + boton_id + "").remove();
    });

    function obtenerIdiomas() {
        idiomas = [];
        let inputs = $(".idioma");

        let i = 0;
        $.each(inputs, function(key, input) {
            idiomas.push(input.value);
        });
        return idiomas;
    }

    $("#aceptar-idiomas").on("click", function() {
        coleccionIdiomas = obtenerIdiomas();
        if (coleccionIdiomas.length > 1 && coleccionIdiomas.includes("")) {
            $("#alert-idiomas")
                .fadeTo(2000, 500)
                .slideUp(500, function() {
                    $("#alert-idiomas").slideUp(500);
                });
        } else {
            idiomas = JSON.stringify(coleccionIdiomas);
            $("#idiomasForm").val(idiomas);
            $("#idomasModal").modal("hide");
        }
    });

    $("#cancelar-idiomas").on("click", function() {
        coleccionIdiomas = obtenerIdiomas();
        for (let i = 0; i <= coleccionIdiomas.length; i++) {
            $(".idiomaRow").remove();
        }
        $(".idioma").val("");
    });

    //-----------------------------------------------------------------------------------------------------------







    $("#cancelar-edi").hide();
    $("#guardar-cambios").hide();
    $("#cambiar-foto").hide();

    $("#editar-estudiante").on("click", function() {
        $("input").removeAttr("disabled");
        $("select").removeAttr("disabled");
        $("textarea").removeAttr("disabled");
        $("#editar-estudiante").hide();
        $("#cancelar-edi").show();
        $("#guardar-cambios").show();
        $("#cambiar-foto").show();
    });

    $("#cancelar-edi").on("click", function () {
        $("input").attr("disabled", "disabled");
        $("select").attr("disabled", "disabled");
        $("textarea").attr("disabled", "disabled");
        $("#editar-estudiante").show();
        $("#cancelar-edi").hide();
        $("#guardar-cambios").hide();
        $("#cambiar-foto").hide();
    }






});
