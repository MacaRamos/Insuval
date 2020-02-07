@extends("theme.$theme.layout")
@section('titulo')
Paciente
@endsection

@section("header")
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>
@include('includes.mensaje')
@endsection

@section('contenido')
<div class="row">
  <div class="col-lg-12">
    @section('tituloContenido')
    <h1>Paciente</h1>
    @endsection
    <div class="row">
      <div class="col-lg-9">
        <div class="card-tools pull-right">
          <a href="{{route('crear_paciente')}}" class="btn btn-default border-info">
            <i class="fas fa-plus-circle pr-2"></i>Nuevo
          </a>
        </div>
      </div>
      <div class="col-lg-3">
        <form class="form-horizontal" method="POST" action="{{route('paciente')}}">
          @csrf
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Buscar</label>
            <div class="input-group col-lg-10">
              <input type="text" class="form-control" name="buscarpor" value="{{$request->buscarpor}}" id="buscarpor"
                placeholder="Buscar" autocomplete="off"/>
              <button type="submit" class="btn btn-info">Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card mt-2">
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover" id='tabla-data'>
          <thead class="border-bottom-3 border-info">
            <tr>
              <th>RUT</th>
              <th>Nombre</th>
              <th style="width: 100px"></th>
            </tr>
          </thead>
          <tbody class="border-bottom">
            @foreach ($pacientes as $paciente)
            <tr>
              <td>{{number_format($paciente->PacRUT, 0, ",", ".")}}-{{$paciente->PacDV}}</td>
              <td>{{$paciente->PacNom}}</td>
              <td style="border: none !important;">
                <a href="{{route('editar_paciente', ['PacID' => rtrim($paciente->PacID)])}}"
                  class="btn-accion-tabla tooltipsC" title="Editar este registro">
                  <i class="fas fa-pencil-alt icon-circle bg-info"></i>
                </a>
                <form action="{{route('eliminar_paciente', ['PacID' => rtrim($paciente->PacID)])}}"
                  class="d-inline form-eliminar" method="POST">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro">
                    <i class="far fa-trash-alt icon-circle bg-danger"></i>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <div class="dataTables_paginate paging_simple_numbers float-right">
          {{$pacientes->links("pagination::bootstrap-4")}}
        </div>
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection