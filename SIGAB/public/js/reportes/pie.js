
//-----------------------------------------
// GRAFICO
//-----------------------------------------

var options = {
    chart: {
        width: '100%',
        type: 'pie',
        labels: [],
        locales: locales,
        defaultLocale: "es"
    },
    grid: grid,    
    series: y,
    labels: x
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
                    formatter: function(){ return total }
                }
            }
        }
    }
};

options["plotOptions"] = plotOptions;

var chart = new ApexCharts(document.querySelector('#chart'), options)
chart.render()