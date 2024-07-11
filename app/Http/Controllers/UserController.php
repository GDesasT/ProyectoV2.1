<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loggin(Request $request){
        $credentials = $request->only('user', 'password');

        if (Auth::attempt($credentials)){
            return redirect()->intended('');
        }

        return back()->withErrors([
            'user' => 'Las credenciales estan incorrectas.',
        ]); 
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }

    public function register(Request $request){
        $user = user::create([
            'user' => $request->user,
            'password' => Hash::make($request->password),
        ]);

        return redirect('login');
    }
}
