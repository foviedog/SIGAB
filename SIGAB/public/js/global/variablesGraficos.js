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



function generarGrafico(idRender, tipoGrafico, dataSet, contarCeros) {
    var nombreDeDatos = [];
    var datos = [];
    var total = 0;

    for (const atributo in dataSet) {
        if (!contarCeros && dataSet[atributo] != 0) {
            nombreDeDatos.push(atributo);
            datos.push(dataSet[atributo]);
            total += dataSet[atributo];
        } else {
            nombreDeDatos.push(atributo);
            datos.push(dataSet[atributo]);
            total += dataSet[atributo];
        }

    }
    console.log(nombreDeDatos);
    console.log(datos);

    var options = getOptions(tipoGrafico, datos, nombreDeDatos, total);
    console.log(options);
    var chart = new ApexCharts(document.querySelector('#' + idRender), options)
    chart.render();
}


function getOptions(tipoGrafico, datos, nombreDeDatos, totalDatos) {

    var options = {
        series: [{
            name: 'Servings',
            data: datos,
        }],
        chart: {
            type: tipoGrafico,
            defaultLocale: "es",
            locales: locales,
            height: 350,
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                columnWidth: '50%',
            },
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            fontSize: '35px',
                            label: 'Total',
                            color: '#373d3f',
                            formatter: function () { return totalDatos }
                        }
                    }
                }
            }
        },
        grid: grid,
        xaxis: {
            categories: nombreDeDatos,
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val + "%";
                }
            },
            max: 100
        },
    };
    if (tipoGrafico === "pie" || tipoGrafico === "donut") {
        options["series"] = datos
        options["labels"] = nombreDeDatos
    }

    return options;
}

