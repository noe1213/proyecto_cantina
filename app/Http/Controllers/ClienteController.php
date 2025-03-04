<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los clientes
        $clientes = Cliente::all(); // Obtener todos los clientes
        return response()->json($clientes); // Retornar como JSON
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lógica para mostrar el formulario de creación (si es necesario)
    }

    /**
     * Store a newly created resource in storage.
     */
    
  
         public function store(Request $request)
         {
             $validator = Validator::make($request->all(), [
                 'ci' => [
                     'required',
                     'digits:8',
                     'unique:clientes',
                     Rule::unique('clientes', 'ci')->message('La cédula ya está registrada'),
                 ],
                 'correo' => [
                     'required',
                     'email',
                     'unique:clientes',
                     Rule::unique('clientes', 'correo')->message('El correo electrónico ya está registrado'),
                 ],
                 'nombre' => 'required',
                 'apellido' => 'required',
                 'telefono' => [
                     'required',
                     'digits:11',
                     'unique:clientes',
                     Rule::unique('clientes', 'telefono')->message('El número de teléfono ya está registrado'),
                 ],
                 'dia_n' => 'required|between:1,31',
                 'mes_n' => 'required|between:1,12',
                 'anio_n' => 'required|between:1900,2100',
                 'municipio' => 'required|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
                 'parroquia' => 'required',
                 'calle' => 'required',
                 'contrasena' => 'required',
                 'confir_contra' => 'required|same:contrasena',
                 'respuesta_secreta' => 'required',
             ]);
     
             if ($validator->fails()) {
                 return response()->json(['errors' => $validator->errors()], 422);
             }
     
             // Validación manual para el día del mes
             $dia_n = $request->input('dia_n');
             $mes_n = $request->input('mes_n');
             $anio_n = $request->input('anio_n');
     
             $maxDias = date('t', mktime(0, 0, 0, $mes_n, 1, $anio_n));
     
             if ($dia_n > $maxDias) {
                 return response()->json(['message' => 'El día no es válido para el mes seleccionado'], 422);
             }
     
             // Crear cliente
             try {
                 $cliente = Cliente::create([
                     'ci' => $request->input('ci'),
                     'correo' => $request->input('correo'),
                     'nombre' => $request->input('nombre'),
                     'apellido' => $request->input('apellido'),
                     'telefono' => $request->input('telefono'),
                     'contrasena' => Hash::make($request->input('contrasena')),
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
                 return response()->json(['message' => 'Error al registrar el cliente'], 500);
             }
         }
     
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        // Lógica para mostrar el formulario de edición (si es necesario)
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Lógica para actualizar un cliente específico (si es necesario)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Eliminar el cliente
        $cliente->delete();
        return response()->json(null, 204); // Retornar respuesta vacía
    }
}
