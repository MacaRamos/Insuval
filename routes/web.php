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
Route::group(['prefix' => 'recetarioMagistral', 'namespace' => 'RecetarioMagistral'], function(){
    Route::get('receta', 'RecetaController@index')->name('receta');
    Route::get('receta/{SicFol}/{SicLin}/crear', 'RecetaController@crear')->name('crear_receta');
    Route::post('receta', 'RecetaController@guardar')->name('guardar_receta');
    Route::get('receta/{Rec_codigo}/{Rec_fechaVencimiento}/{button}', 'RecetaController@altaCalidad')->name('altaCalidad_receta');
    /* RUTAS FACTURA */
    Route::get('factura/', 'FacturaController@index')->name('factura');
    Route::get('factura/{SicFol}', 'FacturaController@facturar')->name('facturar');


    Route::get('buscarPaciente', 'RecetaController@buscarPaciente')->name('buscarPaciente');
    Route::get('buscarCliente', 'RecetaController@buscarCliente')->name('buscarCliente');
    Route::get('buscarPrescriptor', 'RecetaController@buscarPrescriptor')->name('buscarPrescriptor');
    Route::get('buscarEnvase', 'RecetaController@buscarEnvase')->name('buscarEnvase');
    Route::get('buscarFormaFarmaceutica', 'RecetaController@buscarFormaFarmaceutica')->name('buscarFormaFarmaceutica');
    Route::get('buscarPrincipioActivo', 'RecetaController@buscarPrincipioActivo')->name('buscarPrincipioActivo');
});


Route::group(['prefix' => 'sic', 'namespace' => 'SIC'], function(){
    Route::get('sic', 'ADSICTRXController@index')->name('sic');
    //Route::get('admin/permiso', 'Admin\PermisoController@index')->name('permiso');
});

Route::group(['prefix' => 'paciente', 'namespace' => 'Paciente'], function(){
    Route::get('paciente', 'PacienteController@index')->name('paciente');
    //Route::get('admin/permiso', 'Admin\PermisoController@index')->name('permiso');
});
