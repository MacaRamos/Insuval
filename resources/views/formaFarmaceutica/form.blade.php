<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        <div class="col-lg-6">
            @csrf
            <div class="form-group ">
                <label for="Pre_descripcion" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="Pre_descripcion" id="Pre_descripcion"
                    value="{{old('Pre_descripcion', $forma->Pre_descripcion ?? '')}}" required />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="Pre_unidadMedida" class="requerido">Unidad de medida</label>
                <input type="text" class="form-control" name="Pre_unidadMedida" id="Pre_unidadMedida"
                    value="{{old('Pre_unidadMedida', $forma->Pre_unidadMedida ?? '')}}" required />
            </div>
        </div>
    </div>
</div>