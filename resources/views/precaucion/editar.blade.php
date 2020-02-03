@extends("theme.$theme.layout")
@section('titulo')
Editar Precaucion
@endsection

@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}"></script>
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/daterangepicker/daterangepicker.css")}}">
<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/inputmask/min/jquery.inputmask.bundle.min.js")}}"></script>
@include('includes.mensaje')
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @section('tituloContenido')
        <h1>Editar Precaución</h1>
        @endsection
        @include('includes.error-form')
        <div class="card mt-2">
            <div class="card-header with-border border-bottom-3 border-info">
                <h3 class="card-title">Precaución</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('precaucion')}}" class="btn btn-block btn-info btn-sm ">
                        <i class="fas fa-reply"></i> Volver a listado
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form action="{{route('actualizar_precaucion', ['Cau_codigo' => trim($precaucion->Cau_codigo)])}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf @method('put')
                <div class="card-body">
                    @include('precaucion.form')
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="col-lg-8 mx-auto">
                        <div class="row">
                            @include('includes.boton-form-editar')
                        </div>
                    </div>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endsection