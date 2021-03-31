
//-----------------------------------------
// GRAFICOS
//-----------------------------------------

$(function () {
    $("#chartContainer").CanvasJSChart({ //Pass chart options
        data: [
            {
                type: "splineArea", //change it to column, spline, line, pie, etc
                dataPoints: [
                    { x: 10, y: 10 },
                    { x: 20, y: 14 },
                    { x: 30, y: 18 },
                    { x: 40, y: 22 },
                    { x: 50, y: 18 },
                    { x: 60, y: 28 }
                ]
            }
        ]
    });

});
