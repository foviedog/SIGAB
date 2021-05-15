$("input[type='file']").on("change", function () {
    if(this.files[0].size > 30000000) {
        toastr.error("Los archivos no deben pesar más de 30MB");
        $(this).val('');
    } else if(!extencionAceptada(this.files[0].name)){
        toastr.error("El formato del archivo no es aceptado");
        $(this).val('');
    }
});

function extencionAceptada(extension) {
    extension = extension.toLowerCase();
    if(extension.includes("jpg") || extension.includes("png") || extension.includes("svg") || extension.includes("jpeg"))
        return true
    return false
}