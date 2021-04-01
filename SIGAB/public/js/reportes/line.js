
//-----------------------------------------
// GRAFICO
//-----------------------------------------

var options = {
    chart: {
        width: '100%',
        type: 'line',
        labels: [],
        locales: locales,
        defaultLocale: "es"
    },
    grid: grid,    
    series: [{
        name: nameSeries,
        data: y
    }],
    xaxis: {
        categories: x
    }
}

var chart = new ApexCharts(document.querySelector('#chart'), options)
chart.render()