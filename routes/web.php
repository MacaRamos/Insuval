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

Route::get('/', 'InicioController@index');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
    Route::get('permiso', 'PermisoController@index')->name('permiso');
    Route::get('permiso/crear', 'PermisoController@crear')->name('crear_permiso');
    //Route::get('admin/permiso', 'Admin\PermisoController@index')->name('permiso');
});
Route::group(['prefix' => 'recetarioMagistral', 'namespace' => 'RecetarioMagistral'], function(){
    Route::get('receta', 'RecetaController@index')->name('receta');
    Route::get('receta/crear', 'RecetaController@crear')->name('crear_receta');
    //Route::get('admin/permiso', 'Admin\PermisoController@index')->name('permiso');
});
