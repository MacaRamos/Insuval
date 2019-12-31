@extends("theme.$theme.layout")
@section('titulo')
Receta
@endsection

@section('header')
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/daterangepicker/daterangepicker.css")}}">
@endsection

@section("scripts")

<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("assets/$theme/plugins/daterangepicker/daterangepicker.js")}}"></script>

<script src="{{asset("assets/pages/scripts/admin/crear.js")}}" type="text/javascript"></script>
<script>
    $(function () {
        //Date range as a button
    $('#daterange-btn').daterangepicker(
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
        $('#reportrange').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))
      }
    )
})
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
            <form action="{{route('guardar_receta')}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf @method("put")
                <div class="card-body">
                    @include('recetarioMagistral.form')
                </div>
                <div class="card-footer">
                    <div class="col-lg-8 mx-auto">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-8">
                                @include('includes.boton-form-editar')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endsection