<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;

// Rutas de la API para productos
Route::get('/api/productos', [ProductoController::class, 'index']); // Obtener todos los productos
Route::post('/api/productos', [ProductoController::class, 'store']); // Crear un nuevo producto
Route::put('/api/productos/{id}', [ProductoController::class, 'update']); // Actualizar un producto
Route::delete('/api/productos/{id}', [ProductoController::class, 'destroy']); // Eliminar un producto

// Rutas de la API para clientes
Route::get('/api/clientes', [ClienteController::class, 'index']); // Obtener todos los clientes
Route::post('/api/clientes', [ClienteController::class, 'store']); // Crear un cliente
Route::put('/api/clientes/{id}', [ClienteController::class, 'update']); // Actualizar un cliente
Route::delete('/api/clientes/{ci}', [ClienteController::class, 'destroy']); // Eliminar un cliente

// Rutas de la API para pedidos
Route::get('/api/pedidos', [PedidoController::class, 'index']); // Obtener todos los pedidos
Route::get('/api/pedidos/{id}', [PedidoController::class, 'show']); // Obtener un pedido específico
Route::put('/api/pedidos/{id}/mark-as-status', [PedidoController::class, 'markAsStatus']); // Actualizar estado del pedido

// Rutas de registro
// Mostrar el formulario de registro
Route::get('/registro', function () {
    return view('registro');
})->name('registro');

// Procesar los datos del formulario
Route::post('/registro', [ClienteController::class, 'store'])->name('registro.store');

// Otras rutas de vistas
Route::view('/index', 'index')->name('index');
Route::view('/login', 'login')->name('login');
Route::view('/confirmacion', 'confirmacion')->name('confirmacion');
Route::view('/historial', 'historial')->name('historial');
Route::view('/comentarios', 'comentarios')->name('comentarios');
Route::view('/catalogo', 'catalogo')->name('catalogo');
Route::view('/indexlog', 'indexlog')->name('indexlog');
Route::view('/empleado', 'empleado')->name('empleado');
Route::view('/iniempleado', 'iniempleado')->name('iniempleado');
Route::view('/admin', 'admin')->name('admin');
Route::view('/recu', 'recu')->name('recu');
Route::view('/productos', 'productos')->name('productos');
Route::view('/pedidos', 'pedidos')->name('pedidos');
Route::view('/reportes', 'reportes')->name('reportes');
Route::view('/clientes', 'clientes')->name('clientes');
Route::view('/cambi_contra', 'cambi_contra')->name('cambi_contra');
