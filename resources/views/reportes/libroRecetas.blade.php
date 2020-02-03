@extends("theme.$theme.layoutReporte")

@section('contenido')
<div class="row">
    <div class="col-lg-5 mx-auto">
        <table class="table table-border-none" style="font-size: 13px !important;">
            <thead>
                <tr>
                    <th class="text-center" style="width: 100px;">RM/RO</th>
                    <th class="text-center">T. PREP.</th>
                    <th class="text-center" style="width: 150px;">UN. PREP</th>
                    <th class="text-center">CANTIDAD</th>
                    <th class="text-center" style="width: 200px;">DR.</th>
                    <th class="text-center" style="width: 200px;">PACIENTE</th>
                    <th class="text-center" style="width: 200px;">F. ELAB.</th>
                    <th class="text-center" style="width: 200px;">F. VENC.</th>
                    <th class="text-center" style="width: 500px;">COMPONENTES</th>
                </tr>
            </thead>
            @foreach ($recetas as $receta)
            <tbody style="border: none !important;">
                <td>{{$receta->Rec_codigo}}</td>
                <td>{{$receta->formaFarmaceutica->Pre_descripcion}}</td>
                <td class="text-center">{{$receta->Rec_unidades}}</td>
                <td>{{$receta->Rec_cantidad. ' ' .trim($receta->formaFarmaceutica->Pre_unidadMedida)}}</td>
                <td>{{trim(strtoupper($receta->prescriptor->NomPre))}}</td>
                <td>{{trim(strtoupper($receta->paciente->PacNom))}}</td>
                <td class="text-center">{{date('d-m-Y', strtotime($receta->Rec_fechaPreparacion))}}</td>
                <td class="text-center">{{date('d-m-Y', strtotime($receta->Rec_fechaVencimiento))}}</td>
                <td>
                    @foreach ($receta->lineasReceta as $linea)
                    {{$linea->articulo->Art_nom_ex}}
                    @if(!$loop->last)
                    -
                    @endif
                    @endforeach
                </td>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endsection