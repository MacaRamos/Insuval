<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- radio -->
        <div class="col-lg-2">
            <div class="form-group clearfix pt-4">
                <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary1" name="r1" checked>
                    <label for="radioPrimary1">RM
                    </label>
                </div>
                <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary2" name="r1">
                    <label for="radioPrimary2">RO
                    </label>
                </div>
            </div>
        </div>
        <!-- Fin radio -->
        <!-- Nª Receta -->
        <div class="col-lg-2">
            <div class="form-group">
                <label>Nª Receta</label>
                <input type="text" class="form-control" placeholder="" disabled>
            </div>
        </div>
        <!-- Fin Nº Receta -->
        <!-- Fecha -->
        <div class="col-lg-8">
            <div class="form-group">
                <label>Fecha Elaboración - Vencimiento:</label>

                <div class="input-group">
                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                        <i class="far fa-calendar-alt"></i> Duración
                        <i class="fas fa-caret-down"></i>
                    </button>
                    <span type="text" class="form-control float-right" id="reportrange"></span>
                </div>
            </div>
        </div>
        <!-- Fin Fecha -->
    </div>
    <div class="row">
        <!-- SIC y SicPOnro-->
        <div class="col-lg-2">
            <div class="form-group">
                <label>SIC</label>
                <input type="text" class="form-control" value="{{$sic->SicFol}}" disabled>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label>N° O/C</label>
                <input type="text" class="form-control" value="{{$sic->SicPOnro}}" disabled>
            </div>
        </div>
        <!-- FIn Sic Y SicPOnro -->
    </div>
    <div class="row">
        <!-- Paciente -->
        <div class="col-lg-3">
            <!-- text input -->
            <div class="form-group">
                <label>Paciente</label>
                <input type="text" class="form-control" value="{{$sic->paciente->PacNom}}">
            </div>
        </div>
        <!-- Fin Paciente -->
    </div>
</div>