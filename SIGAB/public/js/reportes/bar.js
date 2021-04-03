
//-----------------------------------------
// GRAFICO
//-----------------------------------------

let data = [];
for(let i = 0; i < x.length; i++){
    let obj = {x: x[i], y: y[i]}
    data.push(obj);
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
        data: data
    }],
}

var chart = new ApexCharts(document.querySelector('#chart'), options)
chart.render()