<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'InicioController@index')->name('inicio');
Route::get('seguridad/login', 'Seguridad\LoginController@index')->name('login');
Route::post('seguridad/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('seguridad/logout', 'Seguridad\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','superadmin']], function(){
    route::get('','AdminController@index');
    Route::get('permiso', 'PermisoController@index')->name('permiso');
    Route::get('permiso/crear', 'PermisoController@crear')->name('crear_permiso');
    /*RUTAS DEL MENU*/
    Route::get('menu', 'MenuController@index')->name('menu');
    Route::get('menu/crear', 'MenuController@crear')->name('crear_menu');
    Route::post('menu', 'MenuController@guardar')->name('guardar_menu');
    Route::get('menu/{Men_id}/editar', 'MenuController@editar')->name('editar_menu');
    Route::put('menu/{Men_id}', 'MenuController@actualizar')->name('actualizar_menu');
    Route::post('menu/guardar-orden', 'MenuController@guardarOrden')->name('guardar_orden');
    /*RUTAS ROL*/
    Route::get('rol', 'RolController@index')->name('rol');
    Route::get('rol/crear', 'RolController@crear')->name('crear_rol');
    Route::post('rol', 'RolController@guardar')->name('guardar_rol');
    Route::get('rol/{Rol_codigo}/editar', 'RolController@editar')->name('editar_rol');
    Route::put('rol/{Rol_codigo}', 'RolController@actualizar')->name('actualizar_rol');
    Route::delete('rol/{Rol_codigo}', 'RolController@eliminar')->name('eliminar_rol');
    /*RUTAS MENU-ROL*/
    Route::get('menu-rol', 'MenuRolController@index')->name('menu_rol');
    Route::post('menu-rol', 'MenuRolController@guardar')->name('guardar_menu_rol');
});
Route::group(['prefix' => 'recetarioMagistral', 'namespace' => 'RecetarioMagistral', 'middleware' => ['auth','superadmin']], function(){
    Route::get('receta/{tipo?}', 'RecetaController@index')->name('receta');    
    Route::get('receta/{SicFol}/{SicLin}/crear', 'RecetaController@crear')->name('crear_receta');
    Route::post('receta', 'RecetaController@guardar')->name('guardar_receta');
    Route::get('receta/{Rec_codigo}/{Rec_fechaVencimiento}/{button}', 'RecetaController@altaCalidad')->name('altaCalidad_receta');
    Route::get('receta/{Rec_codigo}/{button}', 'RecetaController@imprimirEtiqueta')->name('etiquetaReporte');

    Route::get('/libroPreparaciones', 'RecetaController@libroPreparaciones')->name('libroPreparaciones');
    Route::get('/libroRecetas', 'RecetaController@libroRecetas')->name('libroRecetas');
    /* RUTAS FACTURA */
    Route::get('factura/', 'FacturaController@index')->name('factura');
    Route::post('factura/', 'FacturaController@index')->name('factura');
    Route::get('factura/{SicFol}', 'FacturaController@facturar')->name('facturar');
    Route::get('gdespacho/{SicFol}', 'FacturaController@gdespacho')->name('gdespacho');

    Route::get('buscarPaciente', 'RecetaController@buscarPaciente')->name('buscarPaciente');
    Route::get('buscarCliente', 'RecetaController@buscarCliente')->name('buscarCliente');
    Route::get('buscarPrescriptor', 'RecetaController@buscarPrescriptor')->name('buscarPrescriptor');
    Route::get('buscarEnvase', 'RecetaController@buscarEnvase')->name('buscarEnvase');
    Route::get('buscarFormaFarmaceutica', 'RecetaController@buscarFormaFarmaceutica')->name('buscarFormaFarmaceutica');
    Route::get('buscarPrincipioActivo', 'RecetaController@buscarPrincipioActivo')->name('buscarPrincipioActivo');
});


Route::group(['prefix' => 'sic', 'namespace' => 'SIC', 'middleware' => ['auth','superadmin']], function(){
    Route::get('/', 'ADSICTRXController@index')->name('sic');
    //Route::get('admin/permiso', 'Admin\PermisoController@index')->name('permiso');
});

Route::group(['prefix' => 'articulos', 'namespace' => 'Articulos', 'middleware' => ['auth','superadmin']], function(){
    Route::get('/', 'ARTMAESTController@index')->name('articulos');
    Route::post('/', 'ARTMAESTController@index')->name('articulos');
    Route::get('/crear', 'ARTMAESTController@crear')->name('crear_articulo');
    Route::post('/guardar', 'ARTMAESTController@guardar')->name('guardar_articulo');
    Route::get('/{Art_cod}/editar', 'ARTMAESTController@editar')->name('editar_articulo');
    Route::put('/{Art_cod}', 'ARTMAESTController@actualizar')->name('actualizar_articulo');
    Route::delete('/{Art_cod}/eliminar', 'ARTMAESTController@eliminar')->name('eliminar_articulo');
});

Route::group(['prefix' => 'formaFarmaceutica', 'namespace' => 'FormaFarmaceutica', 'middleware' => ['auth','superadmin']], function(){
    Route::get('/', 'FormaFarmaceuticaController@index')->name('formaFarmaceutica');
    Route::post('/', 'FormaFarmaceuticaController@index')->name('formaFarmaceutica');
    Route::get('/crear', 'FormaFarmaceuticaController@crear')->name('crear_formaFarmaceutica');
    Route::post('/guardar', 'FormaFarmaceuticaController@guardar')->name('guardar_formaFarmaceutica');
    Route::get('/{Pre_codigo}/editar', 'FormaFarmaceuticaController@editar')->name('editar_formaFarmaceutica');
    Route::put('/{Pre_codigo}', 'FormaFarmaceuticaController@actualizar')->name('actualizar_formaFarmaceutica');
    Route::delete('/{Pre_codigo}/eliminar', 'FormaFarmaceuticaController@eliminar')->name('eliminar_formaFarmaceutica');
});

Route::group(['prefix' => 'paciente', 'namespace' => 'Paciente'], function(){   
    Route::get('/', 'PacienteController@index')->name('paciente');
    Route::post('/', 'PacienteController@index')->name('paciente');
    Route::get('/crear', 'PacienteController@crear')->name('crear_paciente');
    Route::post('/guardar', 'PacienteController@guardar')->name('guardar_paciente');
    Route::get('/{PacID}/editar', 'PacienteController@editar')->name('editar_paciente');
    Route::put('/{PacID}', 'PacienteController@actualizar')->name('actualizar_paciente');
    Route::delete('/{PacID}/eliminar', 'PacienteController@eliminar')->name('eliminar_paciente');
});

Route::group(['prefix' => 'prescriptor', 'namespace' => 'Prescriptor'], function(){   
    Route::get('/', 'PrescriptorController@index')->name('prescriptor');
    Route::post('/', 'PrescriptorController@index')->name('prescriptor');
    Route::get('/crear', 'PrescriptorController@crear')->name('crear_prescriptor');
    Route::post('/guardar', 'PrescriptorController@guardar')->name('guardar_prescriptor');
    Route::get('/{IdPre}/editar', 'PrescriptorController@editar')->name('editar_prescriptor');
    Route::put('/{PreID}', 'PrescriptorController@actualizar')->name('actualizar_prescriptor');
    Route::put('/{Mb_Cod_aux}', 'PrescriptorController@actualizar2')->name('actualizar_prescriptor2');
    Route::delete('/{IdPre}/eliminar', 'PrescriptorController@eliminar')->name('eliminar_prescriptor');
});

Route::group(['prefix' => 'vencimiento', 'namespace' => 'Vencimiento'], function(){   
    Route::get('/', 'VencimientoController@index')->name('vencimiento');
    Route::post('/', 'VencimientoController@index')->name('vencimiento');
    Route::get('/crear', 'VencimientoController@crear')->name('crear_vencimiento');
    Route::post('/guardar', 'VencimientoController@guardar')->name('guardar_vencimiento');
    Route::get('/{Ven_codigo}/editar', 'VencimientoController@editar')->name('editar_vencimiento');
    Route::put('/{Ven_codigo}', 'VencimientoController@actualizar')->name('actualizar_vencimiento');
    Route::delete('/{Ven_codigo}/eliminar', 'VencimientoController@eliminar')->name('eliminar_vencimiento');
});
Route::group(['prefix' => 'equipo', 'namespace' => 'Equipo'], function(){   
    Route::get('/', 'EquipoController@index')->name('equipo');
    Route::post('/', 'EquipoController@index')->name('equipo');
    Route::get('/crear', 'EquipoController@crear')->name('crear_equipo');
    Route::post('/guardar', 'EquipoController@guardar')->name('guardar_equipo');
    Route::get('/{Equ_codigo}/editar', 'EquipoController@editar')->name('editar_equipo');
    Route::put('/{Equ_codigo}', 'EquipoController@actualizar')->name('actualizar_equipo');
    Route::delete('/{Equ_codigo}/eliminar', 'EquipoController@eliminar')->name('eliminar_equipo');
});
Route::group(['prefix' => 'precaucion', 'namespace' => 'Precaucion'], function(){   
    Route::get('/', 'PrecaucionController@index')->name('precaucion');
    Route::post('/', 'PrecaucionController@index')->name('precaucion');
    Route::get('/crear', 'PrecaucionController@crear')->name('crear_precaucion');
    Route::post('/guardar', 'PrecaucionController@guardar')->name('guardar_precaucion');
    Route::get('/{Cau_codigo}/editar', 'PrecaucionController@editar')->name('editar_precaucion');
    Route::put('/{Cau_codigo}', 'PrecaucionController@actualizar')->name('actualizar_precaucion');
    Route::delete('/{Cau_codigo}/eliminar', 'PrecaucionController@eliminar')->name('eliminar_precaucion');
});
Route::group(['prefix' => 'funcionario', 'namespace' => 'Funcionario'], function(){   
    Route::get('/', 'FuncionarioController@index')->name('funcionario');
    Route::post('/', 'FuncionarioController@index')->name('funcionario');
    Route::get('/crear', 'FuncionarioController@crear')->name('crear_funcionario');
    Route::post('/guardar', 'FuncionarioController@guardar')->name('guardar_funcionario');
    Route::get('/{Fun_rut}/editar', 'FuncionarioController@editar')->name('editar_funcionario');
    Route::put('/{Fun_rut}', 'FuncionarioController@actualizar')->name('actualizar_funcionario');
    Route::delete('/{Fun_rut}/eliminar', 'FuncionarioController@eliminar')->name('eliminar_funcionario');
});