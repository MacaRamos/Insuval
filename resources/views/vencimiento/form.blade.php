<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Vencimiento -->
        <div class="col-lg-2">
            <div class="form-group ">
                <label for="Ven_cantidad" class="requerido">Cantidad</label>
                <input type="text" class="form-control" id="Ven_cantidad" name="Ven_cantidad"
                    value="{{old('Ven_cantidad', $vencimiento->Ven_cantidad ?? '')}}" required />
            </div>
        </div>
        <div class="col-lg-3">
            <!-- select -->
            <div class="form-group">
              <label>Tipo</label>
              <select class="form-control" name="Ven_tipo">
                <option selected>Días</option>
                <option>Meses</option>
                <option>Años</option>
              </select>
            </div>
          </div>
    </div>
</div>