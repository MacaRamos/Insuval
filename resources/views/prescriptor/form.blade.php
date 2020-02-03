<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Prescriptor -->
        <div class="col-lg-2">
            <div class="form-group ">
                <label for="rut" class="requerido">RUT</label>
                @if ($prescriptor ?? '')
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()"
                    value="{{number_format($prescriptor->PreRUT, 0, ",", ".").'-'.$prescriptor->PreDV}}" required />
                @else
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()" value="{{old('rut')}}"
                    required />
                @endif
                <input type="hidden" class="form-control" id="PreRUT" name="PreRUT"
                    value="{{old('PreRUT', $prescriptor->PreRUT ?? '')}}" />
                <input type="hidden" class="form-control" id="PreDV" name="PreDV"
                    value="{{old('PreDV', $prescriptor->PreDV ?? '')}}" />
            </div>
        </div>
        <div class="col-lg-9">
            <div class="form-group">
                <label for="PreNom" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="PreNom" id="PreNom"
                    value="{{old('PreNom', $prescriptor->PreNom ?? '')}}" required />
            </div>
        </div>
    </div>
</div>