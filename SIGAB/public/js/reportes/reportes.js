//-----------------------------------------
// Funcionalidades basicas
//-----------------------------------------

cargarTipos();

function cargarTipos(){
    let select = $("#actividad");
    let selectTipos = $("#tipo-actividad");
    let act;
    select.on('change', function() {   
        let val = select.val();
        if(val === "Seleccionar") limpiarTipos();
        else {
            if(val === "Actividad interna") act = 0;
            if(val === "Actividad de promoción") act = 1;
            $.ajax({
                url: "/tipos-actividad/" + act,
                type: "GET",
                success: function(tipos) {
                    limpiarTipos();
                    console.log(tipos);
                    for(let i = 0; i < tipos.length; i++){
                        let option = $("<option />");
                        option.html(tipos[i]);
                        option.attr('value', tipos[i]);
                        selectTipos.append(option);
                    }
                },
                statusCode: {
                    404: function() {
                        console.log("Error al cargar tipos");
                    }
                }
            });
        }

    });
}

function limpiarTipos(){
    $("#tipo-actividad").html("");
    $("#tipo-actividad").append("<option selected>Seleccionar tipo actividad</option>");
}

function enviar(){
    $("#formulario-reporte").submit();
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