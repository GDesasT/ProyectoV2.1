<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/login",
     *     summary="Mostrar el formulario de inicio de sesión",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Formulario de inicio de sesión"
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirige al inventario si ya está autenticado"
     *     )
     * )
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/inventory');
        }
    
        return view('login');
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Iniciar sesión en la aplicación",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user", "password"},
     *             @OA\Property(property="user", type="string", example="usuario123"),
     *             @OA\Property(property="password", type="string", format="password", example="contraseña")
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirige al inventario tras iniciar sesión exitosamente"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas"
     *     )
     * )
     */
    public function login(Request $request) : RedirectResponse
    {
        $credentials = $request->only('user', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/inventory');
        }

        return back()->withErrors([
            'message' => 'Credenciales incorrectas. Por favor, intenta de nuevo.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/logout",
     *     summary="Cerrar sesión de la aplicación",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=302,
     *         description="Redirige al formulario de inicio de sesión tras cerrar sesión"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}