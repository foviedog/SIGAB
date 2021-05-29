/* Desaparece el mensaje de éxito */
$("#mensaje-exito").fadeTo(2000, 500).slideUp(500, function () {
    $("#mensaje-exito").slideUp(500);
});

/* Botón cancelar y cerrar campos */
function cancelarEdicion() {
    $("input").attr('disabled', "disabled");
    $("#ciclo_lectivo").attr('disabled', "disabled");
    $("#anio").attr('disabled', "disabled");
    $("#nombre_curso").attr('disabled', "disabled");
    $('#terminar-edicion').hide();
    $('#cancelar-edicion').hide();
    $('#habilitar-edicion').show();
}

/* Variable global que guarda el id de la carga academica que se va a
    desplegar al abri el modal */
let id_carga_academica;

/* Petición al servidor de la información sobre la carga academica a desplegar
   en el modal */
$('#detalle-carga_academica-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que abre el modal
    var id = button.data('idcarga_academica')   // Se estrae el id de la carga_academica
    id_carga_academica = id;                    // Se guarda el id de la carga academica abierta en la variable global

    //Método en AJAX que trae la información de la carga academica desde el servidor
    $.ajax({
        url: rutas['cargaacademica.edit'] + id,
        type: "GET",
        success: function(response) {
            if (response) {

                $('#ciclo_lectivo').val(response.ciclo_lectivo);
                $('#anio').val(response.anio);
                $('#nombre_curso').val(response.nombre_curso);
                $('#nrc').val(response.nrc);

            }
        }
    });

});

function rutaCargaAcademica(id){   
    $("#form-eliminar").attr('action', rutas['cargaacademica.delete'] + id);
}


/* Funcionalidades para habilitar y deshaibilitar los campos de texto del modal */
$('#cancelar-edicion').hide();
$('#terminar-edicion').hide();

$('#habilitar-edicion').on('click', function () {
    $("input").removeAttr('disabled');
    $("#ciclo_lectivo").removeAttr('disabled');
    $("#anio").removeAttr('disabled');
    $("#nombre_curso").removeAttr('disabled');
    $('#terminar-edicion').show();
    $('#cancelar-edicion').show();
    $('#habilitar-edicion').hide();
});

$('#cancelar-edicion').on('click', function () {
    $("input").attr('disabled',"disabled");
    $("#ciclo_lectivo").attr('disabled', "disabled");
    $("#anio").attr('disabled', "disabled");
    $("#nombre_curso").attr('disabled', "disabled");
    $('#terminar-edicion').hide();
    $('#cancelar-edicion').hide();
    $('#habilitar-edicion').show();
});

/* Funcion que actualiza los datos ingresados */
function actualizar() {
    $('#form-actualizar').attr('action', '/personal/carga-academica/actualizar/' + id_carga_academica);
    $('#form-actualizar').trigger("submit");
}
