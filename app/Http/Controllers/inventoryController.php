<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/inventory",
     *     summary="Obtener la lista de inventario",
     *     tags={"Inventario"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos del inventario"
     *     )
     * )
     */
    public function index()
    {
        $inventories = Inventory::all();
        return view('inventory', compact('inventories'));
    }

    /**
     * @OA\Post(
     *     path="/inventory",
     *     summary="Crear un nuevo producto",
     *     tags={"Inventario"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "amount", "type", "unit"},
     *             @OA\Property(property="name", type="string", example="Manzana"),
     *             @OA\Property(property="amount", type="number", example=10),
     *             @OA\Property(property="type", type="string", example="Fruta"),
     *             @OA\Property(property="unit", type="string", example="Kg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado exitosamente"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        Inventory::create($request->all());
        return redirect()->route('inventory.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * @OA\Put(
     *     path="/inventory/{id}",
     *     summary="Actualizar un producto",
     *     tags={"Inventario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "amount", "type", "unit"},
     *             @OA\Property(property="name", type="string", example="Manzana"),
     *             @OA\Property(property="amount", type="number", example=20),
     *             @OA\Property(property="type", type="string", example="Fruta"),
     *             @OA\Property(property="unit", type="string", example="Kg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado correctamente"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());
        return redirect()->route('inventory.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * @OA\Delete(
     *     path="/inventory/{id}",
     *     summary="Eliminar un producto",
     *     tags={"Inventario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto eliminado correctamente"
     *     )
     * )
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Producto eliminado correctamente.');
    }
}
