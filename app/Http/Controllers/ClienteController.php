<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Reglas de validación
        $rules = [
            'ci' => 'required|digits:8|unique:clientes,ci',
            'correo' => 'required|email|unique:clientes,correo',
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required|digits:11|unique:clientes,telefono',
            'dia_n' => 'required|between:1,31',
            'mes_n' => 'required|between:1,12',
            'anio_n' => 'required|digits:4',
            'municipio' => 'required',
            'parroquia' => 'required',
            'calle' => 'required',
            'contrasena' => 'required',
            'confir_contra' => 'required|same:contrasena',
            'respuesta_secreta' => 'required',
        ];

        // Mensajes de error personalizados
        $messages = [
            'ci.unique' => 'La cédula ya está registrada',
            'correo.unique' => 'El correo electrónico ya está registrado',
            'telefono.unique' => 'El número de teléfono ya está registrado',
        ];

        // Validar los datos
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear cliente
        try {
            $cliente = Cliente::create([
                'ci' => $request->input('ci'),
                'correo' => $request->input('correo'),
                'nombre' => $request->input('nombre'),
                'apellido' => $request->input('apellido'),
                'telefono' => $request->input('telefono'),
                'contrasena' => $request->input('contrasena'),
                'confir_contra' => $request->input('confir_contra'),
                'respuesta_secreta' => $request->input('respuesta_secreta'),
                'dia_n' => $request->input('dia_n'),
                'mes_n' => $request->input('mes_n'),
                'anio_n' => $request->input('anio_n'),
                'municipio' => $request->input('municipio'),
                'parroquia' => $request->input('parroquia'),
                'calle' => $request->input('calle'),
            ]);

            return response()->json(['message' => 'Cliente registrado exitosamente'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al registrar el cliente: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(null, 204);
    }
}