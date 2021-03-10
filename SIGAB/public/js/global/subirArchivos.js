
//Función llamada cada vez que haya un cambio en el input:file destinado a imágnes
function readURL(input) {
    if (input.files && input.files[0]) {//Si se ha seleccionado algún archivo

    var reader = new FileReader();//Crea un nuevo objeto que sirve para leer el contenido de archivos

    reader.onload = function(e) { //Closer de JS para designar una función cuando el evento "load" suceda
        $('.image-upload-wrap').hide();

        $('.file-upload-image').attr('src', e.target.result);//Toma el contenido del archivo subido y coloca la ruta de dicho archivo en la ruta de la imagen
        $('.file-upload-content').show();//Muestra la imagen

        $('.image-title').html(input.files[0].name);//Toma el nombre del archivo y lo coloca en el botón de eliminar
    };
    reader.readAsDataURL(input.files[0]);//Inicializa el modo de buffer como URL (De esta manera el ".result" devolverá la ruta del archivo)
    } else {
        removeUpload();
    }
}

    //Evento utilizado para eliminar el documento que se haya subido
    //Elimina el efecto de over sobre el input de "image-upload-wrap"
    //Reposiciona el input para poder volver a subir un archivo y esconde
    //esconde la previsualización de la imagen.
    function removeUpload() {
        $('.image-upload-wrap').addClass('image-dropping');
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }

    //Agrega la clase "image-dropping" para mostrar un efecto de hover
    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });

    //Elimina la clase de image-dropping cuando el documento no está siendo posicionado
    //encima del input de "image-upload-wrap"
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
