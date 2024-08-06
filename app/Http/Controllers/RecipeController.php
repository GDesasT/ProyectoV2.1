<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Inventory;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        $inventories = Inventory::all(); // Obtener todos los productos del inventario
        return view('recipe', compact('recipes', 'inventories'));
    }

    public function create()
    {
        return view('recipe_form');
    }

    public function edit(Recipe $recipe)
    {
        return view('recipe_form', compact('recipe'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'difficult' => 'required',
            'ingredient' => 'required',
            'description' => 'required',
            'image' => 'required|url',
            'timeset' => 'required',
            'shortdesc' => 'required',
        ]);

        Recipe::create($request->all());

        return redirect()->route('recipes.index')
                         ->with('success', 'Recipe creado exitosamente.');
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'name' => 'required',
            'difficult' => 'required',
            'ingredient' => 'required',
            'description' => 'required',
            'image' => 'required|url',
            'timeset' => 'required',
            'shortdesc' => 'required',
        ]);

        $recipe->update($request->all());

        return redirect()->route('recipes.index')
                         ->with('success', 'Recipe actualizado exitosamente.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect()->route('recipes.index')
                         ->with('success', 'Recipe eliminado exitosamente.');
    }
}
