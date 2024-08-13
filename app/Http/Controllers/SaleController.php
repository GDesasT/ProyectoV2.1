<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Muestra la lista de ventas
    public function index(Request $request)
    {
        // Obtener los parámetros de búsqueda
        $number = $request->input('number');
        $customer_id = $request->input('customer_id');
        $name = $request->input('name');
        $lastName = $request->input('lastName');
        $date = $request->input('date');
        $dish_type = $request->input('dish_type');

        // Crear una consulta base
        $query = Sale::query();

        // Aplicar los filtros si existen
        if ($number) {
            $query->where('number', $number);
        }

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($lastName) {
            $query->where('lastName', 'like', '%' . $lastName . '%');
        }

        if ($date) {
            $query->whereDate('updated_at', $date);
        }

        if ($dish_type) {
            $query->where('dish_type', $dish_type);
        }

        // Obtener las ventas filtradas
        $sales = $query->get();

        return view('PointOfSale', compact('sales'));
    }

    // Almacena una nueva venta
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'number' => 'required|exists:customers,number',
            'dish_type' => 'required|in:platillo normal,platillo ligero'
        ]);

        // Obtener el cliente basado en su número de trabajador
        $customer = Customer::where('number', $request->number)->firstOrFail();

        // Crear un nuevo registro en la base de datos
        Sale::create([
            'number' => $customer->id, // Asegúrate de que este sea el id de customer
            'customer_id' => $customer->id, // Aquí está el ID correcto
            'name' => $customer->name,
            'lastName' => $customer->lastname,
            'total' => 20, // Valor fijo para el total
            'dish_type' => $request->dish_type
        ]);

        // Redirigir y mostrar mensaje de éxito
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

        return redirect()->route('PointOfSale')->with('success', 'Venta eliminada correctamente.');
    }
}
