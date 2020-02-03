@extends("theme.$theme.layout")
@section('titulo')
Crear Material
@endsection

@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}"></script>
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/daterangepicker/daterangepicker.css")}}">
<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/inputmask/min/jquery.inputmask.bundle.min.js")}}"></script>
@include('includes.mensaje')

<script>
    $(function () {
   
    $('[data-mask]').inputmask();
    //$('[time-mask]').inputmask();
    $('[time-mask]').inputmask({
        alias: "datetime",
        placeholder: "hh:mm",
        inputFormat: "HH:MM",
        insertMode: false,
        showMaskOnHover: false,
        hourFormat: "24"
    });

});
</script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.error-form')
        <div class="card border-top border-info mt-2">
            <div class="card-header with-border">
                <h3 class="card-title">Crear Material</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('articulos')}}" class="btn btn-block btn-info btn-sm ">
                        <i class="fas fa-reply"></i> Volver a Materiales
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form action="{{route('guardar_articulo')}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf
                <div class="card-body">
                    @include('articulos.form')
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