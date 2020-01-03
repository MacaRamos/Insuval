<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Tipo receta, numero receta y fecha vencimiento -->
        <div class="col-lg-2">
            <div class="form-group clearfix pt-4">
                <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary1" name="Rec_tipo" value="RM" checked>
                    <label for="Rec_tipoRM">RM
                    </label>
                </div>
                <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary2" name="Rec_tipo" value="RO">
                    <label for="Rec_tipoRO">RO
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="numero_receta">Nª Receta</label>
                <input type="text" name="Rec_codigo" id="numero_receta" class="form-control" placeholder=""
                    value="{{$receta->Id_RM}}" disabled>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-group">
                <label for="Rec_fechaVencimiento">Fecha Elaboración - Vencimiento:</label>
                <div class="input-group">
                    <button type="button" class="btn btn-default float-right" id="Rec_fechaVencimiento-btn">
                        <i class="far fa-calendar-alt"></i> Duración
                        <i class="fas fa-caret-down"></i>
                    </button>
                    <input type="text" class="form-control float-right" name="Rec_fechaVencimientov"
                        id="Rec_fechaVencimiento">
                </div>
            </div>
        </div>
        <!-- /Tipo receta, numero receta y fecha vencimiento -->
    </div>
    <div class="row">
        <!-- SIC y numero O/C -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="SicFol">SIC</label>
                <input type="text" class="form-control" name="SicFol" id="SicFol" value="{{$sic->SicFol}}" disabled>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="SicPOnro">N° O/C</label>
                <input type="text" class="form-control" name="SicPOnro" id="SicPOnro" value="{{$sic->SicPOnro}}"
                    disabled>
            </div>
        </div>
        <!-- SIC y numero O/C -->
    </div>
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        <div class="col-lg-4">
            @csrf
            <div class="form-group ">
                <label for="Paciente">Paciente</label>
                <input type="text" class="form-control" name="Paciente" id="Paciente"
                    value="{{$sic->paciente->PacNom}}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Cliente">Cliente</label>
                <input type="text" class="form-control" name="Cliente" id="Cliente"
                    value="{{$sic->cliente->Mb_Razon_a}}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Prescriptor">Prescriptor</label>
                <input type="text" class="form-control" name="Prescriptor" id="Prescriptor"
                    value="{{old('Prescriptor')}}">
            </div>
        </div>
        <!-- /Paciente, Cliente y Prescriptor -->
    </div>
    <div class="row">
        <!-- Envase, Forma Farmacéutica y Cant. Preparado -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Envase">Envase</label>
                <input type="text" class="typeahead form-control" name="Envase" id="Envase" value="{{old('Envase')}}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="forma-farmaceutica">Forma Farmacéutica</label>
                <input type="text" class="form-control" name="forma-farmaceutica" id="forma-farmaceutica"
                    value="{{old('forma-farmaceutica')}}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="cant-preparado">Cant. Preparado</label>
                <input type="text" class="form-control" name="cant-preparado" id="cant-preparado"
                    value="{{old('cant-preparado')}}">
            </div>
        </div>
        <!-- /Envase, Forma Farmacéutica y Cant. Preparado -->
    </div>
    <div class="row">
        <!-- Principio Activo, Unidades y Indicación -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="principio-activo">Principio Activo</label>
                <input type="text" class="form-control" name="principio-activo" id="principio-activo"
                    value="{{$sic->lineasSIC[0]->articulo->Art_nom_ex}}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Unidades">Unidades</label>
                <input type="number" class="form-control" name="Unidades" id="Unidades"
                    value="{{round($sic->lineasSIC[0]->SicArtCan, 0)}}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Indicación">Indicación</label>
                <input type="text" class="form-control" name="Indicación" id="Indicación" value="{{old('Indicación')}}">
            </div>
        </div>
        <!-- /Principio Activo, Unidades y Indicación -->
    </div>
    <div class="row">
        <!-- Funcionarios -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Fun_rut">Operador</label>
                <select class="form-control" name='Operador'>
                    @foreach ($operadores as $operador)
                    <option>{{$operador->Fun_nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <label for="Asistente">Asistentes</label>
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
                            <input type="checkbox" > {{$asistente->Fun_nombre}}
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
                <label for="modo-preparacion">Modo preparación</label>
                <textarea class="form-control" rows="3" value="{{old('modo-preparacion')}}"></textarea>
            </div>
        </div>
        <!-- /Modo preparación -->
    </div>
</div>