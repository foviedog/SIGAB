$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });

cargarNotificaciones();

Echo.private('App.User.'+ user_id)
    .notification((notification) => {
        $.ajax({
            url:
            rutas['perfil.cant.notifications'],
            dataType: "json",
            method: "GET",
            success: function(notificaciones) {
                cargarNotificaciones();
                notificationMessage(notification);
            }
        });
});

function cargarNotificaciones(){
    $.ajax({
        url:
            rutas['perfil.cant.notifications'],
        dataType: "json",
        method: "GET",
        success: function(notificaciones) {
            if(notificaciones.length == 0){
                $("#numero-notificaciones").html("0");
                div = $("<div>").addClass("dropdown-item ver-mas-notificaciones")
                        .html("<a href='/perfil/notificaciones'>Ver notificaciones</a>");
                $("#espacio-notificaciones").append(div);
            } else {
                $("#espacio-notificaciones").html("");
                $("#numero-notificaciones").html(notificaciones.length);
                if(notificaciones.length > 5){
                    for(let i = 0; i < 5; i++){
                        if(notificaciones[i].data.mensaje.length > 60)
                            mensaje = notificaciones[i].data.mensaje.substring(0, 60) + "...";
                        else
                            mensaje = notificaciones[i].data.mensaje;
                        div = $("<div>")
                            .addClass("dropdown-item")
                            .html(""+mensaje);
                        $("#espacio-notificaciones").append(div);
                    }
                    cant = notificaciones.length - 5;
                    div = $("<div>").addClass("dropdown-item ver-mas-notificaciones")
                                    .html("<a href='/perfil/notificaciones'>Ver "+cant+" notificaciones más...</a>");
                    $("#espacio-notificaciones").append(div);
                } else {
                    for(let i = 0; i < notificaciones.length ; i++){
                        mensaje = notificaciones[i].data.mensaje.substring(0, 60);
                        div = $("<div>")
                            .addClass("dropdown-item")
                            .html(""+mensaje+"...");
                        $("#espacio-notificaciones").append(div);
                    }
                    div = $("<div>").addClass("dropdown-item ver-mas-notificaciones").html("<a href='/perfil/notificaciones'>Ver todas las notificaciones...</a>");
                    $("#espacio-notificaciones").append(div);
                }
            }
        }
    });
}

//toastr.info("Iván Esteban Chinchilla Córdoba ha enviando una actividad para autorización.", "Nueva notificación");

toastr.options = {
    "debug": false,
    "positionClass": "toast-bottom-right",
    "onclick": null,
    "fadeIn": 300,
    "fadeOut": 1000,
    "timeOut": 10000,
    "extendedTimeOut": 2500,
    beforeOpen: notificationSound
}

function notificationMessage(notification){
    toastr.info(notification.mensaje, "Nueva notificación");
    notificationSound(function(){
        document.getElementById('notification-sound').play();
        document.getElementById('notification-sound').muted = false;
    })
}
function notificationSound(_callback){
    _callback();
}