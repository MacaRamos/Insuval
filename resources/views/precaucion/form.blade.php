<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Funcionario -->
        <div class="col-lg-6">
            <div class="form-group ">
                <label for="Cau_descripcion" class="requerido">Descripción</label>
                <input type="text" class="form-control" id="Cau_descripcion" name="Cau_descripcion"
                    value="{{old('Cau_descripcion', $precaucion->Cau_descripcion ?? '')}}" required />
            </div>
        </div>
    </div>
</div>