// jQuery(function () {
    $("#alert-idiomas").hide();

    $("#participaciones-ref").on("click", function(e) {
        e.preventDefault();
        var $personalForm = $("#personal-form");

        if (!$personalForm[0].checkValidity()) {
            $("#registrar-btn").trigger("click");
        } else {
            $("#general").removeClass("active");
            $("#info-general").removeClass('active');
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
                '<tr id="row' + i +'" class="idiomaRow"><td><input type="text" name="name[]" placeholder="Nombre de idioma" class="form-control idioma" required/></td><td><button type="button" name="eliminar-idioma" id="' +
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

    $("#personal-form").on("submit", function () {
        coleccionIdiomas = obtenerIdiomas();
        idiomas = JSON.stringify(coleccionIdiomas);
        $("#idiomasJSON").val(idiomas);
    });


// });
