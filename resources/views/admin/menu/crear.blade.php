@extends("theme.$theme.layout")
@section('titulo')
    Crear Menu
@endsection

@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}"></script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.error-form')
        @include('includes.mensaje-form')
        <div class="card card-info">
            <div class="card-header with-border">
                <h3 class="card-title">Crear Menús</h3>
            </div>
            <!-- form start -->
            <form action="{{route('guardar_menu')}}" id="form-general" class="form-horizontal" method="POST">
                @csrf
                <div class="card-body">
                 @include('admin.menu.form')
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="col-lg-8 mx-auto">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-8">
                                @include('includes.boton-form-crear')
                            </div>
                        </div>
                    </div>    
                </div>
                <!-- /.card-footer -->
              </form>
        </div>
    </div>
</div>
@endsection
