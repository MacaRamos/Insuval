@extends("theme.$theme.layout")
@section('titulo')
SIC
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @section('tituloContenido')
        <h1>Seleccione SIC</h1>
        @endsection
        <div class="card mt-2">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover">
                    <thead class="border-bottom-3 border-info">
                        <tr>
                            <th style="width: 100px;"></th>
                            <th>Folio</th>
                            <th>SicPOnro</th>
                            <th>Fecha</th>
                            <th>Prescriptor</th>
                            <th>Paciente</th>
                            <th>Principio Activo</th>
                            <th style="width: 125px;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sics as $sic)
                        @foreach($sic->lineasSIC as $linea)
                        <tr>
                            @if ($linea->recetas->sum('Rec_unidades') != intval($linea->SicArtCan))
                            <td>
                                <a href="{{route('crear_receta', ['SicFol' => $sic->SicFol, 'SicLin'=> $linea->SicLin])}}"
                                    class="btn-accion-tabla tooltipsC" title="Seleccionar SIC">
                                    <i class="fas fa-check icon-circle bg-info"></i>
                                </a>
                            </td>                               
                            @else
                                <td></td>
                            @endif
                            <td>{{$sic->SicFol}}</td>
                            <td>{{$sic->SicPOnro}}</td>
                            <td>{{date('d-m-Y', strtotime($sic->SicFecemi))}}</td>
                            <td>{{$sic->cliente->Mb_Razon_a}}</td>
                            <td>{{$sic->paciente->PacNom}}</td>
                            <td>{{$linea->articulo->Art_nom_ex}}</td>
                            <td>
                                @if ($linea->recetas->sum('Rec_unidades') == intval($linea->SicArtCan))
                                <span class="tag-success tooltipsC" title="SIC preparada">Preparada</span>
                                @else
                                <span class="tag-warning tooltipsC" title="SIC sin preparar">Sin preparar</span>
                                @endif
                                @if ($sic->Sic_urgent == 'S')
                                <i class="fa fa-exclamation-circle text-danger tooltipsC" title="SIC Urgente"></i>
                                {{-- @else
                                    <i class="fa fa-exclamation-circle"></i> --}}
                                @endif
                            </td>
                        </tr>
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