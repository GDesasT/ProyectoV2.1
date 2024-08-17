<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\recipe;
use App\Models\inventory;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index()
    {
        // Obtener todas las recetas para mostrarlas en la vista de paneles
        $recipes = recipe::all();
        return view('recipe', compact('recipes'));
    }

    public function store(Request $request)
    {
        // Validar los datos de la receta
        $request->validate([
            'name' => 'required',
            'difficult' => 'required',
            'ingredient_name' => 'required|array',
            'ingredient_name.*' => 'required|string',
            'ingredient_quantity' => 'required|array',
            'ingredient_quantity.*' => 'required|numeric',
            'ingredient_unit' => 'required|array',
            'ingredient_unit.*' => 'required|string',
            'description' => 'required',
            'image' => 'required|url',
            'timeset' => 'required',
            'shortdesc' => 'required',
        ]);

        // Procesar los ingredientes
        $ingredients = [];
        foreach ($request->ingredient_name as $index => $name) {
            $ingredients[] = [
                'name' => $name,
                'quantity' => $request->ingredient_quantity[$index],
                'unit' => $request->ingredient_unit[$index],
            ];
        }

        // Verificar si es una edición o una nueva creación
        if ($request->filled('recipeId')) {
            // Edición
            $recipe = recipe::findOrFail($request->recipeId);
            $recipe->update([
                'name' => $request->name,
                'difficult' => $request->difficult,
                'description' => $request->description,
                'image' => $request->image,
                'timeset' => $request->timeset,
                'shortdesc' => $request->shortdesc,
                'ingredient' => json_encode($ingredients),
            ]);

            return redirect()->route('recipes.index')->with('success', 'Receta actualizada exitosamente.');
        } else {
            // Creación
            recipe::create([
                'name' => $request->name,
                'difficult' => $request->difficult,
                'description' => $request->description,
                'image' => $request->image,
                'timeset' => $request->timeset,
                'shortdesc' => $request->shortdesc,
                'ingredient' => json_encode($ingredients),
            ]);

            return redirect()->route('recipes.index')->with('success', 'Receta creada exitosamente.');
        }
    }

    public function show($id)
    {
        // Obtener la receta por ID
        $recipe = recipe::findOrFail($id);

        // Obtener los ingredientes del inventario
        $ingredients = json_decode($recipe->ingredient, true);
        $inventory = inventory::whereIn('name', array_column($ingredients, 'name'))->get()->keyBy('name');

        // Calcular cuánto falta
        foreach ($ingredients as &$ingredient) {
            $available = $inventory[$ingredient['name']]->amount ?? 0;
            $ingredient['available'] = $available;
            $ingredient['missing'] = $ingredient['quantity'] > $available ? $ingredient['quantity'] - $available : 0;
        }

        // Retornar los datos como JSON
        return response()->json([
            'recipe' => $recipe,
            'ingredients' => $ingredients,
        ]);
    }

    public function update(Request $request, recipe $recipe)
    {
        // Validar los datos de la receta
        $request->validate([
            'name' => 'required',
            'difficult' => 'required',
            'ingredient_name' => 'required|array',
            'ingredient_name.*' => 'required|string',
            'ingredient_quantity' => 'required|array',
            'ingredient_quantity.*' => 'required|numeric',
            'ingredient_unit' => 'required|array',
            'ingredient_unit.*' => 'required|string',
            'description' => 'required',
            'image' => 'required|url',
            'timeset' => 'required',
            'shortdesc' => 'required',
        ]);

        // Procesar los ingredientes
        $ingredients = [];
        foreach ($request->ingredient_name as $index => $name) {
            $ingredients[] = [
                'name' => $name,
                'quantity' => $request->ingredient_quantity[$index],
                'unit' => $request->ingredient_unit[$index],
            ];
        }

        // Actualizar la receta
        $recipe->update([
            'name' => $request->name,
            'difficult' => $request->difficult,
            'description' => $request->description,
            'image' => $request->image,
            'timeset' => $request->timeset,
            'shortdesc' => $request->shortdesc,
            'ingredient' => json_encode($ingredients),
        ]);

        return redirect()->route('recipes.index')->with('success', 'Receta actualizada exitosamente.');
    }

    public function destroy(recipe $recipe)
    {
        // Eliminar la receta
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Receta eliminada exitosamente.');
    }

    public function calculateIngredients(Request $request)
    {
        $recipe = recipe::findOrFail($request->id);
        $quantity = $request->input('quantity', 1); // Tomar la cantidad de platillos

        // Decodificar los ingredientes almacenados en JSON
        $ingredients = json_decode($recipe->ingredient, true);

        // Multiplicar la cantidad de cada ingrediente por la cantidad de platillos
        $calculatedIngredients = array_map(function ($ingredient) use ($quantity) {
            return [
                'name' => $ingredient['name'],
                'quantity' => $ingredient['quantity'] * $quantity,
                'unit' => $ingredient['unit'],
            ];
        }, $ingredients);

        // Devolver los ingredientes calculados como JSON
        return response()->json($calculatedIngredients);
    }

    public function elaborate(Request $request, $id)
{
    dd($request->all());

    $recipe = recipe::findOrFail($id);
    $multiplier = $request->input('multiplier', 1);

    // Decodificar los ingredientes almacenados en JSON
    $ingredients = json_decode($recipe->ingredient, true);

    DB::beginTransaction();

    try {
        // Verificar si hay suficientes ingredientes
        foreach ($ingredients as $ingredient) {
            $requiredAmount = $ingredient['quantity'] * $multiplier;
            $inventoryItem = inventory::where('name', $ingredient['name'])->first();

            if (!$inventoryItem || $inventoryItem->amount < $requiredAmount) {
                throw new \Exception("No hay suficientes ingredientes: {$ingredient['name']}");
            }
        }

        // Restar la cantidad utilizada del inventario
        foreach ($ingredients as $ingredient) {
            $requiredAmount = $ingredient['quantity'] * $multiplier;
            $inventoryItem = inventory::where('name', $ingredient['name'])->first();

            // Debugging: Asegúrate de que la operación se ejecuta
            if ($inventoryItem) {
                $inventoryItem->amount -= $requiredAmount;
                $inventoryItem->save();
            }
        }

        DB::commit();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);
    }
}

}
