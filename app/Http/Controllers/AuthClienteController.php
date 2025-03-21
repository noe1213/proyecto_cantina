<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller; // Ensure the correct Controller class is imported

class AuthClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    // Método para mostrar el formulario de login de clientes
    public function showLoginForm()
    {
        return view('login'); // Vista para el login de clientes
    }

    // Método para manejar el inicio de sesión de clientes
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'password' => 'required', // Cambiado a "password"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (Auth::guard('cliente')->attempt([
            'correo' => $request->correo,
            'password' => $request->password // Clave "password"
        ])) {
            return response()->json(['success' => true, 'redirect' => route('catalogo')]);
        } else {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }
    }

    // Método para cerrar sesión de clientes
    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout(); // Cerrar sesión del guard "cliente"

        // Invalidar la sesión actual
        $request->session()->invalidate();

        // Regenerar el token de sesión
        $request->session()->regenerateToken();

        // Redirigir al usuario a la página de login
        return redirect()->route('login');
    }
}
