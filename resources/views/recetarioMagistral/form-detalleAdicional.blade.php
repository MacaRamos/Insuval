<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Modo preparación -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Tipo">Tipo</label>
                <input type="text" class="form-control" name="Tipo" id="Tipo" value="{{old('Tipo')}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="caracteristicas-organolepticas">Características Organolépticas</label>
                <textarea class="form-control" rows="3" value="{{old('caracteristicas-organolepticas')}}"></textarea>
            </div>
        </div>
        <!-- /Modo preparación -->
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label for="Precauciones">Precauciones</label>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    Seleccione...
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">
                    @foreach ($precauciones as $precaucion)
                    <li>
                        <label style="font-weight: 400;">
                            <input type="checkbox"> {{$precaucion->Cau_descripcion}}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-4">
            <label for="Equipo">Equipo</label>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    Seleccione...
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">
                    @foreach ($equipos as $equipo)
                    <li>
                        <label style="font-weight: 400;">
                            <input type="checkbox"> {{$equipo->Equ_nombre}}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>