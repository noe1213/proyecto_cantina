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
            'imagen_producto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validar la imagen
        ]);

        // Subir la imagen y obtener la ruta
        $rutaImagen = null;
        if ($request->hasFile('imagen_producto')) {
            $rutaImagen = $request->file('imagen_producto')->store('imagenes_productos', 'public'); // Guardar en storage
        }

        // Crear el producto
        $producto = Producto::create([
            'nombre_producto' => $request->nombre_producto,
            'precio_producto' => $request->precio_producto,
            'categoria_producto' => $request->categoria_producto,
            'stock_producto' => $request->stock_producto,
            'stock_minimo' => $request->stock_minimo,
            'imagen' => $rutaImagen, // Guardar la ruta de la imagen
        ]);

        return response()->json($producto, 201); // Retornar el producto creado
    }


    // Método para actualizar un producto (PUT)
    public function update(Request $request, $id_producto)
    {
        
    }
    // Método para eliminar un producto (DELETE)
    public function destroy($id_producto)
{
    $producto = Producto::where('id_producto', $id_producto)->firstOrFail();
    $producto->delete();
    return response()->json(['message' => 'Producto eliminado correctamente.'], 204);
}
public function show($id_producto)
{
    $producto = Producto::find($id_producto); // Buscar producto por ID

    if (!$producto) {
        return response()->json(['error' => 'Producto no encontrado'], 404); // Error 404
    }

    return response()->json($producto); // Retornar producto
}


   
    
}
