<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Muestra la lista de ventas
    public function index(Request $request)
    {
        // Mostrar todos los datos enviados en la solicitud
        $query = sale::with(['customer.enterprise']);
    
        // Validación del número de trabajador
        if ($request->filled('number')) {
            $employeeExists = customer::where('number', $request->number)->exists();
    
            if (!$employeeExists) {
                return redirect()->route('PointOfSale')->with('error', 'El número de trabajador no está registrado.');
            }
    
            $query->where('number', $request->number);
        }
    
        // Otros filtros
        if ($request->filled('enterprise_id')) {
            $query->where('enterprise_id', $request->enterprise_id);
        }
    
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
    
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->filled('lastName')) {
            $query->where('lastName', 'like', '%' . $request->lastName . '%');
        }
    
        if ($request->filled('date')) {
        $query->whereDate('updated_at', $request->date);
    } else {
        $query->whereDate('updated_at', now()->toDateString());
    }
    
        if ($request->filled('dish_type')) {
            $query->where('dish_type', $request->dish_type);
        }
    
        $sales = $query->get();
        $enterprises = enterprise::all();
    
        return view('PointOfSale', compact('sales', 'enterprises'));
    }



    // Almacena una nueva venta
    public function store(Request $request)
    {
        // Validación inicial de los campos enviados en el formulario
        $request->validate([
            'number' => 'required',
            'dish_type' => 'required|in:platillo normal,platillo ligero',
        ]);

        // Obtener la empresa de la sesión
        $enterpriseId = session('enterprise_id');

        // Si no hay empresa en la sesión, redirigir con error
        if (!$enterpriseId) {
            return redirect()->route('PointOfSale')->with('error', 'Por favor, selecciona una empresa antes de realizar la venta.');
        }

        // Verificar si el número de trabajador existe en la empresa seleccionada
        $customer = Customer::where('number', $request->number)
                            ->where('enterprise_id', $enterpriseId)
                            ->first();

        // Si el número no existe en la empresa seleccionada, redirige con un error
        if (!$customer) {
            return redirect()->route('PointOfSale')->with('error', 'El número de trabajador no está registrado en esta empresa.');
        }

        // Verificar si el cliente ya ha realizado una compra en el día en la misma empresa
        $existingSale = Sale::where('customer_id', $customer->id)
            ->where('enterprise_id', $enterpriseId)
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->first();

        if ($existingSale) {
            return redirect()->route('PointOfSale')->with('error', 'Este cliente ya ha comprado un platillo hoy en esta empresa.');
        }

        // Si todo es válido, crear la venta
        Sale::create([
            'number' => $customer->id,
            'customer_id' => $customer->id,
            'name' => $customer->name,
            'lastName' => $customer->lastname,
            'total' => 50, // Se mantiene fijo el total como indicaste
            'dish_type' => $request->dish_type,
            'enterprise_id' => $enterpriseId, // Utilizar la empresa de la sesión
        ]);

        // Redirigir con éxito
        return redirect()->route('PointOfSale')->with('success', 'Venta agregada exitosamente.');
    }

    // Muestra el formulario para editar una venta existente
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.edit', compact('sale'));
    }

    // Actualiza una venta existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:45',
            'lastName' => 'required|string|max:45',
            'total' => 'required|numeric|min:0',
            'dish_type' => 'required|in:platillo normal,platillo ligero',
            'enterprise_id' => 'required|exists:enterprises,id'
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update($request->all());

        return redirect()->route('sales.index')->with('success', 'Venta actualizada correctamente.');
    }

    // Elimina una venta existente
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('PointOfSale')->with('delete', 'Venta eliminada correctamente.');
    }

    // Establece la empresa seleccionada en la sesión
    public function setEnterprise(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
        ]);

        session(['enterprise_id' => $request->enterprise_id]);

        return redirect()->route('PointOfSale')->with('success', 'Empresa seleccionada correctamente.');
    }
}
