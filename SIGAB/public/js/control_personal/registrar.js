
    document.addEventListener("DOMContentLoaded", cargaInicial);//Se agrega el evento carga inicial al momento de cargar el documento

    var i = 0; // Variable global que mantiene la cuenta de idiomas que se han agregado
    var coleccionIdiomas = []; // Arreglo global de idiomas

    // ===============================================================================================
    //Función encargada de hacer elllamado  de todos los métodos utilizados en el registro.
    // ===============================================================================================
    function cargaInicial(event) {
        ocultarAlertas();
        obtenerIdiomas();
        eventosRegistrar();

    }

    // =================================================================
    // Función que se encarga de ocultar elementos al cargar la página
    // =================================================================
    function ocultarAlertas(){
        $("#alert-idiomas").hide();
    }

    // ===============================================================================
    // Función que se encarga de obtener todos los values digitados en los input
    // ===============================================================================
    function obtenerIdiomas() {
        idiomas = []; // Inicializa el array de idiomas en vacío.
        let inputs = $(".idioma");//Obtiene un array de JQuerry con todos los input que contien la clase idiomas

        $.each(inputs, function(key, input) { // Por cada valor contenido en el array de JQuerry se realiza una función
            idiomas.push(input.value);//Se inserta en el array de "idiomas" el valor de los inputs de idiomas.
        });

        return idiomas; // Retorna el array con todos los idiomas que se hayan digitado en los input con clase "idioma".
    }

    // =================================================================
    // Función que carga todos los eventos de la página
    // =================================================================
    function eventosRegistrar() {
        evtParticipaciones();
        evtAgregarIdiomas();
        evtEliminarIdiomas();
        evtSubmitForm();
    }

    // =================================================================
    // Evento del botón que hace aparecer la ventana de participaciones
    // =================================================================
    function evtParticipaciones() {

        $("#participaciones-ref").on("click", function (e) { // Evento activado por click
            e.preventDefault();// Debido a que el botón es una etiqueta anchor se le previene el default para validar los campos
            let $personalForm = $("#personal-form"); // Variable que contiene el form de información general del personal

            if (!$personalForm[0].checkValidity()) { // Valida el form antes de que se proceda a la siguiente página para evitar que se envíen datos incorrectos
                $("#registrar-btn").trigger("click"); // Fuerza el envío de datos en el form para que realice la validación automática de los campos
            } else { // En caso de que se hayan completado los campos de manera correcta procede a mostrar la información de participaciones
                $("#general").removeClass("active");// Desacitva la vista de información general
                $("#info-general").removeClass('active'); // Desactiva la clase para el botón de volver a información general en la vista de participaciones.
                $("#infoParticipaciones").tab("show"); // Muestra la vista de participaciones.
            }
        });
    }

    // =================================================================
    // Evento del botón que agrega lenguajes de manera dinámica
    // =================================================================
    function evtAgregarIdiomas() {
        $("#agregar-btn").on("click", function () { //El evento se activa con un click en el botón de agregar idioma
            coleccionIdiomas = obtenerIdiomas(); // Se llena el arreglo global de idiomas
            if (coleccionIdiomas.includes("")) {// Se verifica si en dicho arreglo existe algún valor vacío
                // Hace que aparezca MOMENTANEMENTE el mensaje de error en caso de que hayan campos vacíos.
                $("#alert-idiomas").fadeTo(2000, 500).slideUp(500, function () {
                        $("#alert-idiomas").slideUp(500);
                    });
            } else {//En caso de que no hayan campos vacíos:
                $("#lista-idiomas").append(//Se agrega una fila a la tabla que contiene los inpit de idiomas, y dicho inputo contiene un id único que corresponde al orden en el que fue agregado
                    '<tr id="row' + i + '" class="idiomaRow"><td><input type="text" name="name[]" placeholder="Nombre de idioma" class="form-control idioma" required/></td><td><button type="button" name="eliminar-idioma" id="' +
                    i +
                    '" class="btn btn-gris eliminar-idioma-btn"><i class="fas fa-minus-circle"></i></button></td></tr>'
                );// También se agrega un botón de eliminar que utiliza el id del input para accionar el evento de eliminar el input de la tabla.
                i++;// Incrementa el contador global del arreglo de idiomas.
            }
        });
    }

    // =================================================================
    // Evento del botón que agrega lenguajes de manera dinámica
    // =================================================================
    function evtEliminarIdiomas() {
        $(document).on("click", ".eliminar-idioma-btn", function () { // Se activa el evento al momento que se le da click a elimianr un idioma
            var boton_id = $(this).attr("id"); // Obtiene el id del elemento que fue clickeado
            $("#row" + boton_id + "").remove(); // Remuve la fila completa de la tabla en la que se encuentra el botón.
        });
    }

    // =======================================================================
    // Evento al momento de realizar un submit del form de registrar personal
    // =======================================================================
    function evtSubmitForm() {
        $("#personal-form").on("submit", function () { //La función ocurren en el momento en el que se hace submit
            coleccionIdiomas = obtenerIdiomas(); // Se llama al método para llenar el arreglo de idiomas que se ha digitado
            idiomas = JSON.stringify(coleccionIdiomas); // Se transforma el array de JavaScript a JSON para que sea posible enviar el array en el request
            $("#idiomasJSON").val(idiomas); // Se coloca el valor del JSON dentro de un input de tipo "hiden" que se envía en conjunto con el request.
        });
    }


