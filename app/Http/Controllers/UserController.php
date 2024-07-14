<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
