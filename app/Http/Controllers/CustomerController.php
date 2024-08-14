<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\enterprise;

class CustomerController extends Controller
{
    /**
     * Mostrar el formulario para crear un nuevo empleado.
     */
    public function create()
    {
        $enterprises = enterprise::all();
        return view('customers', compact('enterprises'));
    }

    /**
     * Almacenar un nuevo empleado en la base de datos.
     */
    public function store(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'number' => 'required|max:45',
        'name' => 'required|max:45',
        'lastname' => 'required|max:45',
        'email' => 'required|email|max:45|unique:customers,email',
        'enterprise_id' => 'required|exists:enterprises,id',
    ]);

    // Crear un nuevo empleado y guardarlo en la base de datos
    $customer = customer::create([
        'number' => $request->input('number'),
        'name' => $request->input('name'),
        'lastname' => $request->input('lastname'),
        'email' => $request->input('email'),
        'enterprise_id' => $request->input('enterprise_id'),
    ]);

    // Redirigir de nuevo al formulario con un mensaje de éxito que incluya el ID
    return redirect()->route('customers.create')->with('success', 'Employee added successfully! Employee ID: ' . $customer->id);
}
public function search(Request $request)
{
    // Validar los campos del formulario
    $request->validate([
        'email' => 'nullable|email',
        'number' => 'nullable|string|max:45',
        'enterprise_id' => 'nullable|exists:enterprises,id',
    ]);

    // Crear una consulta base
    $query = customer::query();

    // Buscar por email si está presente
    if ($request->filled('email')) {
        $query->where('email', $request->input('email'));
    }

    // Buscar por número de empleado si está presente
    if ($request->filled('number')) {
        $query->orWhere('number', $request->input('number'));
    }

    // Buscar por empresa si está presente
    if ($request->filled('enterprise_id')) {
        $query->orWhere('enterprise_id', $request->input('enterprise_id'));
    }

    // Ejecutar la consulta y obtener resultados
    $customers = $query->get();

    if ($customers->isNotEmpty()) {
        // Si se encuentran empleados, mostrarlos en la misma vista
        return view('customers', compact('customers'))->with('enterprises', Enterprise::all());
    } else {
        // Si no se encuentran empleados, redirigir con un mensaje de error
        return redirect()->route('customers.create')->with('error', 'No employees found.');
    }
}

}