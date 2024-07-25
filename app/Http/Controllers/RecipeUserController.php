<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecipeUser;

class RecipeUserController extends Controller
{
    public function index()
    {
        $recipes = RecipeUser::all();
        return view('recipes.index', compact('recipes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        RecipeUser::create($request->all());

        return redirect()->route('recipes.index')->with('success', 'Recipe added successfully');
    }
}
