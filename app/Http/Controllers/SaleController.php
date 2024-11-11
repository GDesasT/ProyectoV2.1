<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['customer.enterprise']);

        if ($request->filled('number')) {
            $customerExists = Customer::where('number', $request->number)->exists();
            if (!$customerExists) {
                return redirect()->route('PointOfSale')->with('error', 'El número de trabajador no está registrado.');
            }
            $query->where('number', $request->number);
        }

        $filters = [
            'enterprise_id' => 'enterprise_id',
            'customer_id' => 'customer_id',
            'name' => 'name',
            'lastName' => 'lastName',
            'dish_type' => 'dish_type',
        ];

        foreach ($filters as $key => $field) {
            if ($request->filled($key)) {
                $query->where($field, $key === 'name' || $key === 'lastName' ? 'like' : '=', $key === 'name' || $key === 'lastName' ? '%' . $request->$key . '%' : $request->$key);
            }
        }

        $query->whereDate('updated_at', $request->filled('date') ? $request->date : now()->toDateString());

        $sales = $query->get();
        $enterprises = Enterprise::all();

        return view('PointOfSale', compact('sales', 'enterprises'));
    }

    public function store(Request $request)
    {
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
