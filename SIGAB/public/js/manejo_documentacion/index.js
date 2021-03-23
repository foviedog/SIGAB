function cargarSubCategoria(cat_id, cat_nom){
    $(".activo-cat").addClass("inactivo-cat").removeClass("activo-cat");
    $("#cat"+cat_id).addClass("activo-cat").removeClass("inactivo-cat");
    $("#cat-titlulo").html(cat_nom);

    limpiarDocumentos();

    $.ajax({
        url: "/categorias/"+cat_id+"/subcategorias",
        type: "GET",
        success: function(subcategorias) {
            if (subcategorias) {
                $("#subcategorias").html("");
                subcategorias.forEach(sub => {
                    let subcategoria = $("<div/>");
                    let icono = $("<div/>");
                    let texto = $("<span/>");
                    subcategoria.addClass("subcategoria-contenedor");
                    subcategoria.addClass("d-flex");
                    subcategoria.addClass("align-items-center");
                    subcategoria.addClass("inactivo-sub");
                    subcategoria.attr("id", "sub"+sub.id);
                    subcategoria.attr("onclick", "cargarDocumentos("+sub.id+",'"+sub.nombre+"')");
                    icono.addClass("icono");
                    icono.html("<i class='fas fa-folder fa-2x ml-1' id='icono-sub"+sub.id+"'></i>");
                    texto.addClass("texto");

                    if(sub.nombre.length > 45) texto.html(sub.nombre.substr(0, 45) + "...");
                    else texto.html(sub.nombre);
                    
                    subcategoria.append(icono);
                    subcategoria.append(texto);

                    $("#subcategorias").append(subcategoria);
                });
            }
        }
    });
}

function limpiarDocumentos(){
    $("#documentos-titulo").html("<h4><i class='fas fa-folder texto-azul-una fa-lg mr-3'></i>Seleccione una carpeta</h4>");
    $("#documentos").html("");
}

function cargarDocumentos(sub_id, sub_nom){
    $(".activo-sub").addClass("inactivo-sub").removeClass("activo-sub");
    $("#sub"+sub_id).addClass("activo-sub").removeClass("inactivo-sub");
    $(".fa-folder-open").addClass("fa-folder").removeClass("fa-folder-open");
    $("#icono-sub"+sub_id).addClass("fa-folder-open").removeClass("fa-folder");

    $("#documentos-titulo").html("<h4><i class='fas fa-folder-open texto-azul-una fa-lg mr-3'></i>"+sub_nom+"</h4>");
    $("#documentos").html("");
}

limpiarDocumentos();
cargarSubCategoria(1, nom);
