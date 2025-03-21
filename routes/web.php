<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AuthClienteController;
use App\Http\Controllers\AuthController;

// === RUTAS DE LA API ===
Route::prefix('api')->group(function () {
    // Rutas para productos
    Route::get('/productos', [ProductoController::class, 'index']); // Listar productos
    Route::post('/productos', [ProductoController::class, 'store']); // Crear producto
    Route::get('/productos/stock-bajo', [ProductoController::class, 'obtenerStockBajo']); // Productos con stock bajo
    Route::get('/productos/{id_producto}', [ProductoController::class, 'show']); // Detallar un producto
    Route::put('/productos/{id_producto}', [ProductoController::class, 'update']); // Actualizar producto
    Route::delete('/productos/{id_producto}', [ProductoController::class, 'destroy']); // Eliminar producto
    Route::get('/productos', [ProductoController::class, 'obtenerProductosPorCategoria']); // Categorizar productos

    // Rutas para clientes gestionados por administrador
    Route::get('/clientes', [ClienteController::class, 'index']); // Listar clientes
    Route::get('/clientes/{ci}', [ClienteController::class, 'show']);
    Route::put('/clientes/{ci}', [ClienteController::class, 'update']);
    Route::delete('/clientes/{ci}', [ClienteController::class, 'destroy']); // Eliminar cliente
    Route::post('/clientes', [ClienteController::class, 'store']);

    // Rutas para pedidos
    Route::get('/pedidos', [PedidoController::class, 'index']); // Listar pedidos
    Route::get('/pedidos/{id}', [PedidoController::class, 'show']); // Mostrar un pedido
    Route::put('/pedidos/{id}/mark-as-status', [PedidoController::class, 'markAsStatus']); // Cambiar estado del pedido
});

// === RUTAS PÚBLICAS (acceso sin autenticación) ===
Route::view('/index', 'index')->name('index');

// Rutas de autenticación (solo para invitados)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthClienteController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthClienteController::class, 'login'])->name('login.post');
    Route::view('/registro', 'registro')->name('registro');
    Route::view('/recu', 'recu')->name('recu');
});

// === RUTAS PROTEGIDAS (requieren autenticación) ===
Route::middleware(['auth:cliente'])->group(function () {
    // Cerrar sesión
    Route::post('/logout', [AuthClienteController::class, 'logout'])->name('logout');

    // Funcionalidades de clientes
    Route::view('/confirmacion', 'confirmacion')->name('confirmacion');
    Route::view('/historial', 'historial')->name('historial');
    Route::view('/catalogo', 'catalogo')->name('catalogo');
    Route::view('/cambi_contra', 'cambi_contra')->name('cambi_contra');

    // Rutas de gestión (protegidas)
    Route::view('/empleado', 'empleado')->name('empleado');
    Route::view('/clientes', 'clientes')->name('clientes');
    Route::view('/productos', 'productos')->name('productos');
    Route::view('/pedidos', 'pedidos')->name('pedidos');
    Route::view('/reportes', 'reportes')->name('reportes');
});

// === RUTAS PROTEGIDAS PARA USUARIOS (ADMINISTRADORES) ===
// Route::middleware(['auth'])->group(function () {
//     // Cerrar sesión
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//     // Funcionalidades de clientes
//     Route::view('/confirmacion', 'confirmacion')->name('confirmacion');
//     Route::view('/historial', 'historial')->name('historial');
//     Route::view('/catalogo', 'catalogo')->name('catalogo');
//     Route::view('/cambi_contra', 'cambi_contra')->name('cambi_contra');

//     // Rutas de gestión (protegidas)
//     Route::view('/empleado', 'empleado')->name('empleado');
//     Route::view('/clientes', 'clientes')->name('clientes');
//     Route::view('/productos', 'productos')->name('productos');
//     Route::view('/pedidos', 'pedidos')->name('pedidos');
//     Route::view('/reportes', 'reportes')->name('reportes');
// });