<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        return view('recipe', compact('recipes'));
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
            'ingredient' => 'required',
            'description' => 'required',
            'image' => 'required|url',
            'timeset' => 'required',
        ]);

        Recipe::create($request->all());

        return redirect()->route('recipes.index')
                         ->with('success', 'Recipe creado exitosamente.');
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'name' => 'required',
            'ingredient' => 'required',
            'description' => 'required',
            'image' => 'required|url',
            'timeset' => 'required',
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
