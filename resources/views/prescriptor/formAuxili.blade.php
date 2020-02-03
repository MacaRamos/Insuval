<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- auxili -->
        <div class="col-lg-2">
            <div class="form-group ">
                <label for="rut" class="requerido">RUT</label>
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()"
                    value="{{$auxili->Mb_Cod_aux.strtolower($auxili->Mb_Dv_aux)}}"
                    required/>
                <input type="hidden" class="form-control" id="Mb_Cod_aux" name="Mb_Cod_aux"
                    value="{{old('Mb_Cod_aux', $auxili->Mb_Cod_aux ?? '')}}" />
                <input type="hidden" class="form-control" id="Mb_Dv_aux" name="Mb_Dv_aux"
                    value="{{old('Mb_Dv_aux', $auxili->Mb_Dv_aux ?? '')}}" />
            </div>
        </div>
        <div class="col-lg-9">
            <div class="form-group">
                <label for="Mb_Razon_a" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="Mb_Razon_a" id="Mb_Razon_a"
                    value="{{old('Mb_Razon_a', $auxili->Mb_Razon_a ?? '')}}" required />
            </div>
        </div>
    </div>
</div>