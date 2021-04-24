
xPorcentajeActual = [];
yPorcentajeActual = [];
let totalPorcentaje = 0;
for (const tipo in porcentajeParticipacionActual) {
    xPorcentajeActual.push(tipo)
    let cantParticipacion = porcentajeParticipacionActual[tipo];
    yPorcentajeActual.push(cantParticipacion);
    totalPorcentaje += cantParticipacion;
}
console.log(xPorcentajeActual);
console.log(yPorcentajeActual);
console.log(totalPorcentaje);


xPorcentajeActualAmbito = [];
yPorcentajeActualAmbito = [];
let totalPorcentajeAmbito = 0;
for (const ambito in porcentajeAmbitoActual) {
    xPorcentajeActualAmbito.push(ambito);
    let cantParticipacionAmbito = porcentajeAmbitoActual[ambito];
    yPorcentajeActualAmbito.push(cantParticipacionAmbito);
    totalPorcentajeAmbito++;
}
console.log(xPorcentajeActualAmbito);
console.log(yPorcentajeActualAmbito);
console.log(totalPorcentajeAmbito);

//---------------------------------------------------------------------------------------------
// GRAFICO PARA MEDIR EL PROCENTAJE DE PARTICIPACION EN ACTIVIDADES INTERNAS DEL ANNIO EN CURSO
//---------------------------------------------------------------------------------------------

var optionsPorcentaje = {
    chart: {
        width: '100%',
        type: 'bar',
        labels: [],
        locales: locales,
        defaultLocale: "es",
        toolbar: {
            show: true
        }
    },
    grid: grid,    
    series: [{
        name: 'Porcentaje',
        data: yPorcentajeActual
    }],
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
    yaxis: {
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false,
        },
        labels: {
            show: false,
            formatter: function (val) {
                return val + "%";
            }
        },
        max: 100
    },
    xaxis: {
        categories: xPorcentajeActual,
        position: 'bottom',
        axisBorder: {
            show: false
        },
        labels:{
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
        tooltip: {
            enabled: true,
        }
    },
    grid: grid,    
};

let plotOptionsPorcentaje = {
    bar: {
        borderRadius: 10,
        dataLabels: {
            position: 'top',
        }
    }
};

optionsPorcentaje["plotOptions"] = plotOptionsPorcentaje;

var chart = new ApexCharts(document.querySelector('#grafico_porc_act'), optionsPorcentaje)
chart.render()

//----------------------------------------------------------------------------------------------------------
// GRAFICO PARA MEDIR EL PROCENTAJE DE PARTICIPACION EN ACTIVIDADES INTERNAS POR AMBITO DEL ANNIO EN CURSO
//----------------------------------------------------------------------------------------------------------
var optionsPorcentajeAmbito = {
    chart: {
        width: '80%',
        type: 'radialBar',
        labels: [],
        locales: locales,
        defaultLocale: "es",
        toolbar: {
            show: true
        }
    },
    grid: grid,    
    series: yPorcentajeActualAmbito,
    labels: xPorcentajeActualAmbito
}

let plotOptionsPorcentajeAmbito = {
    radialBar: {
        dataLabels: {
        name: {
            fontSize: '22px',
        },
        value: {
            fontSize: '16px',
        },
        total: {
            show: true,
            label: 'Ámbitos',
            formatter: function (w) {
                    return 'Nacional - Internacional'
                }
            }
        }
    }
};

optionsPorcentajeAmbito["plotOptions"] = plotOptionsPorcentajeAmbito;

var chart = new ApexCharts(document.querySelector('#grafico_porc_amb'), optionsPorcentajeAmbito)
chart.render()

