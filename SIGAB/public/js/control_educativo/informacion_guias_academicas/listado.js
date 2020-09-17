
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

$('#habilitar-edicion').on('click', function () {
    $('#recomendacion').removeAttr('disabled');


});



// setTimeout(function(){ console.log("Hello"); }, 3000);
