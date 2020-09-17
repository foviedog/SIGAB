$('#cancelar-edi').hide();

$('#editar-estudiante').on('click', function () {
    $("input").removeAttr('disabled');
    $("select").removeAttr('disabled');
    $("textarea").removeAttr('disabled');
    $('#editar-estudiante').hide();
    $('#cancelar-edi').show();
});


$('#cancelar-edi').on('click', function () {
    $("input").attr('disabled',"disabled");
    $("select").attr('disabled',"disabled");
    $("textarea").attr('disabled', "disabled");
    $('#editar-estudiante').show();
    $('#cancelar-edi').hide();
});



