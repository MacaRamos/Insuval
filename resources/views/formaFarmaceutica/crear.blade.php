@extends("theme.$theme.layout")
@section('titulo')
Crear Forma Farmacéutica
@endsection

@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}"></script>
@include('includes.mensaje')

@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @section('tituloContenido')
        <h1>Nueva Forma Farmacéutica</h1>
        @endsection
        @include('includes.error-form')
        <div class="card mt-2">
            <div class="card-header with-border border-bottom-3 border-info">
                <h3 class="card-title">Forma Farmacéutica</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('formaFarmaceutica')}}" class="btn btn-block btn-info btn-sm ">
                        <i class="fas fa-reply"></i> Volver a listado
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form action="{{route('guardar_formaFarmaceutica')}}" id="form-general" class="form-horizontal"
                method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                    @include('formaFarmaceutica.form')
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