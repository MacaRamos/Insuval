<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        <div class="col-lg-6">
            @csrf
            <div class="form-group ">
                <label for="Art_cod" class="requerido">Código</label>
                <input type="text" class="form-control" name="Art_cod" id="Art_cod" value="{{old('Art_cod', $articulo->Art_cod ?? '')}}"
                    required />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="Art_nom_ex" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="Art_nom_ex" id="Art_nom_ex" value="{{old('Art_nom_ex', $articulo->Art_nom_ex ?? '')}}"
                    required />
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        <div class="col-lg-6">
            @csrf
            <div class="form-group ">
                <label for="Art_serie">Serie</label>
                <input type="text" class="form-control" name="Art_serie" id="Art_serie" value="{{old('Art_serie', $articulo->Art_serie ?? '')}}"/>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="ArtLote">Lote</label>
                <input type="text" class="form-control" name="ArtLote" id="ArtLote" value="{{old('ArtLote', $articulo->ArtLote ?? '')}}" />
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        <div class="col-lg-6">
            @csrf
            <div class="form-group ">
                <label for="Art_fecElab" class="requerido">F. Elab.</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" name="Art_fecElab" data-inputmask-alias="datetime"
                        data-inputmask-inputformat="dd/mm/yyyy" data-mask value="{{old('Art_fecElab', $articulo->Art_fecElab ?? '')}}" required/>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="Art_fecVenc" class="requerido">F. Venc.</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" name="Art_fecVenc" data-inputmask-alias="datetime"
                        data-inputmask-inputformat="dd/mm/yyyy" data-mask value="{{old('Art_fecVenc', $articulo->Art_fecVenc ?? '')}}" required />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        <div class="col-lg-6">
            @csrf
            <div class="form-group ">
                <label for="Art_horElab">H. Elab.</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" name="Art_horElab" time-mask/>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="Art_horVenc">H. Venc.</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" name="Art_horVenc" time-mask/>
                </div>
            </div>
        </div>
    </div>
</div>