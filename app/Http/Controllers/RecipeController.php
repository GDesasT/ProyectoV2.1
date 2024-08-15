<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Inventory;

class RecipeController extends Controller
{
    public function index()
    {
        // Obtener todas las recetas para mostrarlas en la vista de paneles
        $recipes = Recipe::all();
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
            $recipe = Recipe::findOrFail($request->recipeId);
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
            Recipe::create([
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
        $recipe = Recipe::findOrFail($id);

        // Obtener los ingredientes del inventario
        $ingredients = json_decode($recipe->ingredient, true);
        $inventory = Inventory::whereIn('name', array_column($ingredients, 'name'))->get()->keyBy('name');

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




    public function update(Request $request, Recipe $recipe)
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

    public function destroy(Recipe $recipe)
    {
        // Eliminar la receta
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Receta eliminada exitosamente.');
    }

    public function calculateIngredients(Request $request)
    {
        $recipe = Recipe::findOrFail($request->id);
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
}
