$(function() {
    $(".datetimepicker").daterangepicker({
        showDropdowns: true,
        showWeekNumbers: true,
        linkedCalendars: false,
        opens: "right",
        locale: {
            format: "DD/MM/YYYY"
        }
    });
});
