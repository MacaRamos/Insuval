$(document).ready(function () {
    Insuval.validacionGeneral('form-general');
    $('#Men_icono').on('blur', function(){
        $('#mostrar-icono').removeClass().addClass($(this).val() + ' pt-2');
    });
});