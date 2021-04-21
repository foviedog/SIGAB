
//-----------------------------------------
// GRAFICO
//-----------------------------------------

var options = {
    chart: {
        width: '100%',
        type: 'area',
        labels: [],
        locales: locales,
        defaultLocale: "es",
        id: "grafico",
        
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