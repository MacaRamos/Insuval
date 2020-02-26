@extends("theme.$theme.layout")
@section('titulo')
Recetas
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
@endsection

@section('contenido')
<div class="row">
  <div class="col-lg-12">
    <div class="card mt-2">
      <div class="card-header border-bottom-3 border-info">
        <h3 class="card-title text-info font-weight-bold mt-1">Recetas</h3>
        <div class="card-tools pull-right">
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
              @if ($tipo == 'alta' || $tipo == 'calidad' || $tipo == 'producir')
              <th style="width: 100px;"></th>
              @endif
              <th style="width: 120px;">Estado</th>
              <th style="width: 100px;">N° Receta</th>
              <th style="width: 100px;">Folio</th>
              <th style="width: 120px;">O/C</th>
              <th style="width: 150px;">F. Farmacéutica</th>
              <th style="width: 100px;">F. Elab.</th>
              <th>Componentes</th>
              <th style="width: 100px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($recetas as $receta)
            <tr>

              @if ($tipo == 'producir')
              <td class="p-0 text-center">
                <a href="{{route('altaCalidad_receta', ['Rec_codigo' => trim($receta->Rec_codigo), 'Rec_fechaVencimiento' => date('d-m-Y', strtotime($receta->Rec_fechaVencimiento)),'button' => 'producir'])}}"
                  class="btn-accion-tabla tooltipsC p-0" title="Producir">
                  <i class="fas fa-check-double icon-circle bg-orange"></i>
                </a>
              </td>
              @endif
              @if ($tipo == 'alta')
              <td class="p-0 text-center">
                <a href="{{route('altaCalidad_receta', ['Rec_codigo' => trim($receta->Rec_codigo), 'Rec_fechaVencimiento' => date('d-m-Y', strtotime($receta->Rec_fechaVencimiento)),'button' => 'alta'])}}"
                  class="btn-accion-tabla tooltipsC p-0" title="Dar de alta">
                  <i class="fas fa-check-double icon-circle bg-warning"></i>
                </a>
              </td>
              @endif
              @if ($tipo == 'calidad')
              <td class="p-0 text-center">
                <a href="{{route('altaCalidad_receta', ['Rec_codigo' =>  trim($receta->Rec_codigo), 'Rec_fechaVencimiento' => date('d-m-Y', strtotime($receta->Rec_fechaVencimiento)), 'button' => 'calidad'])}}"
                  class="btn-accion-tabla tooltipsC p-0" title="Aprobar preparado">
                  <i class="fas fa-check-double icon-circle bg-success"></i>
                </a>
              </td>
              @endif

              <td>{{$receta->estado->Est_descripcion}}</td>
              <td>{{$receta->Rec_codigo}}</td>
              <td>{{$receta->sic->SicFol}}</td>
              <td>{{$receta->sic->SicPOnro}}</td>
              <td>{{$receta->formaFarmaceutica->Pre_descripcion}}</td>
              <td>{{date('d-m-Y', strtotime($receta->Rec_fechaPreparacion))}}</td>
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
                  class="btn-accion-tabla tooltipsC" title="Ver Reporte">
                  <i class="fas fa-file-prescription icon-circle bg-info"></i>
                </a>
                <a href="{{route('etiquetaReporte', ['Rec_codigo' => trim($receta->Rec_codigo), 'button' => 'imprimir'])}}"
                  class="btn-accion-tabla tooltipsC" title="Imprimir etiqueta">
                  <i class="fas fa-print icon-circle bg-info"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
@endsection