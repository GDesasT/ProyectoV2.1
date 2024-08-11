<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\recipe;
use App\Models\inventory;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = recipe::all();
        $inventories = inventory::all(); // Obtener todos los productos del inventario
        return view('recipe', compact('recipes', 'inventories'));
    }

    public function create()
    {
        return view('recipe_form');
    }

    public function edit(recipe $recipe)
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

        recipe::create($request->all());

        return redirect()->route('recipes.index')
                         ->with('success', 'recipe creado exitosamente.');
    }

    public function update(Request $request, recipe $recipe)
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
                         ->with('success', 'recipe actualizado exitosamente.');
    }

    public function destroy(recipe $recipe)
    {
        $recipe->delete();

        return redirect()->route('recipes.index')
                         ->with('success', 'recipe eliminado exitosamente.');
    }
}
