document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

// ===============================================================================================
//Función encargada de hacer el llamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    ocultarElementos();
    eventos();
}

//Función que oculta elementos específicos de la pantalla
function ocultarElementos() {
    $("#wrap-url-video").hide();
    $("#agregar-evidencia-card").hide();
}

// =================================================================
//Función encargada de hacer llamar los metodos de eventos
// =================================================================
function eventos() {
    evtAgregarEvid();
    evtCancelarAgregarEvid();
    detalleDocumento();
    evtSubmitAgregarEvid();
    evtCancelarReproduccion();
}
// ******************************************
//   Declaración de eventos
// ******************************************
function mostrarUrlVideo(checkbox) {
    if (checkbox.checked == true) {
        $("#wrap-url-video").show();
        $("#file-upload").hide();
        removeUpload();
        $("#url-video").val("");
        $("#check_video").val("off");
    } else {
        $("#wrap-url-video").hide();
        $("#file-upload").show();
        $("#check_video").val("on");
    }
}

function evtAgregarEvid() {
    $("#btn-agregar-evid").on("click", function() {
        $("#agregar-evidencia-card").show();
        $("#btn-agregar-evid").hide();
    });
}

function evtSubmitAgregarEvid() {
    $("#agregar-submit").on("click", function(e) {
        var evidenciaFile = $("#evidencia-file").get(0).files.length === 0;
        var urlVideo = $("#url-video").val() === "";
        var checkVideo = $("#es-video").prop("checked");
        if ((evidenciaFile && !checkVideo) || (urlVideo && checkVideo)) {
            let idMensaje = "mensaje-alerta";
            let textoMensaje =
                '<i class="fas fa-exclamation-triangle"></i> &nbsp; No ha agregado ninguna evidencia ';
            mostrarMensajePersonalizado(idMensaje, textoMensaje);
        } else {
            console.log($("#form-evidencia")[0].checkValidity());
            if ($("#form-evidencia")[0].checkValidity()) {
                $("#btn-cancelar-agregar").trigger("click");
                $(".loader-text").html("Agregando evidencia");
                $("#loader-full").show();
            } else {
                $("#hidden-submit").trigger("click");
            }
        }
    });
}

function evtCancelarAgregarEvid() {
    $("#btn-cancelar-agregar").on("click", function() {
        $("#agregar-evidencia-card").hide();
        $("#btn-agregar-evid").show();
        if ($("#es-video").prop("checked") == true)
            $("#es-video").trigger("click");
    });
}
function evtCancelarReproduccion() {
    $("#cerrar-modal-detalle").on("click", function() {
        $("iframe").attr("src", $("iframe").attr("src"));
    });
}

function detalleDocumento() {
    $("#detalle-documento").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget); // Button que accionó el modal
        var url = button.data("repositorio"); // Extraer la información del elemento data-repositorio
        var tipo = button.data("tipo"); // Extraer la información del elemento data-tipo
        $("#preview").html("");

        if (tipo === "video") {
            iframeYoutube(url);
        } else if (tipo === "imagen") {
            imagenModal(url);
        } else if (tipo === "pdf") {
            embedPDF(url);
        } else {
            mensajeNoDisponible();
        }
    });
}

// ******************************************
//   Declaración de funciones
// ******************************************

function obtenerVideoId(videoUrl) {
    var pos = videoUrl.search("v=");
    var videoID = videoUrl.slice(pos + 2, videoUrl.length);
    pos = videoID.search("&");
    videoID = videoID.slice(0, pos);
    return videoID;
}

function imagenModal(url) {
    img = $("<img />", {
        id: "documentoIMG_PV",
        src: storageURL + "/" + url,
        width: "60%",
        height: "60%"
    }).appendTo($("#preview"));
}
function embedPDF(url) {
    url = storageURL + "/" + url;
    var obj = document.createElement("object");
    obj.setAttribute("width", "100%");
    obj.setAttribute("height", "580px");
    var param = document.createElement("param");
    param.setAttribute("name", "Src");
    param.setAttribute("value", url);
    obj.appendChild(param);
    var embed = document.createElement("embed");
    embed.setAttribute("width", "100%");
    embed.setAttribute("height", "100%");
    embed.setAttribute("src", url);
    embed.setAttribute("href", url);
    obj.appendChild(embed);
    $("#preview").append(obj);
}

function iframeYoutube(url) {
    var videoID = obtenerVideoId(url);
    iframe = $("<iframe>", {
        src: "https://www.youtube.com/embed/" + videoID,
        id: "youtube_PV",
        frameborder: 0,
        title: "YouTube video PLAYER",
        frameborder: "0",
        allow:
            "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture",
        allowFullscreen: true,
        width: "100%",
        height: "500px"
    }).appendTo("#preview");
}
