<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Funcionario -->
        <div class="col-lg-2">
            <div class="form-group ">
                <label for="rut" class="requerido">RUT</label>
                @if ($funcionario ?? '')
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()"
                    value="{{number_format($funcionario->Fun_rut, 0, ",", ".").'-'.$funcionario->Fun_dv}}" required />
                @else
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()" value="{{old('rut')}}"
                    required />
                @endif
                <input type="hidden" class="form-control" id="Fun_rut" name="Fun_rut"
                    value="{{old('Fun_rut', $funcionario->Fun_rut ?? '')}}"/>
                <input type="hidden" class="form-control" id="Fun_dv" name="Fun_dv"
                    value="{{old('Fun_dv', $funcionario->Fun_dv ?? '')}}"/>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="nombre" class="requerido">Nombres</label>
                <input type="text" class="form-control" id="Fun_nombre" name="Fun_nombre"
                    value="{{old('Fun_nombre', $funcionario->Fun_nombre ?? '')}}" required />

            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="nombre" class="requerido">Apellidos</label>
                <input type="text" class="form-control" id="Fun_apellido" name="Fun_apellido"
                    value="{{old('Fun_apellido', $funcionario->Fun_dv ?? '')}}" required />
            </div>
        </div>
    </div>
</div>