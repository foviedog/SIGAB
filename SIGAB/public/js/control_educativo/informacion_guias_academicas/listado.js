let est;
$('#no-existe-estudiante').hide();
$('#cancelar-edicion').hide();
$('#terminar-edicion').hide();
$('#tooltip').hide();
$("#rellenar-campos-modificar").hide();
$("#mensaje-informacion-archivo").hide();
$("#eliminar-archivo").hide();
$("#quitar-archivo").hide();
$("#tipo").hide();
$('#fechaIni').on('click', function () {
    $('#fecha-inicio').val('');
});

/* Desaparece el mensaje de éxito */
$("#mensaje-exito").fadeTo(2000, 500).slideUp(500, function () {
    $("#mensaje-exito").slideUp(500);
});

$('#fechaFin').on('click', function () {
    $('#fecha-final').val('');
});

$('#detalle-guia-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('idguia') // Extract info from data-* attributes

    $.ajax({
        url: "/estudiante/guia-academica/" + id,
        type: "GET",
        success: function(response) {
            if (response) {
                let modal = $(this);
                $('#id-guia-modal').val(id);
                $('#cedula').text(response.persona_id);
                $('#nombre').text(response.nombre+'  '+response.apellido);
                $('#correo').text(response.correo_personal);
                $('#tipo').val(response.tipo);
                $('#lugar').val(response.lugar_atencion);
                $('#ciclo').val(response.ciclo_lectivo);
                $('#fecha').val(response.fecha);
                $('#situacion').val(response.situacion);
                $('#recomendaciones').val(response.recomendaciones);
                $('#solicitud').val(response.solicitud);

                //console.log($('#solicitud').val());

                est = response.persona_id;

                if (response.solicitud === est) {
                    $('input:radio[name="radio"]').filter('[value="est"]').attr('checked', true);
                    $('#solicitud').val(est);
                    $('#docente-mostrar').html('');
                } else {
                    $('input:radio[name="radio"]').filter('[value="docen"]').attr('checked', true);
                    //$('#lista_docentes').collapse('show');
                    $("#docente option").each  ( function() {
                        if ($(this).val().split(" ")[0] === response.solicitud)
                            $(this).prop('selected', true);
                    });
                    $('#docente-mostrar').html("<br>Solicitado por: " + $("#docente").val() + "<br><br>");
                }

                $('#tipo-mostrar').html(response.tipo);

                //console.log($("#docente").val());

                if (response.archivo_adjunto !== null) {
                    $("#archivo-adjunto-existente").addClass("card card-body");
                    $("#archivo-adjunto-existente").html(
                        "<a href='/storage/guias_archivos/" + response.archivo_adjunto + "' target='_blank'>" +
                        response.archivo_adjunto + "</a>")
                    $("#eliminar-archivo")
                        .html("<a href = '/estudiante/guia-academica/" + id + "/eliminar-archivo'>Eliminar archivo</a>");
                }

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
    if ($('#lugar').val() === '') {
        return false;
    }
    if ($('#fecha').val() === '') {
        return false;
    }
    if ($('#tipo').val() === '') {
        return false;
    }
    if ($('#ciclo').val() === '') {
        return false;
    }
    if ($('#situacion').val() === '') {
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
    $('#lugar').removeAttr('disabled');
    $('#fecha').removeAttr('disabled');
    $('#tipo').removeAttr('disabled');
    $('#docente').removeAttr('disabled');
    $('#adjuntar-archivo').removeAttr('disabled');
    $('#radio1').removeAttr('disabled');
    $('#radio2').removeAttr('disabled');
    $('#tooltip').show();
    $("#mensaje-informacion-archivo").show();
    $('#tipo').show();
    $('#tipo-mostrar').hide();
    if ($("input:radio[value='docen']:checked").val()) {
        $('#lista_docentes').collapse('show');
    }
    $('#docente-mostrar').hide();
    $("#quitar-archivo").show();
    $("#eliminar-archivo").show();
    $('#cancelar-edicion').show();
    $('#terminar-edicion').show();
    $('#habilitar-edicion').hide();
});

function cancelarEdicion() {
    $('#recomendaciones').attr("disabled", "disabled");
    $('#situacion').attr("disabled", "disabled");
    $('#ciclo').attr("disabled", "disabled");
    $('#lugar').attr("disabled", "disabled");
    $('#fecha').attr("disabled", "disabled");
    $('#tipo').attr("disabled", "disabled");
    $('#docente').attr("disabled", "disabled");
    $('#radio1').attr("disabled", "disabled");
    $('#radio2').attr("disabled", "disabled");
    $('#adjuntar-archivo').attr("disabled", "disabled");
    $('#tooltip').hide();
    $("#mensaje-informacion-archivo").hide();
    $('#lista_docentes').collapse('hide');
    $('#docente-mostrar').show();
    $('#tipo').hide();
    $('#tipo-mostrar').show();
    $("#quitar-archivo").hide();
    $("#eliminar-archivo").hide();
    $('#cancelar-edicion').hide();
    $('#habilitar-edicion').show();
    $('#terminar-edicion').hide();
}

$('#cancelar-edicion').on('click', function () {
    cancelarEdicion();
});

$('#cerrar-modal-edicion').on('click', function () {
    cancelarEdicion();
    $("#archivo-adjunto-existente").removeClass("card card-body");
    $("#archivo-adjunto-existente").html("");
    $('#tipo-mostrar').html("");
    $('#docente-mostrar').html("");
});

$('#solicitud').val(est);
$(function () {
    $("input[type='radio']").on("click", function () {
            var radioValue = $("input[name='radio']:checked").val();
            if (radioValue == "docen") {
                $('#lista_docentes').collapse('show');
                //console.log($('#solicitud').val());
            } else {
                $('#lista_docentes').collapse('hide');
                $('#solicitud').val(est);
                $("#docente").val("");
                //console.log($('#solicitud').val());
            }
    });
});

$("#docente").on("change", function () {
    $('#solicitud').val($("#docente").val().split(" ")[0]);
    //console.log($('#solicitud').val());
});

function quitarArchivo() {
    $("#adjuntar-archivo").val(null);
}
