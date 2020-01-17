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
    @include('includes.mensaje')
    <div class="card mt-2">
      <div class="card-header border-bottom-3 border-info">
        <h3 class="card-title text-info font-weight-bold mt-1">Recetas</h3>
        <div class="card-tools pull-right">
          <a href="{{route('sic')}}" class="btn btn-block btn-info btn-sm ">
            <i class="fas fa-plus-circle"></i> Crear Receta
          </a>
        </div>
      </div>
      <!-- /.card-header -->

      <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover" id='tabla-data'>
          <thead>
            <tr>
              <th style="width: 200px;"></th>
              <th>N° Receta</th>
              <th>F. Farmacéutica</th>
              <th>F. Elab.</th>
              <th>O/C</th>
              <th>Estado</th>
              <th>Componentes</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($recetas as $receta)
            <tr>
              <td>
                  <a href="{{route('altaCalidad_receta', ['Rec_codigo' => trim($receta->Rec_codigo), 'Rec_fechaVencimiento' => date('d-m-Y', strtotime($receta->Rec_fechaVencimiento)),'button' => 'alta'])}}"
                    class="btn-accion-tabla tooltipsC" title="Dar de alta">
                    <i class="fas fa-check-double icon-circle"></i>
                  </a>
                  <a href="{{route('altaCalidad_receta', ['Rec_codigo' =>  trim($receta->Rec_codigo), 'Rec_fechaVencimiento' => date('d-m-Y', strtotime($receta->Rec_fechaVencimiento)), 'button' => 'calidad'])}}"
                    class="btn-accion-tabla tooltipsC" title="Aprobar preparado">
                    <i class="fas fa-check-double icon-circle"></i>
                  </a>
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