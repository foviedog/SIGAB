//-----------------------------------------
// Funcionalidades basicas
//-----------------------------------------


if (naturalezaActividad === undefined) {
    naturalezaActividad = "Actividad interna";
}
if (naturalezaActividad === 'Actividad interna') {
    mostrarTipos(0);
} else {
    mostrarTipos(1);
}

cargarTipos();


function cargarTipos() {
    let select = $("#actividad");
    select.on('change', function () {
        let val = select.val();
        if (val === "Seleccionar") limpiarTipos();
        else {
            if (val === "Actividad interna") {
                mostrarTipos(0);
            }
            if (val === "Actividad de promoción")
                mostrarTipos(1);
        }

    });
}

function mostrarTipos(tipo) {
    switch (tipo) {
        case 0:
            $("#tipo-actividad-prom").hide();
            $("#tipo-actividad-int").show();
            break;
        case 1:
            $("#tipo-actividad-int").hide();
            $("#tipo-actividad-prom").show();
            break;

    }
}

function enviar() {
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


