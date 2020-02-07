@extends("theme.$theme.layout")
@section('titulo')
Recetas
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
@include('includes.mensaje')
@endsection
@section('contenido')

<div class="row">
    <div class="col-lg-12">
        @section('tituloContenido')
        <h1>Facturar</h1>
        @endsection
        <div class="row">
            <div class="col-lg-9"></div>
            <div class="col-lg-3">
                <form class="form-horizontal" method="POST" action="{{route('factura')}}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Buscar</label>
                        <div class="input-group col-lg-10">
                            <input type="text" class="form-control" name="buscarpor" value="{{$request->buscarpor}}"
                                id="buscarpor" placeholder="O/C o Folio" autocomplete="off" />
                            <button type="submit" class="btn btn-info">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @foreach ($sics as $sic)
        <div class="card border">
            <!-- /.card-header -->
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-lg-3">
                        <label>O/C:</label> {{$sic->SicPOnro}}
                    </div>
                    <div class="col-lg-8">
                        <label>Folio:</label> {{$sic->SicFol}}
                    </div>
                    <div class="col-lg-1">
                        <span class="tag-lightslategray tooltipsC float-right" title="SIC preparada">{{trim($sic->etapa->Proc_Nombr)}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mx-auto">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover border">
                        <thead class="border-bottom-3 border-info">
                            <tr>
                                <th>Estado</th>
                                <th>Línea</th>
                                <th>Principio Activo</th>
                                <th>Unidades solicitadas</th>
                                <th>Preparadas</th>
                                <th>Costo</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sic->lineasSIC as $linea)
                            <tr>
                                @if ($linea->recetas->sum('Rec_unidades') == intval($linea->SicArtCan))
                                <td>
                                    <span class="tag-success tooltipsC" title="SIC preparada">Preparada</span>
                                </td>
                                @else
                                @if ($linea->recetas->sum('Rec_unidades') > 0 && $linea->recetas->sum('Rec_unidades') <
                                    round($linea->SicArtCan, 2))
                                    <td>
                                        <span class="tag-warning tooltipsC" title="SIC sin preparar">Incompleta</span>
                                    </td>
                                    @else
                                    <td>
                                        <span class="tag-danger tooltipsC" title="SIC sin preparar">Sin preparar</span>
                                    </td>
                                    @endif
                                    @endif
                                    <td>{{$linea->SicLin}}</td>
                                    <td>{{$linea->articulo->Art_nom_ex}}</td>
                                    <td>{{round($linea->SicArtCan, 2)}}</td>
                                    <td>{{$linea->recetas->sum('Rec_unidades')}}</td>
                                    <td>{{number_format(strval($linea->Sicartval),0,",",".")}}</td>
                                    <td>{{number_format(strval($linea->Sicartval*$linea->SicArtCan),0,",",".")}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            @if ($sic->Proc_id == 'E')
            <div class="card-footer">
                <a type="submit" class="btn btn-info float-right"
                    href="{{route('facturar', ['SicFol'=> $sic->SicFol])}}">Facturar</a>
            </div>
            @endif
            @if ($sic->Proc_id == 'D')
            <div class="card-footer">
                <a type="submit" class="btn btn-info float-right"
                    href="{{route('gdespacho', ['SicFol'=> $sic->SicFol])}}">Guia de despacho</a>
            </div>
            @endif

            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @endforeach
    </div>
</div>
@endsection