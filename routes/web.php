<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);



Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/mi-perfil', 'HomeController@miPerfil')->name('miPerfil');
    Route::post('/actualizar-mi-perfil', 'HomeController@actualizarMiPerfil')->name('actualizarMiPerfil');
    
    

    // usuarios
    Route::get('/usuarios', 'Usuarios@index')->name('usuarios');
    Route::get('/usuarios-nuevo', 'Usuarios@nuevo')->name('nuevoUsuario');
    Route::post('/usuarios-guardar', 'Usuarios@guardar')->name('guardarUsuario');
    Route::get('/usuarios-editar/{user}', 'Usuarios@editar')->name('editarUsuario');
    Route::post('/usuarios-actualizar', 'Usuarios@actualizar')->name('actualizarUsuario');
    Route::get('/usuarios-eliminar/{user}', 'Usuarios@eliminar')->name('eliminarUsuario');
    Route::get('/usuarios-asignar-roles/{user}', 'Usuarios@asignarRoles')->name('asignarRolUsuario');
    Route::post('/usuarios-actualizar-roles', 'Usuarios@actualizarRoles')->name('actualizarRolesUsuario');


    Route::namespace('Almacen')->group(function () {

        // categorias
        Route::get('/categorias', 'Categorias@index')->name('categorias');
        Route::get('/categorias-nuevo', 'Categorias@nuevo')->name('nuevoCategoria');
        Route::post('/categorias-guardar', 'Categorias@guardar')->name('guardarCategoria');
        Route::get('/categorias-editar/{id}', 'Categorias@editar')->name('editarCategoria');
        Route::post('/categorias-actualizar', 'Categorias@actualizar')->name('actualizarCategoria');
        Route::get('/categorias-eliminar/{id}', 'Categorias@eliminar')->name('eliminarCategoria');
        

        // productos
        Route::get('/productos', 'Productos@index')->name('productos');
        Route::get('/productos-nuevo', 'Productos@nuevo')->name('nuevoProducto');
        Route::post('/productos-guardar', 'Productos@guardar')->name('guardarProducto');
        Route::get('/productos-editar/{id}', 'Productos@editar')->name('editarProducto');
        Route::post('/productos-actualizar', 'Productos@actualizar')->name('actualizarProducto');
        Route::get('/productos-eliminar/{id}', 'Productos@eliminar')->name('eliminarProducto');

    });

    Route::namespace('Ventas')->group(function () {
        // ventas
        Route::get('/facturas', 'Facturas@index')->name('facturas');
        Route::get('/facturas-nuevo', 'Facturas@nuevo')->name('nuevaFactura');
        Route::post('/facturas-guardar', 'Facturas@guardar')->name('guardarFactura');
        Route::get('/facturas-imprimir/{id}', 'Facturas@imprimir')->name('imprimirFactura');
        Route::get('/facturas-ver/{id}', 'Facturas@ver')->name('verFactura');
        Route::post('/facturas-estado', 'Facturas@estado')->name('estadoFactura');
        Route::get('/facturas-buscar-fecha-a-fecha', 'Facturas@buscarFechaFecha')->name('buscarFechaFechaFactura');
        
    });


    Route::namespace('Sistema')->group(function () {
        // roles
        Route::get('/roles', 'Roles@index')->name('roles');
        Route::post('/roles-guardar', 'Roles@guardar')->name('guardarRol');
        Route::get('/roles-eliminar/{id}', 'Roles@eliminar')->name('eliminarRol');
        // permisos
        Route::get('/permisos/{idRol}', 'Permisos@index')->name('permisos');
        Route::post('/permisos-sincronizar', 'Permisos@sincronizar')->name('sincronizarPermiso');
    });
    
});
