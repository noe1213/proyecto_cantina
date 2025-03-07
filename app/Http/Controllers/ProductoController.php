<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Método para mostrar todos los productos (GET)
    public function index()
    {
        $productos = Producto::all(); // Obtener todos los productos
        return response()->json($productos); // Retornar como JSON
    }

    // Método para almacenar un nuevo producto (POST)
    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'precio_producto' => 'required|numeric',
            'categoria_producto' => 'required|string|max:255',
            'stock_producto' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'imagen' => 'nullable|string|max:255',
        ]);

        // Crear un nuevo producto
        $producto = new Producto();
        $producto->nombre_producto = $request->nombre_producto;
        $producto->precio_producto = $request->precio_producto;
        $producto->categoria_producto = $request->categoria_producto;
        $producto->stock_producto = $request->stock_producto;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->imagen = $request->imagen_producto;

        $producto->save(); // Guardar el producto

        return response()->json($producto, 201); // Retornar el producto creado
    }

    // Método para actualizar un producto (PUT)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'precio_producto' => 'required|numeric',
            'categoria_producto' => 'required|string|max:255',
            'stock_producto' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'imagen_producto' => 'nullable|string|max:255',
        ]);

        $producto = Producto::findOrFail($id); // Buscar el producto por ID

        // Actualizar los campos
        $producto->nombre_producto = $request->nombre_producto;
        $producto->precio_producto = $request->precio_producto;
        $producto->categoria_producto = $request->categoria_producto;
        $producto->stock_producto = $request->stock_producto;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->imagen = $request->imagen_producto;

        $producto->save(); // Guardar los cambios

        return response()->json($producto); // Retornar el producto actualizado
    }

    // Método para eliminar un producto (DELETE)
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id); // Buscar el producto por ID
        $producto->delete(); // Eliminar el producto

        return response()->json(null, 204); // Retornar respuesta vacía
    }
}
