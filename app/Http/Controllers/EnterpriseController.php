<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enterprise;

class EnterpriseController extends Controller
{
    /**
     * Mostrar el formulario para crear una nueva empresa.
     */
    public function create()
    {
        return view('enterprise'); // Asegúrate de que la vista esté correctamente ubicada
    }

    /**
     * Almacenar una nueva empresa en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|max:45',
            'email' => 'required|max:45',
            'phone' => 'required|max:45',
            'address' => 'required',
        ]);

        // Crear una nueva empresa y guardarla en la base de datos
        Enterprise::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        // Redirigir de nuevo al formulario con un mensaje de éxito
        return redirect()->route('enterprises.create')->with('success', 'La empresa se Añadio Correctamente!');
    }
}
