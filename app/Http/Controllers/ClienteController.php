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
            'ci' => 'required|unique:clientes,ci',
            'correo' => 'required|email|unique:clientes,correo',
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required|digits:11|unique:clientes,telefono',
            'dia_n' => 'required|integer|between:1,31',
            'mes_n' => 'required|integer|between:1,12',
            'anio_n' => 'required|integer|digits:4',
            'municipio' => 'required',
            'parroquia' => 'required',
            'calle' => 'required',
            'contrasena' => 'required',
            'confir_contra' => 'required|same:contrasena',
            'respuesta_secreta' => 'required',
        ];
    
        // Mensajes de error personalizados
        $messages = [
            'ci.required' => 'La cédula es obligatoria.',
            'ci.unique' => 'La cédula ya está registrada.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.unique' => 'El correo electrónico ya está registrado.',
            'correo.email' => 'Debe ingresar un correo válido.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'telefono.required' => 'El número de teléfono es obligatorio.',
            'telefono.unique' => 'El número de teléfono ya está registrado.',
            'telefono.digits' => 'El número de teléfono debe tener 11 dígitos.',
            'dia_n.required' => 'El día de nacimiento es obligatorio.',
            'dia_n.between' => 'El día debe estar entre 1 y 31.',
            'mes_n.required' => 'El mes de nacimiento es obligatorio.',
            'mes_n.between' => 'El mes debe estar entre 1 y 12.',
            'anio_n.required' => 'El año de nacimiento es obligatorio.',
            'anio_n.digits' => 'El año debe tener 4 dígitos.',
            'municipio.required' => 'El municipio es obligatorio.',
            'parroquia.required' => 'La parroquia es obligatoria.',
            'calle.required' => 'La calle es obligatoria.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'confir_contra.required' => 'La confirmación de la contraseña es obligatoria.',
            'confir_contra.same' => 'Las contraseñas no coinciden.',
            'respuesta_secreta.required' => 'La respuesta secreta es obligatoria.',
        ];
    
        // Validar reglas básicas
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Validar fecha específica
        $dia = (int) $request->input('dia_n');
        $mes = (int) $request->input('mes_n');
        $anio = (int) $request->input('anio_n');
    
        // Validar si la fecha es válida
        if (!checkdate($mes, $dia, $anio)) {
            if ($mes < 1 || $mes > 12) {
                return response()->json(['errors' => ['mes de nacimiento' => ['El mes ingresado no es válido. Debe estar entre 1 y 12.']]], 422);
            }
    
            if ($dia < 1 || $dia > 31) {
                return response()->json(['errors' => ['dia de nacimiento' => ['El día ingresado no es válido. Debe estar entre 1 y 31.']]], 422);
            }
    
            if (($mes === 2 && $dia > 29 && ($anio % 4 === 0 && ($anio % 100 !== 0 || $anio % 400 === 0))) || 
                ($mes === 2 && $dia > 28 && !($anio % 4 === 0 && ($anio % 100 !== 0 || $anio % 400 === 0)))) {
                return response()->json(['errors' => ['dia de nacimiento' => ['Febrero solo tiene 28 días en años no bisiestos o 29 en años bisiestos.']]], 422);
            }
    
            return response()->json(['errors' => ['fecha' => ['La fecha ingresada no es válida.']]], 422);
        }
    
        // Crear cliente si todo está válido
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
    public function show($ci)
{
    try {
        // Buscar cliente por cédula
        $cliente = Cliente::where('ci', $ci)->first();

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    } catch (\Exception $e) {
        \Log::error('Error al obtener cliente: ' . $e->getMessage());
        return response()->json(['error' => 'Error inesperado al obtener el cliente.'], 500);
    }
}
public function update(Request $request, $ci)
{
    try {
        // Buscar el cliente por CI
        $cliente = Cliente::where('ci', $ci)->first();

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Validar los datos enviados
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo,' . $cliente->id,
            'telefono' => 'required|digits:11|unique:clientes,telefono,' . $cliente->id,
            'municipio' => 'nullable|string|max:255',
            'parroquia' => 'nullable|string|max:255',
            'calle' => 'nullable|string|max:255',
        ]);

        // Actualizar los datos del cliente
        $cliente->update($validatedData);

        return response()->json(['message' => 'Cliente actualizado correctamente'], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        \Log::error('Error inesperado al actualizar cliente: ' . $e->getMessage());
        return response()->json(['error' => 'Error inesperado en el servidor.'], 500);
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
