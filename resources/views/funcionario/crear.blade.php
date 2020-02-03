@extends("theme.$theme.layout")
@section('titulo')
Crear Funcionario
@endsection

@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}"></script>
<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/inputmask/min/jquery.inputmask.bundle.min.js")}}"></script>
@include('includes.mensaje')
<script>
$("#rut").inputmask({
	mask: "9[9.999.999]-[9|k]",
    placeholder: ''
});
function checkRut() {
    var rut = $('#rut').val();
    var valor = rut.replace('.','');
    valor = valor.replace('-','');
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    $('#Fun_rut').val(cuerpo.replace('.',''));
    $('#Fun_dv').val(dv);    
}

//  $(document).ready(function(){
   
//  });
</script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @section('tituloContenido')
        <h1>Nuevo Funcionario</h1>
        @endsection
        @include('includes.error-form')
        <div class="card mt-2">
            <div class="card-header with-border border-bottom-3 border-info">
                <h3 class="card-title">Funcionario</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('funcionario')}}" class="btn btn-block btn-info btn-sm ">
                        <i class="fas fa-reply"></i> Volver a listado
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form action="{{route('guardar_funcionario')}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf
                <div class="card-body">
                    @include('funcionario.form')
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="col-lg-8 mx-auto">
                        <div class="row">
                            @include('includes.boton-form-crear')
                        </div>
                    </div>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endsection