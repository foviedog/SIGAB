$('#no-existe-estudiante').hide();
$('#cancelar-edicion').hide();
$('#terminar-edicion').hide();
$("#rellenar-campos-modificar").hide();
$('#fechaIni').on('click', function () {
    $('#fecha-inicio').val('');
});

$('#fechaFin').on('click', function () {
    $('#fecha-final').val('');
});

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
                $('#lugar-atencion').val(response.lugar_atencion);
                $('#ciclo').val(response.ciclo_lectivo);
                $('#fecha').val(response.fecha);
                $('#situacion').val(response.situacion);
                $('#recomendaciones').val(response.recomendaciones);

                let src = fotosURL+"/"+response.imagen_perfil;
                $('#imagen-modal').attr('src',src);

            }
        }
    });

});

$('#crear-guia-modal').on('click', function (event) {
    var id = $('#id-estudiante').val(); // Obtiene el valor digitado en el input de cédu
    if (id === '') {
        $("#no-existe-estudiante").html("Por favor digite una cédula.");
        $("#no-existe-estudiante").fadeTo(2000, 500).slideUp(500, function () {
            $("#no-existe-estudiante").slideUp(500);
        });
    } else {
    $.ajax({
        url: "/estudiante/guia-academica/registrar/" + id,
        type: "GET",
        success: function() {
            window.location.href = "/estudiante/guia-academica/registrar/" + id +"?aceptado=true";
        },
        statusCode: {
            404: function () {
                $("#no-existe-estudiante").html("El estudiante no existe.");
                $("#no-existe-estudiante").fadeTo(2000, 500).slideUp(500, function () {
                    $("#no-existe-estudiante").slideUp(500);
                });
            },
        }
    });
}
});

$('#terminar-edicion').on('click', function () {
    if (validarEdicion()) {
        let id_graduacion = $('#id-guia-modal').val();
        $('#form-actualizar').attr('action', '/estudiante/guia-academica/actualizar/' + id_graduacion);
        $('#form-actualizar').trigger("submit");
    } else {
        $("#rellenar-campos-modificar").fadeTo(2000, 500).slideUp(500, function () {
            $("#rellenar-campos-modificar").slideUp(500);
        });
    }

});
function validarEdicion() {
    if ($('#lugar-atencion').val() === '') {
        return false;
    }
    if ($('#fecha').val() === '') {
        return false;
    }
    if ($('#motivo').val() === '') {
        return false;
    }
    if ($('#ciclo').val() === '') {
        return false;
    }
    if ($('#situacion').val() === '') {
        return false;
    }
    if ($('#recomendaciones').val() === '') {
        return false;
    }
    return true;
}

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

function cancelarEdicion() {
    $('#recomendaciones').attr("disabled", "disabled");
    $('#situacion').attr("disabled", "disabled");
    $('#ciclo').attr("disabled", "disabled");
    $('#lugar-atencion').attr("disabled", "disabled");
    $('#fecha').attr("disabled", "disabled");
    $('#motivo').attr("disabled", "disabled");
    $('#cancelar-edicion').hide();
    $('#habilitar-edicion').show();
    $('#terminar-edicion').hide();
}

$('#cancelar-edicion').on('click', function () {
    cancelarEdicion();
});

$('#cerrar-modal-edicion').on('click', function () {
    cancelarEdicion();
});



