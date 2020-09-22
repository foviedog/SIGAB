$('#no-existe-estudiante').hide();
$('#cancelar-edicion').hide();
$('#terminar-edicion').hide();

$('#detalle-guia-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('idestudiante') // Extract info from data-* attributes

    $.ajax({
        url: "/estudiante/guia-academica/" + id,
        type: "GET",
        success: function(response) {
            if (response) {
                console.log(response);
                let modal = $(this);
                $('#id-guia-modal').val(id);
                $('#cedula').text(response.persona_id);
                $('#nombre').text(response.nombre+'  '+response.apellido);
                $('#correo').text(response.correo_personal);
                $('#motivo').val(response.motivo);
                $('#lugar-atencion').val(response.persona_id);
                $('#ciclo').val(response.ciclo_lectivo);
                $('#fecha').val(response.fecha);
                $('#situacion').val(response.situacion);
                $('#recomendaciones').val(response.recomendaciones);

                let src = fotosURL+"/"+response.imagen_perfil;
                $('#imagen-modal').attr('src',src);{{  }}{{  }}

            }
        }
    });

});

$('#crear-guia-modal').on('click', function (event) {
    var id = $('#id-estudiante').val(); // Obtiene el valor digitado en el input de cédula

    $.ajax({
        url: "/estudiante/guia-academica/registrar/" + id,
        type: "GET",
        success: function() {
            window.location.href = "/estudiante/guia-academica/registrar/" + id +"?aceptado=true";
        },
        statusCode: {
            404: function () {
                $("#no-existe-estudiante").fadeTo(1000, 500).slideUp(500, function () {
                    $("#no-existe-estudiante").slideUp(500);
                });
            },
            503: function() {
                // Service Unavailable (503)
                // This code will be executed if the server returns a 503 response
            }
        }
    });
});

$('#terminar-edicion').on('click', function () {
    let id_graduacion = $('#id-guia-modal').val();
    $('#form-actualizar').attr('action', '/estudiante/guia-academica/actualizar/' + id_graduacion);
    $('#form-actualizar').trigger("submit");
});

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

$('#habilitar-edicion').on('click', function () {
    $('#recomendaciones').removeAttr('disabled');
    $('#situacion').removeAttr('disabled');
    $('#ciclo').removeAttr('disabled');
    $('#lugar-atencion').removeAttr('disabled');
    $('#fecha').removeAttr('disabled');
    $('#motivo').removeAttr('disabled');
    $('#cancelar-edicion').show();
    $('#terminar-edicion').show();
    $('#habilitar-edicion').hide();

});

$('#cancelar-edicion').on('click', function () {
    $('#recomendaciones').attr("disabled", "disabled");
    $('#situacion').attr("disabled", "disabled");
    $('#ciclo').attr("disabled", "disabled");
    $('#lugar-atencion').attr("disabled", "disabled");
    $('#fecha').attr("disabled", "disabled");
    $('#motivo').attr("disabled", "disabled");
    $('#cancelar-edicion').hide();
    $('#habilitar-edicion').show();
    $('#terminar-edicion').hide();

});


$('#fechaIni').on('click', function () {
    $('#fecha-inicio').removeAttr('value');
});
$('#fechaFin').on('click', function () {
    $('#fecha-final').removeAttr('value');
});

// setTimeout(function(){ console.log("Hello"); }, 3000);
