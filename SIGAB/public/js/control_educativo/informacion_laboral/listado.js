
let id_trabajo;

$('#detalle-trabajo-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('idtrabajo') // Extract info from data-* attributes
    id_trabajo = id;

    $.ajax({
        url: "/trabajo/obtener/" + id,
        type: "GET",
        success: function(response) {
            if (response) {

                /*console.log(response);
                let modal = $(this);*/

                $('#nombre_organizacion').val(response.nombre_organizacion);
                $('#jornada_laboral').val(response.jornada_laboral);
                $('#jefe_inmediato').val(response.jefe_inmediato);
                $('#tiempo_desempleado').val(response.tiempo_desempleado);
                $('#interes_capacitacion').val(response.interes_capacitacion);
                $('#tipo_organizacion').val(response.tipo_organizacion);
                $('#cargo_actual').val(response.cargo_actual);
                $('#telefono_trabajo').val(response.telefono_trabajo);
                $('#correo_trabajo').val(response.correo_trabajo);
                $('#otros_estudios').val(response.otros_estudios);

            }
        }
    });

});

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

function actualizar() {

    $('#form-actualizar').attr('action', '/trabajo/actualizar/' + id_trabajo);
    $('#form-actualizar').trigger("submit");
}

/*Contador de caracteres de Nombre de la Organizacion */
function contarCarNomOrg(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_nom_org").text(45 - len);
    }
}

/*Contador de caracteres de Tipo de Organizacion */
function contarCarTipOrg(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_tip_org").text(45 - len);
    }
}

/*Contador de caracteres de Nombre de la Organizacion */
function contarCarTiempDesempl(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_tiemp_desmp").text(45 - len);
    }
}

/*Contador de caracteres de Cargo actual */
function contarCarCargAct(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_carg_act").text(45 - len);
    }
}

/*Contador de caracteres de Jefe inmediato */
function contarCarJefInme(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_jef_inme").text(45 - len);
    }
}

/*Contador de caracteres de Telefono trabajo */
function contarCarTelfTrbj(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_tel_trbj").text(45 - len);
    }
}

/*Contador de caracteres de Jornada laboral*/
function contarCarJornLab(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_jorn_lab").text(45 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarCorrTrbj(val) {
    var len = val.value.length;
    if (len >= 80) {
        val.value = val.value.substring(0, 80);
    } else {
        $("#mostrar_cant_corr_trbj").text(80 - len);
    }
}
