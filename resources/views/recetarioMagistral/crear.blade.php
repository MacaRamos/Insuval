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
<script>
    $(function () {
        //Date range as a button
    $('#Rec_fechaVencimiento-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().startOf('day'),
        endDate: moment().startOf('day').add(35, 'day'),
        locale: {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
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
      function (start, end) {
        $('#Rec_fechaVencimiento').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))
      }
    )
})
</script>
<script>
    $(function() {
    $( "#Paciente" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarPaciente')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(Paciente){
                        return Paciente.PacNom;
                    }); 
                    response(resp);
                }
            });
        },
        minLength: 1
    });
    $( "#Prescriptor" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarPrescriptor')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(Prescriptor){
                        return Prescriptor.NomPre;
                    }); 
                    response(resp);
                }
            });
        },
        minLength: 1
    });
    $( "#Envase" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarEnvase')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(Envase){
                        return Envase.Env_descripcion;
                    }); 
                    response(resp);
                }
            });
        },
        minLength: 1
    });
    $( "#forma-farmaceutica" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarFormaFarmaceutica')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(FormaFarmaceutica){
                        return FormaFarmaceutica.Pre_descripcion;
                    }); 
                    response(resp);
                }
            });
        },
        minLength: 1
    });
    $( "#principio-activo" ).autocomplete({
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
    $(".componente" ).autocomplete({
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
        <div class="card border-top border-light mt-2">
            <div class="card-header  border-bottom border-info with-border">
                <h3 class="card-title">Crear Receta</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('sic')}}" class="btn btn-block btn-info btn-sm">
                        <i class="fas fa-reply"></i> Volver a Selección de SIC
                    </a>
                </div>
            </div>
            <form action="{{route('guardar_receta')}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                    @include('recetarioMagistral.form')
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
</div>
{{-- <div class="row">
    <!-- DETALLE RECETA -->
    <div class="col-lg-12">
        <div class="card border-top border-light mt-2">
            <div class="card-header  border-bottom border-info with-border">
                <h3 class="card-title">Formulación</h3>
            </div>
            <form action="{{route('guardar_receta')}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf @method("put")
                <div class="card-body">
                    @include('recetarioMagistral.form-formulacion')
                </div>
            </form>
        </div>
    </div>
    <!-- /DETALLE RECETA -->
</div>
<div class="row">
    <!-- DETALLE ADICIONAL -->
    <div class="col-lg-12">
        <div class="card border-top border-light mt-2">
            <div class="card-header  border-bottom border-info with-border">
                <h3 class="card-title">Detalles Adicionales</h3>
            </div>
            <form action="{{route('guardar_receta')}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf @method("put")
                <div class="card-body">
                    @include('recetarioMagistral.form-detalleAdicional')
                </div>
            </form>
        </div>
    </div>
    <!-- /DETALLE ADICIONAL -->
</div> --}}

@endsection