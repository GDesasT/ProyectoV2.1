<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Enterprise;

class CustomerController extends Controller
{
    /**
     * Mostrar el formulario para crear un nuevo empleado.
     */
    public function create()
    {
        $enterprises = Enterprise::all();
        return view('customers', compact('enterprises'));
    }

    /**
     * Almacenar un nuevo empleado en la base de datos.
     */
    public function store(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'name' => 'required|max:45',
        'lastname' => 'required|max:45',
        'email' => 'required|email|max:45|unique:customers,email',
        'enterprise_id' => 'required|exists:enterprises,id',
    ]);

    // Crear un nuevo empleado y guardarlo en la base de datos
    $customer = Customer::create([
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
    // Validar el campo de email
    $request->validate([
        'email' => 'required|email',
    ]);

    // Buscar al empleado por email
    $customer = Customer::where('email', $request->input('email'))->first();

    if ($customer) {
        // Si el empleado es encontrado, mostrarlo en la misma vista
        return view('customers', compact('customer'))->with('enterprises', Enterprise::all());
    } else {
        // Si no se encuentra el empleado, redirigir con un mensaje de error
        return redirect()->route('customers.create')->with('error', 'Employee not found.');
    }
}
public function destroy($id)
{
    $customer = Customer::findOrFail($id);
    $customer->delete();

    return redirect()->route('customers.create')->with('success', 'Employee deleted successfully!');
}

}
