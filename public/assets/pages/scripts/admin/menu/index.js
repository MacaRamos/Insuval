$(document).ready(function () {
    $('#nestable').nestable().on('change', function () {
        const data = {
            menu: window.JSON.stringify($('#nestable').nestable('serialize')),
            _token: $('input[name=_token]').val()
        };
        $.ajax({
            url: 'http://localhost:8000/admin/menu/guardar-orden',
            type: 'POST',
            dataType: 'JSON',
            data: data,
            success: function (respuesta) {
                console.log(respuesta)            
            },
            error: function(respuesta)
            {
                console.log(respuesta)
            }
        });
    });
    $('#nestable').nestable('expandAll');
}); 