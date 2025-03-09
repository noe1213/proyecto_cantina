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
            'ci.digits' => 'La cédula debe tener 8 dígitos.',
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
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(null, 204);
    }
}
