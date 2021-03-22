
//Función llamada cada vez que haya un cambio en el input:file destinado a imágnes
function readURL(input) {
    if (input.files && input.files[0]) {//Si se ha seleccionado algún archivo

    var reader = new FileReader();//Crea un nuevo objeto que sirve para leer el contenido de archivos

    reader.onload = function(e) { //Closer de JS para designar una función cuando el evento "load" suceda
        $('.file-upload-wrap').hide();
        $('.file-upload-image').attr('src', e.target.result);//Toma el contenido del archivo subido y coloca la ruta de dicho archivo en la ruta de la file
        colocarImagen(input.files[0].name);//En caso de que el arhivo subido no sea una imagen, se coloca una imagen representativa

        $('.file-upload-content').show();//Muestra la imagen
        $('.file-title').html(input.files[0].name);//Toma el nombre del archivo y lo coloca en el botón de eliminar
        if (obtenerURL(input.files[0].name) == null) {
            alert("El formato del archivo no es aceptado");
            removeUpload();
        }
    };
    reader.readAsDataURL(input.files[0]);//Inicializa el modo de buffer como URL (De esta manera el ".result" devolverá la ruta del archivo)
    } else {
        removeUpload();//Se remueve la previsualización del archivo y se vuelve a colocar el campo para subir elementos
    }
}

    //Evento utilizado para eliminar el documento que se haya subido
    //Elimina el efecto de over sobre el input de "file-upload-wrap"
    //Reposiciona el input para poder volver a subir un archivo y esconde
    //esconde la previsualización del archivo.
function removeUpload() {
        $('.file-upload-wrap').removeClass('file-dropping');
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.file-upload-wrap').show();
    }

    //Agrega la clase "file-dropping" para mostrar un efecto de hover
    $('.file-upload-wrap').bind('dragover', function () {
        $('.file-upload-wrap').addClass('file-dropping');
    });

    //Elimina la clase de file-dropping cuando el documento no está siendo posicionado
    //encima del input de "file-upload-wrap"
    $('.file-upload-wrap').bind('dragleave', function () {
        $('.file-upload-wrap').removeClass('file-dropping');
    });

    //Toma el nombre del archivo que se haya subido y extrae la extensión
    function obtenerExtension(archivo) {
        return archivo.substring(archivo.lastIndexOf('.')+1, archivo.length) || archivo;
    }

    //Posiciona la imagen representativa en el campo "file-upload-image"
    function colocarImagen(fileName) {
        extension = obtenerExtension(fileName);
        url = obtenerURL(extension);
        if (url != "img" && url != null) {
            $('.file-upload-image').attr('src',url );
        }
    }

//Función que retorna una imagen representativa del documento que se haya subido en caso
//de que el documento no sea una imagen.
function obtenerURL(extension) {
    extension = extension.toLowerCase();
    if (extension.includes("pdf")) {
        return iconosURL + "/" + "pdf.png";
    } else if (extension.includes("docx") || extension.includes("odt") || extension.includes("doc") ||  extension.includes("txt"))
        return iconosURL + "/" + "doc.png";
    else if (extension.includes("rar") || extension.includes("zip") || extension.includes("7z") || extension.includes("rar5"))
        return iconosURL + "/" + "comprimido.png";
    else if (extension.includes("xls") || extension.includes("xlsm") || extension.includes("xlsx") || extension.includes("ods"))
        return iconosURL + "/" + "excel.png";
    else if (extension.includes("pps") || extension.includes("ppt") || extension.includes("ppsx") || extension.includes("pptm") || extension.includes("potx") || extension.includes("pptx"))
        return iconosURL + "/" + "powerPoint.png";
    else if(extension.includes("jpg") || extension.includes("png") || extension.includes("svg") || extension.includes("jpeg"))
        return "img";
    else
        return null
}

function validarExtension(){
    $("input[type='submit']").on("click",function(){
        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length)>2){
            alert("You can only upload a maximum of 1 files");
        }
    });
}

