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

    $(".datetimepicker").on("apply.daterangepicker", function(ev, picker) {
        $(this).val(
            picker.startDate.format("DD/MM/YYYY") +
                " - " +
                picker.endDate.format("DD/MM/YYYY")
        );
    });

    $(".datetimepicker").on("cancel.daterangepicker", function(ev, picker) {
        $(this).val("");
    });

    $("#password_campo a").on('click', function(event) {
        event.preventDefault();
        if($('#password_campo input').attr("type") == "text"){
            $('#password_campo input').attr('type', 'password');
            $('#password_campo i').addClass( "fa-eye-slash" );
            $('#password_campo i').removeClass( "fa-eye" );
        }else if($('#password_campo input').attr("type") == "password"){
            $('#password_campo input').attr('type', 'text');
            $('#password_campo i').removeClass( "fa-eye-slash" );
            $('#password_campo i').addClass( "fa-eye" );
        }
    });
    
});

function eliminarFechas(input) {
    $("#rango_fechas").val("");
}


