<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Funcionario -->
        <div class="col-lg-6">
            <div class="form-group ">
                <label for="Equ_nombre" class="requerido">Nombre</label>
                <input type="text" class="form-control" id="Equ_nombre" name="Equ_nombre"
                    value="{{old('Equ_nombre', $equipo->Equ_nombre ?? '')}}" required />
            </div>
        </div>
    </div>
</div>