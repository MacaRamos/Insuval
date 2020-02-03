@extends("theme.$theme.layoutReporte")

@section('contenido')
<div class="row">
    <div class="col-lg-5 mx-auto">
        @foreach ($recetas as $receta)
        <table class="table table-border-none">
            <tbody>
                <tr>
                    <td class="font-weight-bold">FECHA INICIO:</td>
                    <td class="font-weight-bold">PRODUCTO ELABORADO:</td>
                    <td class="font-weight-bold">RM:</td>
                    <td class="font-weight-bold">ORDEN DE COMPRA:</td>
                </tr>
                <tr>
                    <td>{{date('d-m-Y', strtotime($receta->Rec_fechaPreparacion))}}</td>
                    <td>{{$receta->NombrePrincipio}}</td>
                    <td>{{$receta->Rec_codigo}}</td>
                    <td>{{$receta->sic->SicPOnro}}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">OPERADOR:</td>
                    <td class="font-weight-bold">FF. PRESENTACIÓN:</td>
                    <td class="font-weight-bold">UNIDADES:</td>
                    <td class="font-weight-bold">CANTIDAD:</td>
                </tr>
                <tr>
                    <td>{{explode(" ", $receta->operador->Fun_nombre)[0].' '.explode(" ", $receta->operador->Fun_apellido)[0].' '.substr(explode(" ", $receta->operador->Fun_apellido)[1], 0, 1).'.'}}
                    </td>
                    <td>{{$receta->formaFarmaceutica->Pre_descripcion}}</td>
                    <td>{{$receta->Rec_unidades}}</td>
                    <td>{{$receta->Rec_cantidad. ' ' .trim($receta->formaFarmaceutica->Pre_unidadMedida)}}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">PACIENTE:</td>
                    <td class="font-weight-bold">PRESCRIPTOR:</td>
                    <td class="font-weight-bold">VALIDEZ:</td>
                    <td class="font-weight-bold">VENCE:</td>
                </tr>
                <tr>
                    <td>{{trim(strtoupper($receta->paciente->PacNom))}}</td>
                    <td>{{trim(strtoupper($receta->prescriptor->NomPre))}}</td>
                    <td>{{$receta->vencimiento->Ven_cantidad.' '.$receta->vencimiento->Ven_tipo}}</td>
                    <td>{{date('d-m-Y', strtotime($receta->Rec_fechaVencimiento))}}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-border-none mt-5">
            <thead>
                <th>PRINCIPIO ACTIVO</th>
                <th>CANTIDAD</th>
                <th>UM</th>
                <th>SERIE</th>
                <th>LOTE</th>
                <th>PROVEEDOR</th>
                <th>VENCIMIENTO</th>
            </thead>
            <tbody>
                @foreach ($receta->formulacion as $item)
                <tr>
                    <td class="p-2">{{substr($item->nombreFormulacion->Art_nom_ex,0,20)}}</td>
                    <td class="p-2">{{round($item->Gc_cant,0)}}</td>
                    <td class="p-2">{{$item->Gc_um}}</td>
                    <td class="p-2">{{$item->nombreFormulacion->Art_serie}}</td>
                    <td class="p-2">{{$item->nombreFormulacion->ArtLote}}</td>
                    <td class="p-2"></td>
                    <td class="p-2">{{$item->nombreFormulacion->Art_fecVenc}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-5">
            <div><label for="">COLOR DE CÁPSULAS</label></div>
            <div><label for="">COMPLETAR CON EXCIPIENTE A</label></div>
            <div><label for="">TIPO ENVASE, CONSERVACIÓN</label></div>
        </div>
        <div class="pt-3">
            <hr color="#000"/>
        </div>
        @endforeach
    </div>
</div>
@endsection