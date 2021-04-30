document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

//Variables para los gráficos
let tiposAsistencia = dataSet[0];
let tiposAsistenciaX = [];
let tiposAsistenciaY = [];
let totalTiposAsistencia = 0;

let fechasAsistencia = dataSet[1];
let fechasAsistenciaX = [];
let fechasAsistenciaY = [];
let totalFechasAsistencia = 0;

let ambitoAsistencia = dataSet[2];
let ambitoAsistenciaX = [];
let ambitoAsistenciaY = [];
let totalAmbitoAsistencia = 0;

let tiposCoordinacion = dataSet[3];
let tiposCoordinacionX = [];
let tiposCoordinacionY = [];
let totalTiposCoordinacion = 0;

let fechasCoordinacion = dataSet[4];
let fechasCoordinacionX = [];
let fechasCoordinacionY = [];
let totalFechasCoordinacion = 0;

let ambitoCoordinacion = dataSet[5];
let ambitoCoordinacionX = [];
let ambitoCoordinacionY = [];
let totalAmbitoCoordinacion = 0;


function cargaInicial(event) {
    cargarInformacionArrays();
}

function cargarInformacionArrays() {
    //Meses para agregar al formateo
    let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre",];

    //Tipos Asistencia
    for (const atributo in tiposAsistencia) {
        if (tiposAsistencia[atributo] != 0) {
            tiposAsistenciaX.push(atributo);
            tiposAsistenciaY.push(tiposAsistencia[atributo]);
            totalTiposAsistencia++;
        }
    }

    //Fechas Asistencia
    for (const atributo in fechasAsistencia) {
        if (fechasAsistencia[atributo] != 0) {
            let aux = new Date(atributo);
            fechasAsistenciaX.push(meses[aux.getMonth()] + " del " + aux.getFullYear());
            fechasAsistenciaY.push(fechasAsistencia[atributo]);
            totalFechasAsistencia++;
        }
    }
    //Ámbito Asistencia
    for (const atributo in ambitoAsistencia) {
        if (ambitoAsistencia[atributo] != 0) {
            ambitoAsistenciaX.push(atributo);
            ambitoAsistenciaY.push(ambitoAsistencia[atributo]);
            totalAmbitoAsistencia += ambitoAsistencia[atributo];
        }
    }

    //Tipos Coordinacion
    for (const atributo in tiposCoordinacion) {
        if (tiposCoordinacion[atributo] != 0) {
            tiposCoordinacionX.push(atributo);
            tiposCoordinacionY.push(tiposCoordinacion[atributo]);
            totalTiposCoordinacion += tiposCoordinacion[atributo];
        }
    }

    //Fechas Coordinacion
    for (const atributo in fechasCoordinacion) {
        if (fechasCoordinacion[atributo] != 0) {
            let aux = new Date(atributo);
            fechasCoordinacionX.push(meses[aux.getMonth()] + " del " + aux.getFullYear());
            fechasCoordinacionY.push(fechasCoordinacion[atributo]);
            totalFechasCoordinacion++;
        }
    }

    //Ambito Coordinacion
    for (const atributo in ambitoCoordinacion) {
        if (ambitoCoordinacion[atributo] != 0) {
            ambitoCoordinacionX.push(atributo);
            ambitoCoordinacionY.push(ambitoCoordinacion[atributo]);
            totalAmbitoCoordinacion++;
        }
    }

}



//-----------------------------------------
// GRAFICO ASISTENCIA POR TIPOS
//-----------------------------------------

var optionsAsisTip = {
    chart: {
        width: '100%',
        type: 'donut',
        labels: [],
        locales: locales,
        defaultLocale: "es",
        toolbar: {
            show: true
        }
    },
    grid: grid,
    series: tiposAsistenciaY,
    labels: tiposAsistenciaX
}

let plotOptionsAsisTip = {
    pie: {
        donut: {
            labels: {
                show: true,
                total: {
                    show: true,
                    fontSize: '35px',
                    label: 'Total',
                    color: '#373d3f',
                    formatter: function () { return totalTiposAsistencia }
                }
            }
        }
    }
};

optionsAsisTip["plotOptions"] = plotOptionsAsisTip;

var chart = new ApexCharts(document.querySelector('#grafico_asis_tipos'), optionsAsisTip)
chart.render()

//-----------------------------------------
// GRAFICO COORDINACION POR TIPOS
//-----------------------------------------

var optionsCoorTip = {
    chart: {
        width: '100%',
        type: 'donut',
        labels: [],
        locales: locales,
        defaultLocale: "es",
        toolbar: {
            show: true
        }
    },
    grid: grid,
    series: tiposCoordinacionY,
    labels: tiposCoordinacionX
}

let plotOptionsCoorTip = {
    pie: {
        donut: {
            labels: {
                show: true,
                total: {
                    show: true,
                    fontSize: '35px',
                    label: 'Total',
                    color: '#373d3f',
                    formatter: function () { return totalTiposCoordinacion }
                }
            }
        }
    }
};

optionsCoorTip["plotOptions"] = plotOptionsCoorTip;

var chart = new ApexCharts(document.querySelector('#grafico_coord_tipos'), optionsCoorTip)
chart.render()


//-----------------------------------------
// GRAFICO ASISTENCIA POR FECHA
//-----------------------------------------

var optionsAsisFecha = {
    chart: {
        width: '100%',
        type: 'bar',
        labels: [],
        locales: locales,
        defaultLocale: "es",
    },
    plotOptions: {
        bar: {
            distributed: true
        }
    },
    plotOptions: {
        bar: {
            distributed: true
        }
    },
    grid: grid,
    series: [{
        name: nameSeries,
        data: fechasAsistenciaY
    }],
    xaxis: {
        categories: fechasAsistenciaX
    }
}

var chart = new ApexCharts(document.querySelector('#grafico_asis_fecha'), optionsAsisFecha)
chart.render()


//-----------------------------------------
// GRAFICO COORDINACION POR FECHA
//-----------------------------------------

var optionsCoorFecha = {
    chart: {
        width: '100%',
        type: 'bar',
        labels: [],
        locales: locales,
        defaultLocale: "es",
    },
    plotOptions: {
        bar: {
            distributed: true
        }
    },
    grid: grid,
    series: [{
        name: nameSeries,
        data: fechasCoordinacionY
    }],
    xaxis: {
        categories: fechasCoordinacionX
    }
}

var chart = new ApexCharts(document.querySelector('#grafico_coord_fecha'), optionsCoorFecha)
chart.render()

//-----------------------------------------
// GRAFICO ASISTENCIA POR AMBITO
//-----------------------------------------

var optionsAsisAmbito = {
    chart: {
        width: '100%',
        type: 'bar',
        labels: [],
        locales: locales,
        defaultLocale: "es",
    },
    plotOptions: {
        bar: {
            distributed: true,
            horizontal: true
        }
    },
    dataLabels: {
        enabled: false
    },
    grid: grid,
    series: [{
        name: nameSeries,
        data: ambitoAsistenciaY,
    }],
    xaxis: {
        categories: ambitoAsistenciaX
    }
}

var chart = new ApexCharts(document.querySelector("#grafico_asis_ambito"), optionsAsisAmbito);
chart.render();


//-----------------------------------------
// GRAFICO COORDINACION POR AMBITO
//-----------------------------------------

var optionsAsisAmbito = {
    chart: {
        width: '100%',
        type: 'bar',
        labels: [],
        locales: locales,
        defaultLocale: "es",
    },
    plotOptions: {
        bar: {
            distributed: true,
            horizontal: true
        }
    },
    dataLabels: {
        enabled: false
    },
    grid: grid,
    series: [{
        name: nameSeries,
        data: ambitoCoordinacionY,
    }],
    xaxis: {
        categories: ambitoCoordinacionX
    }
}

var chart = new ApexCharts(document.querySelector("#grafico_coord_ambito"), optionsAsisAmbito);
chart.render();
