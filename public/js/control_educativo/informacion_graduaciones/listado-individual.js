/* Desaparece el mensaje de éxito */
$("#mensaje-exito").fadeTo(2000, 500).slideUp(500, function () {
    $("#mensaje-exito").slideUp(500);
});

/* Botón cancelar y cerrar campos */
function cancelarEdicion() {
    $("input").attr('disabled', "disabled");
    $("textarea").attr('disabled', "disabled");
    $('#terminar-edicion').hide();
    $('#cancelar-edicion').hide();
    $('#habilitar-edicion').show();
}

/* Variable global que guarda el id de la graduación que se va a
    desplegar al abri el modal */
let id_graduacion;

/* Petición al servidor de la información sobre la graduación a desplegar
   en el modal */
$('#detalle-graduacion-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que abre el modal
    var id = button.data('idgraduacion')   // Se estrae el id de la graduación
    id_graduacion = id;                    // Se guarda el id de la graduación abierta en la variable global

    //Método en AJAX que trae la información de la graduación desde el servidor
    $.ajax({
        url: "/estudiante/graduacion/obtener/" + id,
        type: "GET",
        success: function(response) {
            if (response) {

                $('#grado_academico').val(response.grado_academico);
                $('#carrera_cursada').val(response.carrera_cursada);
                $('#anio_graduacion').val(response.anio_graduacion);

            }
        }
    });

});

/* Funcionalidades para habilitar y deshaibilitar los campos de texto del modal */
$('#cancelar-edicion').hide();
$('#terminar-edicion').hide();

$('#habilitar-edicion').on('click', function () {
    $("input").removeAttr('disabled');
    $("textarea").removeAttr('disabled');
    $('#terminar-edicion').show();
    $('#cancelar-edicion').show();
    $('#habilitar-edicion').hide();
});

$('#cancelar-edicion').on('click', function () {
    $("input").attr('disabled',"disabled");
    $("textarea").attr('disabled', "disabled");
    $('#terminar-edicion').hide();
    $('#cancelar-edicion').hide();
    $('#habilitar-edicion').show();
});

/* Funcion que actualiza los datos ingresados */
function actualizar() {
    $('#form-actualizar').attr('action', '/estudiante/graduacion/actualizar/' + id_graduacion);
    $('#form-actualizar').trigger("submit");
}

/*Contador de caracteres de Grado Académico */
function contarCarGradoAcademico(val) {
    var len = val.value.length;
    if (len >= 120) {
        val.value = val.value.substring(0, 120);
    } else {
        $("#mostrar_cant_grado_academico").text(120 - len);
    }
}

/*Contador de caracteres de Carrera Cursada */
function contarCarCarrCursada(val) {
    var len = val.value.length;
    if (len >= 80) {
        val.value = val.value.substring(0, 80);
    } else {
        $("#mostrar_cant_carrera_cursada").text(80 - len);
    }
}

/*Contador de caracteres de Año de graduación */
function contarCarAnioGraduacion(val) {
    var len = val.value.length;
    if (len >= 4) {
        val.value = val.value.substring(0, 4);
    } else {
        $("#mostrar_cant_anio_graduacion").text(4 - len);
    }
}
