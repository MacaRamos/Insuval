<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Paciente -->
        <div class="col-lg-2">
            <div class="form-group ">
                <label for="rut" class="requerido">RUT</label>
                @if ($paciente ?? '')
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()"
                    value="{{number_format($paciente->PacRUT, 0, ",", ".").'-'.$paciente->PacDV}}" required />
                @else
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()" value="{{old('rut')}}"
                    required />
                @endif
                <input type="hidden" class="form-control" id="PacRUT" name="PacRUT"
                    value="{{old('PacRUT', $paciente->PacRUT ?? '')}}"/>
                <input type="hidden" class="form-control" id="PacDV" name="PacDV"
                    value="{{old('PacDV', $paciente->PacDV ?? '')}}"/>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="form-group">
                <label for="PacNom" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="PacNom" id="PacNom"
                    value="{{old('PacNom', $paciente->PacNom ?? '')}}" required />
            </div>
        </div>
    </div>
</div>