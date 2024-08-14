<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Enterprise;
use Illuminate\Database\QueryException;

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
        // Validar los datos del formulario asegurando la unicidad del 'number' dentro de la misma empresa
        $request->validate([
            'number' => 'required|max:45',
            'name' => 'required|max:45',
            'lastname' => 'required|max:45',
            'email' => 'required|email|max:45|unique:customers,email',
            'enterprise_id' => 'required|exists:enterprises,id',
        ]);

        try {
            // Intentar crear un nuevo empleado y guardarlo en la base de datos
            $customer = Customer::create([
                'number' => $request->input('number'),
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'enterprise_id' => $request->input('enterprise_id'),
            ]);

            // Redirigir de nuevo al formulario con un mensaje de éxito que incluya el ID
            return redirect()->route('customers.create')->with('success', 'Employee added successfully! Employee ID: ' . $customer->id);
        } catch (QueryException $exception) {
            // Capturar la excepción de violación de clave única
            if ($exception->getCode() === '23000') {
                // Mensaje de error para duplicados
                return redirect()->route('customers.create')->with('error', 'El número de empleado ya existe en esta empresa.');
            }

            // En caso de otra excepción, mostrar un mensaje genérico
            return redirect()->route('customers.create')->with('error', 'Ocurrió un error al agregar el empleado.');
        }
    }

    /**
     * Buscar empleados por email, número o empresa.
     */
    public function search(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'email' => 'nullable|email',
            'number' => 'nullable|string|max:45',
            'enterprise_id' => 'nullable|exists:enterprises,id',
        ]);

        // Crear una consulta base
        $query = Customer::query();

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

    /**
     * Eliminar un empleado de la base de datos.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.create')->with('success', 'Employee deleted successfully!');
    }
}
