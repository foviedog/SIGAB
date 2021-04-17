

//-----------------------------------------//-----------------------------------------
// GRAFICO DE BARRAS PARA MOSTAR LA CANTIDAD DE PROPÓSITOS POR ANIO
//-----------------------------------------//-----------------------------------------

let propositosData = [];
//Creación de un objeto que sirve como un "MAP" que contiene los nombres de los estados y la cantidad de actividades relacionadas a dicho estado
for (let i = 0; i < xPropositos.length; i++) {
    let obj = { x: xPropositos[i], y: yPropositos[i] }
    propositosData.push(obj);
}

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
        data: propositosData
    }],
}

var chart = new ApexCharts(document.querySelector('#grafico_proposito'), options)
chart.render()

//-----------------------------------------//-----------------------------------------
// GRAFICO DE DONA PARA MOSTRAR LOS ESTADOS DE ACTIVIDADES DEL AÑO
//-----------------------------------------//-----------------------------------------
var opcionesEstado = {
    chart: {
        width: '100%',
        type: 'donut',
        labels: [],
        locales: locales,
        defaultLocale: "es"
    },
    grid: grid,
    series: yEstados,
    labels: xEstados
}

let configuracionDona = {
    pie: {
        donut: {
            labels: {
                show: true,
                total: {
                    show: true,
                    fontSize: '35px',
                    label: 'Total',
                    color: '#373d3f',
                    formatter: function () { return totalEstados }
                }
            }
        }
    }
};

opcionesEstado["plotOptions"] = configuracionDona;

var chart = new ApexCharts(document.querySelector('#grafico_estados'), opcionesEstado)
chart.render()
