@extends("theme.$theme.layout")
@section('titulo')
Recetas
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("assets/$theme/plugins/daterangepicker/daterangepicker.js")}}"></script>
@include('includes.mensaje')
<script>
  $('#modalFechas').on('shown.bs.modal', function () {
  $('.myInput').trigger('focus');
})

$('#botonLibroPreparaciones').click(function(){
  //$('#formModel').get(0).setAttribute('action', '{{route('libroPreparaciones')}}');
  $('#formModel').attr('action', '{{route('libroPreparaciones')}}');
});
$('#botonLibroRecetas').click(function(){
  $('#formModel').attr('action', '{{route('libroRecetas')}}');ss
});

$( document ).ready(function() {
    var start = moment();
    var end = moment();

    $('#rangoFecha').daterangepicker(
      {
        startDate: start,
        endDate  : end,
        maxDate: end,
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
      }
    );

});

</script>
@endsection

@section('contenido')
<div class="row">
  <div class="col-lg-12">
    <div class="card mt-2">
      <div class="card-header border-bottom-3 border-info">
        <h3 class="card-title text-info font-weight-bold mt-1">Recetas</h3>
        <div class="card-tools pull-right">
          <button type="button" class="btn btn-default border-info hover-default myInput" id="botonLibroPreparaciones"
            data-toggle="modal" data-target="#modalFechas">
            <img src="{{asset("assets/img/LibroRecetas_64x64.png")}}" width="22" height="22">
            <span>Libro Preparaciones</span>
          </button>
          <button type="button" class="btn btn-default border-info hover-default myInput" id="botonLibroRecetas"
            data-toggle="modal" data-target="#modalFechas">
            <img src="{{asset("assets/img/LibroPreparaciones_64x64.png")}}" width="22" height="22">
            Libro Recetas
          </button>
          <a href="{{route('sic')}}" class="btn btn-info">
            <i class="fas fa-plus-circle"></i> Crear Receta
          </a>
        </div>
      </div>
      <!-- /.card-header -->
      @include('recetarioMagistral.modal')
      <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover" id='tabla-data'>
          <thead>
            <tr>
              <th style="width: 100px;"></th>
              <th>N° Receta</th>
              <th>F. Farmacéutica</th>
              <th>F. Elab.</th>
              <th>O/C</th>
              <th>Estado</th>
              <th>Componentes</th>
              <th style="width: 100px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($recetas as $receta)
            <tr>
              <td>
                @if ($tipo === 'alta')
                <a href="{{route('altaCalidad_receta', ['Rec_codigo' => trim($receta->Rec_codigo), 'Rec_fechaVencimiento' => date('d-m-Y', strtotime($receta->Rec_fechaVencimiento)),'button' => 'alta'])}}"
                  class="btn-accion-tabla tooltipsC" title="Dar de alta">
                  <i class="fas fa-check-double icon-circle"></i>
                </a>
                @endif
                @if ($tipo === 'calidad')
                <a href="{{route('altaCalidad_receta', ['Rec_codigo' =>  trim($receta->Rec_codigo), 'Rec_fechaVencimiento' => date('d-m-Y', strtotime($receta->Rec_fechaVencimiento)), 'button' => 'calidad'])}}"
                  class="btn-accion-tabla tooltipsC" title="Aprobar preparado">
                  <i class="fas fa-check-double icon-circle"></i>
                </a>
                @endif
              </td>
              <td>{{$receta->Rec_codigo}}</td>
              <td>{{$receta->formaFarmaceutica->Pre_descripcion}}</td>
              <td>{{date('d-m-Y', strtotime($receta->Rec_fechaPreparacion))}}</td>
              <td>{{$receta->sic->SicPOnro}}</td>
              <td>{{$receta->estado->Est_descripcion}}</td>
              <td>
                @foreach ($receta->lineasReceta as $linea)
                {{$linea->articulo->Art_nom_ex}}
                @if(!$loop->last)
                -
                @endif
                @endforeach
              </td>
              <td>
                <a href="{{route('etiquetaReporte', ['Rec_codigo' => trim($receta->Rec_codigo), 'button' => 'reporte'])}}"
                  class="btn-accion-tabla tooltipsC" title="Imprimir etiqueta">
                  <i class="fas fa-file-prescription icon-circle"></i>
                </a>
                <a href="{{route('etiquetaReporte', ['Rec_codigo' => trim($receta->Rec_codigo), 'button' => 'imprimir'])}}"
                  class="btn-accion-tabla tooltipsC" title="Imprimir etiqueta">
                  <i class="fas fa-print icon-circle"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
      {{-- <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
          <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
      </div> --}}
    </div>
  </div>
</div>
</div>
@endsection