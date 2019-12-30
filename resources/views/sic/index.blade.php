@extends("theme.$theme.layout")
@section('titulo')
SIC
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-info mt-2">
            <div class="card-header with-border">
          <h3 class="card-title">Seleccione SIC</h3>
        </div>
        <!-- /.card-header -->
 
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>SicPOnro</th>
                        <th>Fecha</th>
                        <th>Prescriptor</th>
                        <th>Paciente</th>
                        <th>Principio Activo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sics as $sic)
                        @foreach ($lineas as $linea)
                            @if ($sic->SicFol == $linea->SicFol)
                            <tr>
                                <td>{{$sic->SicFol}}</td>
                                <td>{{$sic->SicPOnro}}</td>
                                <td>{{date('d-m-Y', strtotime($sic->SicFecemi))}}</td>
                                <td>{{$sic->Ve_Cod_Cli}}</td>
                                <td>{{$sic->Ve_cod_pac}}</td>
                                <td>{{$linea->Art_cod}}</td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        </div>
      </div>
    </div>
</div>
@endsection
