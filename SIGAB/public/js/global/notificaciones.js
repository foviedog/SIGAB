/*$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') } });

cargarNotificaciones();

Echo.private('App.User.'+ user_id)
    .notification((notification) => {
        cargarNotificaciones();
        if(notification.persona_id != persona_id)
            notificationMessage(notification);
});

function cargarNotificaciones(){
    $.ajax({
        url:
            rutas['perfil.cant.notifications'],
        dataType: "json",
        method: "GET",
        success: function(resultado) {
            if(resultado.cantidad == 0){
                $("#numero-notificaciones").html("0");
                div = $("<div>").addClass("dropdown-item ver-mas-notificaciones")
                        .html("<a href='"+rutas['perfil.notifications']+"'>Ver notificaciones</a>");
                $("#espacio-notificaciones").append(div);
            } else {
                $("#espacio-notificaciones").html("");
                $("#numero-notificaciones").html(resultado.cantidad);
                for(let i = 0; i < resultado.notificaciones.length ; i++){
                    mensajeOriginal = resultado.notificaciones[i].data.mensaje;
                    mensaje = resultado.notificaciones[i].data.mensaje.substring(0, 60);
                    url = resultado.notificaciones[i].data.url;
                    if(url === undefined) url = "#";
                    if(mensajeOriginal.length > 60){
                        div = $("<div>")
                        .addClass("dropdown-item")
                        .html("<a href='"+url+"'>"+mensaje+"...</a>");
                    } else {
                        div = $("<div>")
                        .addClass("dropdown-item")
                        .html("<a href='"+url+"'>"+mensaje+"</a>");
                    }
                    $("#espacio-notificaciones").append(div);
                }
                div = $("<div>").addClass("dropdown-item ver-mas-notificaciones")
                        .html("<a href='"+rutas['perfil.notifications']+"'>Ver todas las notificaciones...</a>");
                $("#espacio-notificaciones").append(div);
            }
        }
    });
}

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
    });
}

function notificationSound(_callback){
    _callback();
}*/