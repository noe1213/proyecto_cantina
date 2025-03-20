<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;

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

// === RUTAS DE VISTAS ===
// Página principal
Route::view('/index', 'index')->name('index');

// Rutas de autenticación
Route::view('/login', 'login')->name('login'); // Página de login
Route::view('/recu', 'recu')->name('recu'); // Recuperación de contraseña
Route::view('/registro', 'registro')->name('registro'); // Registro de usuarios

// Rutas para funcionalidades de clientes
Route::view('/confirmacion', 'confirmacion')->name('confirmacion'); // Confirmar pedidos
Route::view('/historial', 'historial')->name('historial'); // Ver historial de pedidos
Route::view('/catalogo', 'catalogo')->name('catalogo'); // Mostrar catálogo

// Rutas para empleados y clientes
Route::view('/login', 'login')->name('login'); // Página de inicio (logeada)
Route::view('/empleado', 'empleado')->name('empleado'); // Gestión de empleados
Route::view('/clientes', 'clientes')->name('clientes'); // Gestión de clientes

// Rutas para reportes y productos administrados
Route::view('/productos', 'productos')->name('productos'); // Mostrar productos
Route::view('/pedidos', 'pedidos')->name('pedidos'); // Listar pedidos
Route::view('/reportes', 'reportes')->name('reportes'); // Generar o mostrar reportes

// Cambio de contraseña
Route::view('/cambi_contra', 'cambi_contra')->name('cambi_contra'); // Cambiar contraseña
