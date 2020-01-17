<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Modo preparación -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Rec_detalleTipo">Tipo</label>
                <input type="text" class="form-control" name="Rec_detalleTipo" id="Rec_detalleTipo" value="{{old('Rec_detalleTipo')}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="Rec_organolepticas">Características Organolépticas</label>
                <textarea class="form-control" rows="3" name="Rec_organolepticas" id="Rec_organolepticas" value="{{old('Rec_organolepticas')}}"></textarea>
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
                            <input type="checkbox" name="precauciones[]" value="{{$precaucion->Cau_codigo}}"> {{$precaucion->Cau_descripcion}}
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
                            <input type="checkbox" name="equipos[]" value="{{$equipo->Equ_codigo}}"> {{$equipo->Equ_nombre}}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>