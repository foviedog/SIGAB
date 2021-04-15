

//-----------------------------------------
// GRAFICO DE BARRAS
//-----------------------------------------

data = [10, 34, 35, 18, 27, 38, 39];

var options = {
    chart: {
        width: '100%',
        type: 'bar',
        labels: [],
        locales: locales,
        defaultLocale: "es"
    },
    grid: grid,
    series: [{
        name: nameSeries,
        data: data
    }],
}

var chart = new ApexCharts(document.querySelector('#grafico_proposito'), options)
chart.render()

//-----------------------------------------
// GRAFICO DE DONA
//-----------------------------------------

let datosX = [10, 34, 18, 8];
let datosY = ["Para ejecución", "En progreso", "Ejecutada", "Cancelada"];


var options = {
    chart: {
        width: '100%',
        type: 'donut',
        labels: [],
        locales: locales,
        defaultLocale: "es"
    },
    grid: grid,
    series: datosX,
    labels: datosY
}

let plotOptions = {
    pie: {
        donut: {
            labels: {
                show: true,
                total: {
                    show: true,
                    fontSize: '35px',
                    label: 'Total',
                    color: '#373d3f',
                    formatter: function () { return 70 }
                }
            }
        }
    }
};

options["plotOptions"] = plotOptions;

var chart = new ApexCharts(document.querySelector('#grafico_estados'), options)
chart.render()
