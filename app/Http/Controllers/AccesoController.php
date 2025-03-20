<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccesoController extends Controller
{
    public function login(Request $request)
    {
        // Validar las credenciales del formulario
        $credentials = $request->validate([
            'correo' => 'required|email',
            'clave' => 'required',
        ]);

        // Correos específicos para roles
        $adminCorreo = 'freddybarinas.vivas@gmail.com';
        $empleadoCorreo = 'KASHIMYVIVAS2006@GMAIL.COM';

        // Buscar al cliente en la tabla 'clientes'
        $cliente = DB::table('clientes')
            ->where('correo', $credentials['correo'])
            ->first();

        // Validar credenciales y asignar tipo de usuario
        if ($cliente && $credentials['clave'] === $cliente->contrasena) {
            $tipo_usuario = 3; // Por defecto, Cliente
            if ($credentials['correo'] === $adminCorreo) {
                $tipo_usuario = 1; // Admin
            } elseif ($credentials['correo'] === $empleadoCorreo) {
                $tipo_usuario = 2; // Empleado
            }

            // Registrar inicio de sesión en 'acceso'
            DB::table('acceso')->updateOrInsert(
                ['correo' => $cliente->correo], // Condición de búsqueda
                [
                    'correo' => $cliente->correo,
                    'clave' => $credentials['clave'],
                    'tipo_usuario' => $tipo_usuario,
                    'updated_at' => Carbon::now(),
                ]
            );

            // Guardar usuario en sesión
            $request->session()->put('usuario', [
                'ci' => $cliente->ci,
                'correo' => $cliente->correo,
                'nombre' => $cliente->nombre,
                'apellido' => $cliente->apellido,
                'rol' => $tipo_usuario === 1 ? 'admin' : ($tipo_usuario === 2 ? 'empleado' : 'cliente'),
            ]);

            // Redirigir según el rol
            switch ($tipo_usuario) {
                case 1:
                    return redirect()->route('reportes'); // Admin
                case 2:
                    return redirect()->route('empleado'); // Empleado
                case 3:
                    return redirect()->route('catalogo'); // Cliente
                default:
                    return back()->withErrors(['correo' => 'Tipo de usuario no reconocido.']);
            }
        }

        // Si las credenciales no son válidas
        return back()->withErrors(['correo' => 'Las credenciales proporcionadas no son correctas.']);
    }

    public function logout(Request $request)
    {
        // Eliminar datos de sesión
        $request->session()->forget('usuario');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // Redirigir al login
    }
}
