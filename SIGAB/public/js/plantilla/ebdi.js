let flag = true;
$('[data-toggle="tooltip"]').tooltip();

$('[data-toggle="tooltip"]').tooltip();
/*$("#letras-SIGAB").html("SIGAB");

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $("#img-ebdi").click(function () {
        if (flag) {
            flag = false;
            $("#letras-ebdi").html("");
            let ebdi = new Typed('#letras-SIGAB', {
                strings: ['Escuela de Bibliotecología, Documentación e Información.'],
                typeSpeed: 16,
                cursorChar: '_',
                loop: false,
                onComplete: function (self) { self.destroy() },{{  }}
                onDestroy: function (self) {
                    $("#letras-ebdi").html('Escuela de Bibliotecología, Documentación e Información.');
                    flag = true;
                }
            });
        } else {
            $("#letras-ebdi").html("EBDI");
        };
    });
});*/

let colapsado = localStorage.getItem('colapsado');

if (!colapsado) {
    $("#sidebar").css({ transition: 'all 0s' });
    $("#content").css({ transition: 'all 0s' });
    $("#sidebar").toggleClass("active");
}

/*$(document).ready(function() {
    $("#sidebarCollapse").on("click", function() {
        $("#sidebar").toggleClass("active");
    });
});*/

$(document).ready(function() {
    $("#sidebarCollapse").on("click", function () {
        if (!colapsado) {
            $("#sidebar").css({ transition: 'all 0.3s' });
            $("#content").css({ transition: 'all 0.3s' });
            localStorage.setItem('colapsado', 1);
            $("#sidebar").toggleClass("active");
        } else {
            $("#sidebar").css({ transition: 'all 0.3s' });
            $("#content").css({ transition: 'all 0.3s' });
            localStorage.removeItem("colapsado");
            $("#sidebar").toggleClass("active");
        }
    });
});
