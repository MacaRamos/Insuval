<!-- Editable table -->

<div id="table" class="table-editable col-lg-8 mx-auto">
    <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-info"><i class="fas fa-plus fa-2x"
                aria-hidden="true"></i></a></span>
    <table class="table table-bordered table-responsive-md table-striped text-center">
        <thead>
            <tr>
                <th class="text-center">Item</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Peso (g)</th>
                <th class="text-center">Un. Medida</th>
                <th class="text-center">Porcentaje (%)</th>
                <th class="text-center">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sic->lineasSIC[0]->formulacion as $key => $componente)
            <tr data-item="{{$key+1}}">
                <td class="pt-3-half" contenteditable="true">{{$key+1}}</td>
                <td class="pt-3-half componente" contenteditable="true">{{$componente->nombreFormulacion->Art_nom_ex}}</td>
                <td class="pt-3-half" contenteditable="true">{{$componente->Gc_cant}}</td>
                <td class="pt-3-half" contenteditable="true"></td>
                <td class="pt-3-half" contenteditable="true">{{$componente->Gc_um}}</td>
                <td class="pt-3-half" contenteditable="true"></td>
                <td>
                <span class="table-remove"><button type="button"
                    class="btn btn-danger btn-rounded btn-sm my-0">Remover</button></span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Editable table -->