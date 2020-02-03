@extends("theme.$theme.layoutReporte")

@section('contenido')
<div class="row">
    <div class="col-lg-5 mx-auto">
        <h6 class="text-center font-weight-bold">REGISTRO ELABORACIÓN SEMISÓLIDOS Y LÍQUIDOS</h6>
        <table class="table table-striped table-bordered table-pdf">
            <tbody>
                <tr>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">FECHA INICO</span></div><span
                            class="p-2">{{date('d-m-Y', strtotime($receta->Rec_fechaPreparacion))}}</span>
                    </td>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">PRODUCTO ELABORADO</span></div><span
                            class="p-2"></span>
                    </td>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">RM</span></div><span
                            class="p-2">{{$receta->Rec_codigo}}</span>
                    </td>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">ORDEN DE COMPRA</span></div><span
                            class="p-2">{{trim($receta->sic->SicPOnro)}}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">DIRECCIÓN TÉCNICA</span></div><span
                            class="p-2">{{$ditec}}</span>
                    </td>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">FORMA FARMACEUTICA PRESENTACIÓN</span>
                        </div><span class="p-2">{{$receta->formaFarmaceutica->Pre_descripcion}}</span>
                    </td>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">UNIDADES</span></div><span
                            class="p-2">{{$receta->Rec_unidades}}</span>
                    </td>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">CANTIDAD</span></div><span
                            class="p-2">{{$receta->Rec_cantidad. ' ' .trim($receta->formaFarmaceutica->Pre_unidadMedida)}}</span>
                    </td>
                </tr>
                <tr>
                    <td class="bg-gris-claro">
                        <div><span class="p-2">PACIENTE</span></div>
                        <div><span class="p-2">PRESCRIPTOR</span></div>
                    </td>
                    <td>
                        <div><span class="p-2">{{trim(strtoupper($receta->paciente->PacNom))}}</span></div>
                        <div><span class="p-2">{{trim(strtoupper($receta->prescriptor->NomPre))}}</span></div>
                    </td>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">VALIDEZ</span></div><span
                            class="p-2">{{$receta->vencimiento->Ven_cantidad.' '.$receta->vencimiento->Ven_tipo}}</span>
                    </td>
                    <td>
                        <div class="bg-gris-claro"><span class="p-2">VENCE</span></div><span
                            class="p-2">{{date('d-m-Y', strtotime($receta->Rec_fechaVencimiento))}}</span>
                    </td>
                </tr>
                <tr>
                    <td class="bg-gris-claro">
                        <span class="p-2" style="line-height: 100px;">MODO
                            PREPARACIÓN</span>
                    </td>
                    <td colspan="3">
                        <textarea class="form-control" rows="3"
                            style="color: #000;">{{$receta->Rec_modoPreparacion}}</textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-bordered table-pdf mt-5">
            <thead>
                <th class="bg-gris-claro text-center font-weight-normal">PRINCIPIO ACTIVO</th>
                <th class="bg-gris-claro text-center font-weight-normal">CANTIDAD</th>
                <th class="bg-gris-claro text-center font-weight-normal">UM</th>
                <th class="bg-gris-claro text-center font-weight-normal">SERIE</th>
                <th class="bg-gris-claro text-center font-weight-normal">LOTE</th>
                <th class="bg-gris-claro text-center font-weight-normal">PROVEEDOR</th>
                <th class="bg-gris-claro text-center font-weight-normal">VENCIMIENTO</th>
            </thead>
            <tbody>
                @foreach ($receta->formulacion as $item)
                <tr>
                    <td class="p-2">{{$item->nombreFormulacion->Art_nom_ex}}</td>
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
        <table class="table table-striped table-bordered table-pdf mt-5">
            <tbody>
                <tr>
                    <td style="width: 280px;" class="bg-gris-claro">
                        <span class="p-2">TIPO</span>
                    </td>
                    <td>
                        <span class="p-2">{{$receta->Rec_detalleTipo}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 280px;" class="bg-gris-claro">
                        <span class="p-2">CARACTERÍSTICA ORGANOLÉPTICAS</span>
                    </td>
                    <td>
                        <span class="p-2">{{$receta->Rec_organolepticas}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 280px;" class="bg-gris-claro">
                        <span class="p-2" style="line-height: 100px;">OBSERVACIONES</span>
                    </td>
                    <td>
                        <span class="p-2">{{$receta->Rec_observaciones}}</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tr align="center">
                <td width="300" style="padding-right: 50px; margin-top: -100px !important;">
                    ETIQUETA
                </td>
                <td>
                    <table class="table table-striped table-bordered table-pdf">
                        <tbody>
                            <tr>
                                <td class="bg-gris-claro">
                                    <span class="p-2">OPERADOR</span>
                                </td>
                                <td width="200"><span class="p-2">{{$operador}}</span></td>
                                <td width="200"></td>
                            </tr>
                            <tr>
                                <td class="bg-gris-claro">
                                    <span class="p-2">ASISTENTES</span>
                                </td>
                                <td width="600"><span class="p-2">{{$asistentes}}</span></td>
                                <td width="200"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection