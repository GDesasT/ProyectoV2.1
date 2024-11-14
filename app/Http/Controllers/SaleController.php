<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
{   $query = Sale::with(['customer.enterprise']);

    // Validar el número de trabajador y aplicar filtro si es válido
    if ($request->filled('number')) {
        if (!Customer::where('number', $request->number)->exists()) {
            return redirect()->route('PointOfSale')->with('error', 'El número de trabajador no está registrado.');
        }
        $query->where('number', $request->number);
    }

    // Aplicar filtros simples
    $query->when($request->filled('enterprise_id'), function ($q) use ($request) {
        $q->where('enterprise_id', $request->enterprise_id);
    });

    $query->when($request->filled('customer_id'), function ($q) use ($request) {
        $q->where('customer_id', $request->customer_id);
    });

    $query->when($request->filled('name'), function ($q) use ($request) {
        $q->where('name', 'like', '%' . $request->name . '%');
    });

    $query->when($request->filled('lastName'), function ($q) use ($request) {
        $q->where('lastName', 'like', '%' . $request->lastName . '%');
    });

    // Filtro de fecha
    $query->whereDate('updated_at', $request->filled('date') ? $request->date : now()->toDateString());

    $query->when($request->filled('dish_type'), function ($q) use ($request) {
        $q->where('dish_type', $request->dish_type);
    });

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

        $enterpriseId = session('enterprise_id');
        if (!$enterpriseId) {
            return redirect()->route('PointOfSale')->with('error', 'Por favor, selecciona una empresa antes de realizar la venta.');
        }

        $customer = Customer::where('number', $request->number)->where('enterprise_id', $enterpriseId)->first();
        if (!$customer) {
            return redirect()->route('PointOfSale')->with('error', 'El número de trabajador no está registrado en esta empresa.');
        }

        $existingSale = Sale::where('customer_id', $customer->id)
                            ->where('enterprise_id', $enterpriseId)
                            ->whereDate('created_at', now()->format('Y-m-d'))
                            ->exists();

        if ($existingSale) {
            return redirect()->route('PointOfSale')->with('error', 'Este cliente ya ha comprado un platillo hoy en esta empresa.');
        }

        Sale::create([
            'number' => $customer->id,
            'customer_id' => $customer->id,
            'name' => $customer->name,
            'lastName' => $customer->lastname,
            'total' => 50,
            'dish_type' => $request->dish_type,
            'enterprise_id' => $enterpriseId,
        ]);

        return redirect()->route('PointOfSale')->with('success', 'Venta agregada exitosamente.');
    }

    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.edit', compact('sale'));
    }

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

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('PointOfSale')->with('delete', 'Venta eliminada correctamente.');
    }

    public function setEnterprise(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
        ]);

        session(['enterprise_id' => $request->enterprise_id]);

        return redirect()->route('PointOfSale')->with('success', 'Empresa seleccionada correctamente.');
    }
}
