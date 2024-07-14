<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('user', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/inventory'); // Redirige al área de inventario
        }

        return back()->withErrors([
            'message' => 'Credenciales incorrectas. Por favor, intenta de nuevo.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
