/*Contador de caracteres de Cedula */
function contarCaracteres(input, cantCar) {
    var len = input.value.length;
    if (len > cantCar) {
        input.value = input.value.substring(0, cantCar);
    } else {
        $('#mostrar_'+input.id).text(cantCar - len);
    }
}
