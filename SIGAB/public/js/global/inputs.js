$(function() {
    $(".datetimepicker").daterangepicker({
        showDropdowns: true,
        showWeekNumbers: true,
        linkedCalendars: false,
        opens: "right",
        locale: {
            format: "DD/MM/YYYY",
            cancelLabel: "Clear"
        },
        autoUpdateInput: false
    });

    $('.datetimepicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('.datetimepicker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});

function eliminarFechas(input) {
    $("#rango_fechas").val("");
}