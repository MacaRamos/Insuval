@extends("theme.$theme.layout")
@section('titulo')
Recetas
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
@endsection
@section('contenido')

<div class="row my-5">
    @include('includes.mensaje')
    <!-- SIC y numero O/C -->
    <div class="col-lg-9">
    </div>
    <div class="col-lg-3">
            <form class="form-horizontal">
                <div class="form-group row">
                    <label for="SicPOnro" class="col-lg-2 col-form-label">Buscar</label>
                    <div class="input-group col-lg-10">
                        <input type="text" class="form-control" name="buscarpor" id="buscarpor"
                            placeholder="O/C o Folio" />
                        <button type="submit" class="btn btn-info">Buscar</button>
                    </div>
                </div>
            </form>
    </div>
    <!-- SIC y numero O/C -->
</div>
<div class="row">
    @foreach ($sics as $sic)
    <div class="col-lg-12">
        <div class="card border">
            <!-- /.card-header -->

            <div class="col-lg-6 mx-auto pt-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h6>Folio: {{$sic->SicFol}}</h6>
                    </div>
                    <div class="col-lg-6">
                        <h6>O/C: {{$sic->SicPOnro}}</h6>
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
                                <th>Unidades</th>
                                <th>Costo</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sic->lineasSIC as $linea)
                            <tr>
                                @if ($linea->LineReady == 1)
                                <td><span class="tag-success tooltipsC" title="SIC preparada">Preparada</span></td>
                                @else
                                <td><span class="tag-warning tooltipsC" title="SIC sin preparar">Sin preparar</span>
                                </td>
                                @endif
                                <td>{{$linea->SicLin}}</td>
                                <td>{{$linea->articulo->Art_nom_ex}}</td>
                                <td>{{round($linea->SicArtCan, 2)}}</td>
                                <td>{{number_format(strval($linea->Sicartval),0,",",".")}}</td>
                                <td>{{number_format(strval($linea->Sicartval*$linea->SicArtCan),0,",",".")}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info float-right"
                    onclick="window.location='{{route('facturar', ['SicFol'=> $sic->SicFol])}}';">Facturar</button>
            </div>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    @endforeach
</div>
@endsection