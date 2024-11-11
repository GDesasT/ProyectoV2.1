<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API de Inventario y Recetas",
 *     version="1.0.0",
 *     description="Esta es la documentación de la API para gestionar inventarios y recetas.",
 *     @OA\Contact(
 *         email="soporte@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor local de desarrollo"
 * )
 * 
 * @OA\Schema(
 *     schema="Inventory",
 *     type="object",
 *     required={"name", "amount", "type", "unit"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID del inventario"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del producto"
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="number",
 *         description="Cantidad disponible del producto"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Categoría del producto (e.g., Verdura, Fruta)"
 *     ),
 *     @OA\Property(
 *         property="unit",
 *         type="string",
 *         description="Unidad de medida (e.g., Kg, L, Pz)"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación del registro"
 *     )
 * )
 */

class InventoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/inventory",
     *     summary="Obtener la lista de inventario con filtros",
     *     description="Obtiene todos los productos en el inventario, con posibilidad de aplicar filtros.",
     *     tags={"Inventario"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         description="Filtrar por nombre del producto",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         required=false,
     *         description="Filtrar por cantidad del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         description="Filtrar por tipo de producto",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="unit",
     *         in="query",
     *         required=false,
     *         description="Filtrar por unidad de medida",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         required=false,
     *         description="Filtrar por fecha de actualización (YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de inventario filtrada",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Inventory"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $amount = $request->input('amount');
        $type = $request->input('type');
        $unit = $request->input('unit');
        $date = $request->input('date');

        $query = Inventory::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($amount) {
            $query->where('amount', $amount);
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($unit) {
            $query->where('unit', $unit);
        }

        if ($date) {
            $query->whereDate('updated_at', $date);
        }

        $inventories = $query->get();
        return view('inventory', compact('inventories'));
    }

    /**
     * @OA\Post(
     *     path="/inventory",
     *     summary="Agregar un nuevo producto al inventario",
     *     description="Crea un nuevo producto o actualiza la cantidad si ya existe.",
     *     tags={"Inventario"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "amount", "type", "unit"},
     *             @OA\Property(property="name", type="string", example="Tomate"),
     *             @OA\Property(property="amount", type="number", example="10"),
     *             @OA\Property(property="type", type="string", example="Verdura"),
     *             @OA\Property(property="unit", type="string", example="Kg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto agregado o cantidad actualizada",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Cantidad agregada exitosamente al producto existente.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Verdura,Fruta,Proteina,Cereales y Legumbres,Lacteo,Embutido,Especia',
            'unit' => 'required|in:Kg,L,Pz',
        ]);

        $request->merge([
            'name' => ucwords(strtolower($request->input('name'))),
            'type' => ucwords(strtolower($request->input('type')))
        ]);

        $existingProduct = Inventory::where('name', $request->name)
            ->where('type', $request->type)
            ->where('unit', $request->unit)
            ->first();

        if ($existingProduct) {
            $existingProduct->amount += $request->amount;
            $existingProduct->save();
            return redirect()->route('inventory')->with('status', 'Cantidad agregada exitosamente al producto existente.');
        } else {
            Inventory::create($request->all());
            return redirect()->route('inventory')->with('status', 'Producto agregado exitosamente.');
        }
    }

    /**
     * @OA\Put(
     *     path="/inventory/{id}",
     *     summary="Actualizar un producto del inventario",
     *     tags={"Inventario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "amount", "type", "unit"},
     *             @OA\Property(property="name", type="string", example="Tomate"),
     *             @OA\Property(property="amount", type="number", example="15"),
     *             @OA\Property(property="type", type="string", example="Verdura"),
     *             @OA\Property(property="unit", type="string", example="Kg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Producto actualizado correctamente.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->name = ucwords(strtolower($request->input('name')));
        $inventory->amount = $request->input('quantity');
        $inventory->unit = $request->input('unit');
        $inventory->type = ucwords(strtolower($request->input('type')));
        $inventory->save();

        return redirect()->route('inventory')->with('status', 'Producto actualizado correctamente');
    }

    /**
     * @OA\Delete(
     *     path="/inventory/{id}",
     *     summary="Eliminar un producto del inventario",
     *     tags={"Inventario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="delete", type="string", example="Producto eliminado correctamente.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory')->with('delete', 'Producto eliminado correctamente.');
    }
}