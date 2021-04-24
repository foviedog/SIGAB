document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });

//-----------------------------------------
// Funcionalidades basicas
//-----------------------------------------

function cargaInicial(event) {
    ocultarInfoPersonal();
    if(flagInfoPersonal){
        buscarPersonal();
    }
}

function ocultarInfoPersonal(){
    $("#info-personal").hide();
    $("#no-seleccionado").show();
    $("#boton-enviar").hide();
}

function mostrarInfoPersonal(){
    $("#no-seleccionado").hide();
    $("#info-personal").show();
    $("#boton-enviar").show();
}

function llenarInformacionPersonal(persona, personal){
    let src = fotosURL + "/" + persona.imagen_perfil;
    $("#imagen-personal").attr("src", src);
    $("#personal-encontrado").val(persona.persona_id);
    $("#nombre-personal").html(persona.nombre);
    $("#tipo-puesto1-personal").html(personal.tipo_puesto_1);
    if(personal.tipo_puesto_2)
        $("#tipo-puesto2-personal").html(personal.tipo_puesto_2);
    else
        $("#tipo-puesto2-personal").html("No cuenta con segundo puesto");
    $("#jornada-laboral-personal").html(personal.jornada);
    mostrarInfoPersonal();
}

function buscarPersonal(){
    if ($("#cedula-personal").val() === "") {
        $("#seccion-graficos").html("");
        errorNoEncontrado();
    } else {
        $.ajax({
            url:
                "/reportes/involucramiento/personal/" +
                $("#cedula-personal").val(),
            dataType: "json",
            method: "GET",
            success: function(datos) {
                if(!flagInfoPersonal){
                    $("#seccion-graficos").html("");
                }
                flagInfoPersonal = false;
                llenarInformacionPersonal(datos[0], datos[1]);
            },
            statusCode: {
                404: function() {
                    errorNoEncontrado();
                }
            }
        });
    }
}

function errorNoEncontrado() {
    ocultarInfoPersonal();
    $("#personal-encontrado").val("false");
    let src = fotosURL + "/default.jpg";
    $("#imagen-personal").attr("src", src);
    desplegarAlerta("La cédula digitada no corresponde a ningún miembro del personal");
    $("#seccion-graficos").html("");
}

function desplegarAlerta(contenido) {
    $("#mensaje-alerta").html(contenido);
    $("#mensaje-alerta")
        .fadeTo(2000, 500)
        .slideUp(500, function() {
            $("#mensaje-alerta").slideUp(500);
        });
}

function enviar(){
    $("#formulario-reporte").trigger("submit");
}

//-----------------------------------------
// Variables globales para el grafico
//-----------------------------------------

let locales = [{
    "name": "es",
    "options": {
        "months": [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ],
        "shortMonths": [
            "Ene", "Feb", "Mar", "Abr", "May", "Jun",
            "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
        ],
        "days": [
            "Domingo", "Lunes", "Martes", "Miércoles",
            "Jueves", "Viernes", "Sábado"
        ],
        "shortDays": ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        "toolbar": {
            "exportToSVG": "Descargar SVG",
            "exportToPNG": "Descargar PNG",
            "exportToCSV": "Descargar CSV",
            "menu": "Menu",
            "selection": "Seleccionar",
            "selectionZoom": "Seleccionar Zoom",
            "zoomIn": "Aumentar",
            "zoomOut": "Disminuir",
            "pan": "Navegación",
            "reset": "Reiniciar Zoom"
        }
    }
}];

let grid = {
    show: true,
    borderColor: '#ECECEC',
    strokeDashArray: 0,
    position: 'back',
    xaxis: {
        lines: {
            show: true
        }
    },
    yaxis: {
        lines: {
            show: true
        }
    }
};

let nameSeries = "Total"
