<?php


namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of all the resources.
     */
    public function index(Request $request)
    {
        // Obtener el estado del pedido desde la solicitud, por defecto es null
        $estado = $request->input('estado');

        // Obtener todos los pedidos con el estado especificado y sus productos
        if ($estado !== null) {
            $pedidos = Pedido::with('productos')->where('estado_pedido', $estado)->get(); // Filtrar por estado
        } else {
            $pedidos = Pedido::with('productos')->get(); // Obtener todos los pedidos si no se proporciona estado
        }

        return response()->json($pedidos); // Retornar como JSON
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener un pedido específico con sus productos
        $pedido = Pedido::with('productos')->findOrFail($id); // Cargar los productos relacionados

        // Si solo deseas un producto, puedes seleccionar el primero
        if ($pedido->productos->isNotEmpty()) {
            $pedido->productos = $pedido->productos->take(1); // Tomar solo el primer producto
        }

        return response()->json($pedido); // Retornar como JSON
    }

    /**
     * Mark the specified resource as in progress.
     */
    public function markAsInProgress($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->estado_pedido = 1; // Cambiar el estado a "en proceso" (ajusta según tu lógica)
        $pedido->save();

        return response()->json(['message' => 'Pedido marcado como en proceso.']);
    }

    public function markAsStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|integer|in:0,1,2' // Asegúrate de que el estado sea 0, 1 o 2
        ]);

        $pedido = Pedido::findOrFail($id);
        $estado = $request->input('estado');

        // Cambiar el estado del pedido según el valor recibido
        $pedido->estado_pedido = (int) $estado;
        $pedido->save();

        return response()->json(['message' => 'Pedido actualizado correctamente.']);
    }
}
