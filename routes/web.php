<?php
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
Route::get('/login', function() {
    return view('login');
});
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
//control de acceso basado en el rol admin
Route::middleware(['verificarRol:admin'])->group(function () {
    //en un principio quedo con api para hacer primeras pruebas con postman
    Route::post('/api/productos', [ProductoController::class, 'guardar']);
    Route::put('/api/productos/{id}', [ProductoController::class, 'editar']);
    Route::delete('/api/productos/{id}', [ProductoController::class, 'eliminar']);
    Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']);
    Route::get('/api/productos/{id}', [ProductoController::class, 'obtenerProducto']);
});
//acceso publico para listar productos
Route::get('/', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');






