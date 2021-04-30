

console.log(graficosInvolucramiento);

// generarGrafico("", 'bar', graficosInvolucramiento, true);



function generarGraficosPorRango() {
    //Se recorre el array de los gráficos según el rango de años que se setea en el blade de "involucramiento_anual"
    for (const anio in graficosInvolucramiento) {
        generarGrafico("grafico_" + anio, 'bar', graficosInvolucramiento[anio], true);

    }
}

generarGraficosPorRango();
