<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Events\StockBajoEvent;

class ProductoController extends Controller
{
    // Obtener todos los productos (GET)
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->has('categoria')) {
            $query->where('categoria_producto', $request->categoria);
        }

        $productos = $query->get();

        return response()->json($productos, 200);
    }

    // Almacenar un nuevo producto (POST)
    public function store(Request $request)
    {
        // Mensajes de error personalizados
        $messages = [
            'nombre_producto' => 'El producto debe ser unico',
            'nombre_producto.required' => 'El nombre del producto es obligatorio.',
            'precio_producto.required' => 'El precio del producto es obligatorio.',
            'precio_producto.numeric' => 'El precio debe ser un número válido.',
            'categoria_producto.required' => 'La categoría del producto es obligatoria.',
            'stock_producto.required' => 'El stock es obligatorio.',
            'stock_producto.integer' => 'El stock debe ser un número entero.',
            'stock_minimo.required' => 'El stock mínimo es obligatorio.',
            'stock_minimo.integer' => 'El stock mínimo debe ser un número entero.',
            'stock_minimo.lt' => 'El stock mínimo debe ser menor al stock.',
            'imagen_producto.image' => 'El archivo debe ser una imagen.',
            'imagen_producto.mimes' => 'La imagen debe ser de tipo: jpg, jpeg o png.',
            'imagen_producto.max' => 'La imagen no debe exceder los 2MB.',
        ];

        try {
            $request->validate([
                'nombre_producto' => 'required|unique:productos|string|max:255',
                'precio_producto' => 'required|numeric',
                'categoria_producto' => 'required|string|max:255',
                'stock_producto' => 'required|integer',
                'stock_minimo' => 'required|integer|lt:stock_producto',
                'imagen_producto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ], $messages);

            // Subir la imagen (si existe)
            $rutaImagen = null;
            if ($request->hasFile('imagen_producto')) {
                $rutaImagen = $request->file('imagen_producto')->store('imagenes_productos', 'public');
            }

            // Crear producto
            $producto = Producto::create([
                'nombre_producto' => $request->nombre_producto,
                'precio_producto' => $request->precio_producto,
                'categoria_producto' => $request->categoria_producto,
                'stock_producto' => $request->stock_producto,
                'stock_minimo' => $request->stock_minimo,
                'imagen' => $rutaImagen,
            ]);

            return response()->json($producto, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error inesperado: ' . $e->getMessage()], 500);
        }
    }
    public function obtenerStockBajo()
    {
        $productosBajosStock = Producto::whereColumn('stock_producto', '<', 'stock_minimo')
            ->select('id_producto', 'nombre_producto', 'stock_producto', 'stock_minimo')
            ->get();

        // Filtrar productos que no tengan nombre
        $productosValidos = $productosBajosStock->filter(function ($producto) {
            return !empty($producto->nombre_producto); // Solo incluye productos con nombre
        });

        return response()->json($productosValidos, 200);
    }






    // Obtener un producto específico (GET)
    public function show($id_producto)
    {
        $producto = Producto::find($id_producto);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    // Actualizar un producto (PUT)
    public function update(Request $request, $id_producto)
    {
        $messages = [
            'nombre_producto.required' => 'El nombre del producto es obligatorio.',
            'precio_producto.required' => 'El precio del producto es obligatorio.',
            'precio_producto.numeric' => 'El precio debe ser un número válido.',
            'categoria_producto.required' => 'La categoría del producto es obligatoria.',
            'stock_producto.required' => 'El stock es obligatorio.',
            'stock_producto.integer' => 'El stock debe ser un número entero.',
            'stock_minimo.required' => 'El stock mínimo es obligatorio.',
            'stock_minimo.integer' => 'El stock mínimo debe ser un número entero.',
            'stock_minimo.lt' => 'El stock mínimo debe ser menor al stock.',
            'imagen_producto.image' => 'El archivo debe ser una imagen.',
            'imagen_producto.mimes' => 'La imagen debe ser de tipo: jpg, jpeg o png.',
            'imagen_producto.max' => 'La imagen no debe exceder los 2MB.',
        ];

        try {
            $producto = Producto::find($id_producto);

            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            $request->validate([
                'nombre_producto' => 'required|string|max:255',
                'precio_producto' => 'required|numeric',
                'categoria_producto' => 'required|string|max:255',
                'stock_producto' => 'required|integer',

                'imagen_producto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ], $messages);

            // Actualizar imagen si es necesario
            if ($request->hasFile('imagen_producto')) {
                if ($producto->imagen) {
                    Storage::disk('public')->delete($producto->imagen);
                }

                $producto->imagen = $request->file('imagen_producto')->store('imagenes_productos', 'public');
            }

            // Actualizar datos del producto
            $producto->update([
                'nombre_producto' => $request->nombre_producto,
                'precio_producto' => $request->precio_producto,
                'categoria_producto' => $request->categoria_producto,
                'stock_producto' => $request->stock_producto,
                'stock_minimo' => $request->stock_minimo,
                'imagen' => $producto->imagen,
            ]);

            return response()->json($producto, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error inesperado: ' . $e->getMessage()], 500);
        }
    }

    // Eliminar un producto (DELETE)
    public function destroy($id_producto)
    {
        try {
            $producto = Producto::find($id_producto);

            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            // Eliminar imagen si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $producto->delete();

            return response()->json(['message' => 'Producto eliminado correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error inesperado: ' . $e->getMessage()], 500);
        }
    }
    public function obtenerProductosPorCategoria()
    {
        $productos = Producto::select('id_producto', 'nombre_producto', 'precio_producto', 'categoria_producto', 'imagen', 'stock_producto', 'stock_minimo')->get();
        \Log::info('JSON final: ', ['productos' => $productos]);


        // foreach ($productos as $producto) {
        //     if ($producto->imagen) {
        //         // Convierte la ruta relativa en una URL completa
        //         $producto->imagen = asset('storage/' . $producto->imagen);
        //     } else {
        //         // Imagen predeterminada
        //         $producto->imagen = asset('storage/imagenes/default.png');
        //     }
        // }

        return response()->json($productos, 200);
    }
}
