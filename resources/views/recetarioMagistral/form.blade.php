<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Tipo receta, numero receta y fecha vencimiento -->
        <div class="col-lg-2">
            <!-- radio -->
            <div class="form-group clearfix">
                <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary1" name="Rec_tipo" value="RM" onclick="radioTipoRM();" checked>
                    <label for="radioPrimary1">RM
                    </label>
                </div>
                <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary2" name="Rec_tipo" value="RO" onclick="radioTipoRO();">
                    <label for="radioPrimary2">RO
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="Receta" class="requerido">Nª Receta</label>
                <input type="text" name="Rec_codigo" id="Rec_codigo" class="form-control" value="{{$receta->Id_RM}}"
                    readonly="readonly" />
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-group">
                <label for="Rec_fechaVencimiento" class="requerido">Fecha Elaboración - Vencimiento:</label>
                <div class="input-group">
                    <button type="button" class="btn btn-default float-right" id="validez-btn">
                        <i class="far fa-calendar-alt"></i> Duración
                        <i class="fas fa-caret-down"></i>
                    </button>
                    <input type="text" class="form-control" name="fechaDuracion" id="fechaDuracion"
                        required />
                    <input type="hidden" class="form-control" name="Rec_fechaPreparacion" id="Rec_fechaPreparacion"
                        required />
                    <input type="hidden" class="form-control" name="Rec_fechaVencimiento" id="Rec_fechaVencimiento"
                        required />
                    <input type="hidden" class="form-control" name="Ven_codigo" id="Ven_codigo" />
                </div>
            </div>
        </div>
        <!-- /Tipo receta, numero receta y fecha vencimiento -->
    </div>
    <div class="row">
        <!-- SIC y numero O/C -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="SicFol" class="requerido">SIC</label>
                <input type="text" class="form-control" name="SicFol" id="SicFol" value="{{$sic->SicFol}}"
                    readonly="readonly" required />
                <input type="hidden" class="form-control" name="SicLin" id="SicLin"
                    value="{{$sic->lineasSIC[0]->SicLin}}" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="SicPOnro" class="requerido">N° O/C</label>
                <input type="text" class="form-control" name="SicPOnro" id="SicPOnro" value="{{$sic->SicPOnro}}"
                    readonly="readonly" required />
            </div>
        </div>
        <!-- SIC y numero O/C -->
    </div>
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        <div class="col-lg-4">
            @csrf
            <div class="form-group ">
                <label for="Paciente" class="requerido">Paciente</label>
                <input type="hidden" class="form-control" name="PacID" id="PacID" value="{{$sic->paciente->PacID}}">
                <input type="text" class="form-control" name="PacNom" id="PacNom" value="{{$sic->paciente->PacNom}}"
                    required />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Cliente" class="requerido">Cliente</label>
                <input type="hidden" class="form-control" name="Mb_Cod_aux" id="Mb_Cod_aux"
                    value="{{$sic->cliente->Mb_Cod_aux}}">
                <input type="text" class="form-control" name="Mb_Razon_a" id="Mb_Razon_a"
                    value="{{$sic->cliente->Mb_Razon_a}}" required />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Prescriptor" class="requerido">Prescriptor</label>
                <input type="hidden" class="form-control" name="IdPre" id="IdPre" value="{{old('IdPre')}}">
                <input type="text" class="form-control" name="NomPre" id="NomPre" value="{{old('NomPre')}}" required />
            </div>
        </div>
        <!-- /Paciente, Cliente y Prescriptor -->
    </div>
    <div class="row">
        <!-- Envase, Forma Farmacéutica y Cant. Preparado -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Envase" class="requerido">Envase</label>
                <input type="hidden" class="typeahead form-control" name="Env_codigo" id="Env_codigo"
                    value="{{old('Env_codigo')}}">
                <input type="text" class="typeahead form-control" name="Env_descripcion" id="Env_descripcion"
                    value="{{old('Env_descripcion')}}" required />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="forma-farmaceutica" class="requerido">Forma Farmacéutica</label>
                <input type="hidden" class="form-control" name="Pre_codigo" id="Pre_codigo">
                <input type="text" class="form-control" name="Pre_descripcion" id="Pre_descripcion"
                    value="{{old('Pre_descripcion')}}" required />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Rec_cantidad" class="requerido">Cant. Preparado</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="Rec_cantidad" id="Rec_cantidad"
                    value="{{old('Rec_cantidad')}}" required /><span id="um"></span>
                </div>
                
                
            </div>
        </div>
        <!-- /Envase, Forma Farmacéutica y Cant. Preparado -->
    </div>
    <div class="row">
        <!-- Principio Activo, Unidades y Indicación -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="PrincipioActivo" class="requerido">Principio Activo</label>
                <input type="hidden" class="form-control" name="PrincipioActivo" id="PrincipioActivo"
                    value="{{$sic->lineasSIC[0]->articulo->Art_cod}}">
                <input type="text" class="form-control" name="NombrePrincipio" id="NombrePrincipio"
                    value="{{$sic->lineasSIC[0]->articulo->Art_nom_ex}}" required />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Rec_unidades" class="requerido">Unidades</label>
                <input type="number" class="form-control" name="Rec_unidades" id="Rec_unidades"
                    value="{{round($sic->lineasSIC[0]->SicArtCan-$recetasPrimeras->sum('Rec_unidades'))}}" required />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Rec_indicacion" class="requerido">Indicación</label>
                <input type="text" class="form-control" name="Rec_indicacion" id="Rec_indicacion"
                    value="{{old('Rec_indicacion')}}" required />
            </div>
        </div>
        <!-- /Principio Activo, Unidades y Indicación -->
    </div>
    <div class="row">
        <!-- Funcionarios -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Fun_quimico" class="requerido">Operador</label>
                <select class="form-control" name='Fun_quimico'>
                    @foreach ($operadores as $operador)
                    @if ($operador->Fun_tipo == 'DT')
                    <option selected="true" value="{{$operador->Fun_rut}}">{{explode(" ", $operador->Fun_nombre)[0]}}
                        {{explode(" ", $operador->Fun_apellido)[0]}}
                        {{substr(explode(" ", $operador->Fun_apellido)[1],0,1)}}.</option>
                    @else
                    <option value="{{$operador->Fun_rut}}">{{explode(" ", $operador->Fun_nombre)[0]}}
                        {{explode(" ", $operador->Fun_apellido)[0]}}
                        {{substr(explode(" ", $operador->Fun_apellido)[1],0,1)}}.</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <label for="Asistente" class="requerido">Asistentes</label>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    Seleccione...
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1" name="Asistente">
                    @foreach ($asistentes as $asistente)
                    <li>
                        <label style="font-weight: 400;">
                            <input type="checkbox" name='asistentes[]' value="{{$asistente->Fun_rut}}">
                            {{explode(" ", $asistente->Fun_nombre)[0]}}
                            {{explode(" ", $asistente->Fun_apellido)[0]}}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- /Funcionarios -->
    </div>
    <div class="row">
        <!-- Modo preparación -->
        <div class="col-lg-12">
            <div class="form-group">
                <label for="Rec_modoPreparacion">Modo preparación</label>
                <textarea class="form-control" rows="7" cols="100" readonly="readonly" name="Rec_modoPreparacion"
                    value="{{$sic->lineasSIC[0]->articulo->art_receta}}">{{trim($sic->lineasSIC[0]->articulo->art_receta)}}</textarea>
            </div>
        </div>
        <!-- /Modo preparación -->
    </div>
</div>