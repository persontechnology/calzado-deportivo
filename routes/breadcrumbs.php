<?php
// Inicio
Breadcrumbs::for('inicio', function ($trail) {
    $trail->push('Inicio', url('/'));
});
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Ingresar', url('/login'));
});
// reset pasword
Breadcrumbs::for('resetPassword', function ($trail) {
    $trail->parent('login');
    $trail->push('Restablecer contraseña', url('/password/reset'));
});


// Inicio
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Inicio', route('home'));
});

// mi perfil
Breadcrumbs::for('miPerfil', function ($trail) {
    $trail->parent('home');
    $trail->push('Mi perfil', route('miPerfil'));
});

// usuarios
Breadcrumbs::for('usuarios', function ($trail) {
    $trail->parent('home');
    $trail->push('Listado de usuarios', route('usuarios'));
});
Breadcrumbs::for('nuevoUsuario', function ($trail) {
    $trail->parent('usuarios');
    $trail->push('Nuevo usuario', route('nuevoUsuario'));
});
Breadcrumbs::for('editarUsuario', function ($trail,$user) {
    $trail->parent('usuarios');
    $trail->push('Editar usuario', route('editarUsuario',$user->id));
});

Breadcrumbs::for('asignarRolUsuario', function ($trail,$user) {
    $trail->parent('usuarios');
    $trail->push('Asignar roles de usuario', route('asignarRolUsuario',$user->id));
});


// almacen -categorias
Breadcrumbs::for('categorias', function ($trail) {
    $trail->parent('home');
    $trail->push('Almacen-Listado de categorías', route('categorias'));
});
Breadcrumbs::for('nuevoCategoria', function ($trail) {
    $trail->parent('categorias');
    $trail->push('Nueva categoría', route('nuevoCategoria'));
});
Breadcrumbs::for('editarCategoria', function ($trail,$categoria) {
    $trail->parent('categorias');
    $trail->push('Editar categoría', route('editarCategoria',$categoria->id));
});

// almacen -productos
Breadcrumbs::for('productos', function ($trail) {
    $trail->parent('home');
    $trail->push('Almacen-Listado de productos', route('productos'));
});
Breadcrumbs::for('nuevoProducto', function ($trail) {
    $trail->parent('productos');
    $trail->push('Nuevo producto', route('nuevoProducto'));
});
Breadcrumbs::for('editarProducto', function ($trail,$producto) {
    $trail->parent('productos');
    $trail->push('Editar producto', route('editarProducto',$producto->id));
});


// ventas facturas
Breadcrumbs::for('facturas', function ($trail) {
    $trail->parent('home');
    $trail->push('Ventas-Listado de facturas', route('facturas'));
});
Breadcrumbs::for('nuevaFactura', function ($trail) {
    $trail->parent('facturas');
    $trail->push('Nueva factura', route('nuevaFactura'));
});
Breadcrumbs::for('verFactura', function ($trail,$factura) {
    $trail->parent('facturas');
    $trail->push('Detalle de factura', route('verFactura',$factura->id));
});

Breadcrumbs::for('buscarFechaFechaFactura', function ($trail) {
    $trail->parent('facturas');
    $trail->push('Buscar facturas', route('buscarFechaFechaFactura'));
});


// Roles y permisos
Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles', route('roles'));
});
Breadcrumbs::for('permisos', function ($trail,$rol) {
    $trail->parent('roles');
    $trail->push('Permisos', route('permisos',$rol->id));
});