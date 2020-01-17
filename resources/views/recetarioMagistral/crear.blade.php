@extends("theme.$theme.layout")
@section('titulo')
Receta
@endsection

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/daterangepicker/daterangepicker.css")}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('styles')
<style>
    .checkbox-menu li label {
        display: block;
        padding: 3px 10px;
        clear: both;
        font-weight: normal;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
        margin: 0;
        transition: background-color .4s ease;
    }

    .checkbox-menu li input {
        margin: 0px 5px;
        top: 2px;
        position: relative;
    }

    .checkbox-menu li.active label {
        background-color: #cbcbff;
        /* font-weight:bold; */
    }

    .checkbox-menu li label:hover,
    .checkbox-menu li label:focus {
        background-color: #f5f5f5;
    }

    .checkbox-menu li.active label:hover,
    .checkbox-menu li.active label:focus {
        background-color: #b8b8ff;
    }
</style>
@endsection

@section("scripts")

<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("assets/$theme/plugins/daterangepicker/daterangepicker.js")}}"></script>

<script src="{{asset("assets/pages/scripts/admin/crear.js")}}" type="text/javascript"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/js/mdb.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var vencimientos = @json($vencimientos);
        var start = moment().subtract(1, 'days');
        var end = moment();

    function mostrarFecha(start, end) {
        $('#Rec_fechaPreparacion').val(start.format('DD/MM/YYYY'));
        $('#Rec_fechaVencimiento').val(end.format('DD/MM/YYYY'));
    }

    var fechas = {};
 
    $.each(vencimientos,function(key, vencimiento){
        if(vencimiento.Ven_tipo === 'Días '){
            fechas[vencimiento.Ven_cantidad+' '+vencimiento.Ven_tipo] = [moment(), moment().add(vencimiento.Ven_cantidad, 'days')];
        }
        if(vencimiento.Ven_tipo === 'Meses'){
            fechas[vencimiento.Ven_cantidad+' '+vencimiento.Ven_tipo] = [moment(), moment().add(vencimiento.Ven_cantidad, 'month')];
        }
        if(vencimiento.Ven_tipo === 'años'){
            fechas[vencimiento.Ven_cantidad+' '+vencimiento.Ven_tipo] = [moment(), moment().add(vencimiento.Ven_cantidad, 'year')];
        }
    });

   
    $('#validez-btn').daterangepicker(
      {
        ranges   : fechas,
        startDate: start,
        endDate  : end,
        locale: {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Manual",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
      },
      mostrarFecha
    );
    mostrarFecha(start, end);
});
</script>
<script>
    $(function() {
    $("#PacNom").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarPaciente')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(Paciente){
                        return  {
                                label: Paciente.PacNom,
                                id: Paciente.PacID
                            };
                    }); 
                    response(resp);
                }
            });
        },
        select: function (event, ui) {
            $("#PacNom").val(ui.item.label); // display the selected text
            $("#PacID").val(ui.item.id); // save selected id to hidden input
        },
        minLength: 1
    });

    $("#Mb_Razon_a").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarCliente')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(Cliente){
                        return {
                                label: Cliente.Mb_Razon_a,
                                id: Cliente.Mb_Cod_aux
                            };
                    }); 
                    response(resp);
                }
            });
        },
        select: function (event, ui) {
            $("#Mb_Razon_a").val(ui.item.label); // display the selected text
            $("#Mb_Cod_aux").val(ui.item.id); // save selected id to hidden input
        },
        minLength: 1
    });

    $("#NomPre").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarPrescriptor')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(Prescriptor){
                        return {
                                label: Prescriptor.NomPre,
                                id: Prescriptor.IdPre
                            };
                    }); 
                    response(resp);
                }
            });
        },
        select: function (event, ui) {
            $("#NomPre").val(ui.item.label); // display the selected text
            $("#IdPre").val(ui.item.id); // save selected id to hidden input
        },
        minLength: 1
    });

    $("#Env_descripcion").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarEnvase')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(Envase){
                        return {
                                label: Envase.Env_descripcion,
                                id: Envase.Env_codigo
                            };
                    }); 
                    response(resp);
                }
            });
        },
        select: function (event, ui) {
            $("#Env_descripcion").val(ui.item.label); // display the selected text
            $("#Env_codigo").val(ui.item.id); // save selected id to hidden input
        },
        minLength: 1
    });
    $("#Pre_descripcion").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarFormaFarmaceutica')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(FormaFarmaceutica){
                        return {
                                label: FormaFarmaceutica.Pre_descripcion,
                                id: FormaFarmaceutica.Pre_codigo
                            };
                    }); 
                    response(resp);
                }
            });
        },
        select: function (event, ui) {
            $("#Pre_descripcion").val(ui.item.label); // display the selected text
            $("#Pre_codigo").val(ui.item.id); // save selected id to hidden input
        },
        minLength: 1
    });
    $("#NombrePrincipio").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarPrincipioActivo')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(PrincipioActivo){
                        return {
                                label: PrincipioActivo.Art_nom_ex,
                                id: PrincipioActivo.Art_nom_cod
                            };
                    }); 
                    response(resp);
                }
            });
        },
        select: function (event, ui) {
            $("#NombrePrincipio").val(ui.item.label); // display the selected text
            $("#PrincipioActivo").val(ui.item.id); // save selected id to hidden input
        },
        minLength: 1
    });
    
    
    $("#custom-select").on("click", function() {
		$("#custom-select-option-box").toggle();
	});
	function toggleFillColor(obj) {
		$("#custom-select-option-box").show();
		if ($(obj).prop('checked') == true) {
			$(obj).parent().css("background", '#c6e7ed');
		} else {
			$(obj).parent().css("background", '#FFF');
		}
	}
	$(".custom-select-option").on("click", function(e) {
		var checkboxObj = $(this).children("input");
		if ($(e.target).attr("class") != "custom-select-option-checkbox") {
			if ($(checkboxObj).prop('checked') == true) {
				$(checkboxObj).prop('checked', false)
			} else {
				$(checkboxObj).prop("checked", true);
			}
		}
		toggleFillColor(checkboxObj);
	});

	$("body").on("click", function(e) {
        if (e.target.id != "custom-select"
                && $(e.target).attr("class") != "custom-select-option") {
            $("#custom-select-option-box").hide();
        }
    });
});
</script>
<script>
    $(".checkbox-menu").on("change", "input[type='checkbox']", function() {
   $(this).closest("li").toggleClass("active", this.checked);
});

$(document).on('click', '.allow-focus', function (e) {
  e.stopPropagation();
});
</script>

<script>
    const $tableID = $('#table');
    const $BTN = $('#export-btn');
    const $EXPORT = $('#export');

    const newTr = `
<tr data-item="1" class="hide">
    <td class="pt-3-half" contenteditable="true"></td>
    <td class="pt-3-half componente" contenteditable="true"></td>
    <td class="pt-3-half" contenteditable="true"></td>
    <td class="pt-3-half" contenteditable="true"></td>
    <td class="pt-3-half" contenteditable="true"></td>
    <td class="pt-3-half" contenteditable="true"></td>
        <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Remove</button></span>
    </td>
</tr>`;
 
$('.table-add').on('click', 'i', () => {    
    var lastTr = $(newTr);
    lastTr.attr('data-item', $('tbody').children('tr').last().data('item')+1);
    lastTr.children('td').first().html(lastTr.data('item'));
    $('tbody').append(lastTr);
    
    autocompletarComponente();
});

$tableID.on('click', '.table-remove', function () {
    $(this).parents('tr').detach();
    $('tbody').children('tr').each(function(index, value)
    {
        $(value).attr('data-item', index+1);
        $(value).children('td').first().html(index+1);
    });
});

$tableID.on('click', '.table-up', function () {
    const $row = $(this).parents('tr');
    if ($row.index() === 1) {
        return;
    }
    $row.prev().before($row.get(0));
});

$tableID.on('click', '.table-down', function () {
    const $row = $(this).parents('tr');
    $row.next().after($row.get(0));
});

// A few jQuery helpers for exporting only
jQuery.fn.pop = [].pop;
jQuery.fn.shift = [].shift;

$BTN.on('click', () => {
    const $rows = $tableID.find('tr:not(:hidden)');
    const headers = [];
    const data = [];

    // Get the headers (add special header logic here)
    $($rows.shift()).find('th:not(:empty)').each(function () {
        headers.push($(this).text().toLowerCase());
    });

    // Turn all existing rows into a loopable array
    $rows.each(function () {
        const $td = $(this).find('td');
        const h = {};

        // Use the headers from earlier to name our hash keys
        headers.forEach((header, i) => {

        h[header] = $td.eq(i).text();
        });

        data.push(h);
    });

    // Output the result
    $EXPORT.text(JSON.stringify(data));
});
</script>
<script>
    function autocompletarComponente(){
    $(".componente").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarPrincipioActivo')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(PrincipioActivo){
                        return PrincipioActivo.Art_nom_ex;
                    }); 
                    response(resp);
                }
            });
        },
        minLength: 1
    });
}
autocompletarComponente();
</script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.error-form')
        @include('includes.mensaje')
        <form action="{{route('guardar_receta')}}" id="form-general" class="form-horizontal" method="POST"
            autocomplete="off">
            @csrf
            <div class="card mt-2">
                <div class="card-header card-header border-bottom-3 border-info">
                    <h3 class="card-title text-info font-weight-bold mt-1">Crear Receta</h3>
                    <div class="card-tools pull-right">
                        <a href="{{route('sic')}}" class="btn btn-block btn-info btn-sm">
                            <i class="fas fa-reply"></i> Volver a Selección de SIC
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @include('recetarioMagistral.form')
                </div>
            </div>
            <div class="row">
                <!-- DETALLE RECETA -->
                <div class="col-lg-12">
                    <div class="card mt-2">
                        <div class="card-header card-header border-bottom-3 border-info">
                            <h3 class="card-title text-info font-weight-bold mt-1">Formulación</h3>
                        </div>
                        <div class="card-body">
                            @include('recetarioMagistral.form-formulacion')
                        </div>
                    </div>
                </div>
                <!-- /DETALLE RECETA -->
            </div>
            <div class="row">
                <!-- DETALLE ADICIONAL -->
                <div class="col-lg-12">
                    <div class="card border-top border-light mt-2">
                        <div class="card-header card-header border-bottom-3 border-info">
                            <h3 class="card-title text-info font-weight-bold mt-1">Detalles Adicionales</h3>
                        </div>
                        <div class="card-body">
                            @include('recetarioMagistral.form-detalleAdicional')
                        </div>
                    </div>
                </div>
                <!-- /DETALLE ADICIONAL -->
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        @include('includes.boton-form-crear')
                    </div>
                </div>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</div>
@endsection