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

    var options = getOptions(tipoGrafico, datos, nombreDeDatos, total);
    var chart = new ApexCharts(document.querySelector('#' + idRender), options)
    chart.render();
}


function getOptions(tipoGrafico, datos, nombreDeDatos, totalDatos) {

    var options = {
        series: [{
            name: 'Datos',
            data: datos,
        }],
        chart: {
            type: tipoGrafico,
            defaultLocale: "es",
            locales: locales,
            height: 350,
            width: '100%',
            labels: [],
            toolbar: {
                show: true
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: {
                    position: 'top',
                }
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
            position: 'bottom',
            axisBorder: {
                show: false
            },
            labels: {
                minHeight: 150,
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val + "%";
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            max: 100
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + "%";
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
    };
    if (tipoGrafico === "pie" || tipoGrafico === "donut") {
        options["series"] = datos
        options["labels"] = nombreDeDatos
    }

    return options;
}

