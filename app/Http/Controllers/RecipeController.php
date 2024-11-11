<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/recipes",
     *     summary="Obtener todas las recetas",
     *     tags={"Recipes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de recetas"
     *     )
     * )
     */
    public function index()
    {
        $recipes = Recipe::all();
        return view('recipe', compact('recipes'));
    }

    /**
     * @OA\Post(
     *     path="/recipes",
     *     summary="Crear una nueva receta",
     *     tags={"Recipes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "difficult", "ingredient_name", "ingredient_quantity", "ingredient_unit", "description", "image", "timeset", "shortdesc"},
     *             @OA\Property(property="name", type="string", example="Receta 1"),
     *             @OA\Property(property="difficult", type="string", example="Fácil"),
     *             @OA\Property(property="ingredient_name", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="ingredient_quantity", type="array", @OA\Items(type="number")),
     *             @OA\Property(property="ingredient_unit", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="image", type="string", format="url"),
     *             @OA\Property(property="timeset", type="string"),
     *             @OA\Property(property="shortdesc", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirige a la lista de recetas tras la creación"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en los datos enviados"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Validación y procesamiento del código
    }

    /**
     * @OA\Get(
     *     path="/recipes/{id}",
     *     summary="Obtener una receta por ID",
     *     tags={"Recipes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la receta",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos de la receta con ingredientes"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Receta no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        // Código para obtener y devolver la receta por ID
    }

    /**
     * @OA\Put(
     *     path="/recipes/{id}",
     *     summary="Actualizar una receta existente",
     *     tags={"Recipes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la receta",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "difficult", "ingredient_name", "ingredient_quantity", "ingredient_unit", "description", "image", "timeset", "shortdesc"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="difficult", type="string"),
     *             @OA\Property(property="ingredient_name", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="ingredient_quantity", type="array", @OA\Items(type="number")),
     *             @OA\Property(property="ingredient_unit", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="image", type="string", format="url"),
     *             @OA\Property(property="timeset", type="string"),
     *             @OA\Property(property="shortdesc", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirige a la lista de recetas tras la actualización"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Receta no encontrada"
     *     )
     * )
     */
    public function update(Request $request, Recipe $recipe)
    {
        // Código para actualizar la receta
    }

    /**
     * @OA\Delete(
     *     path="/recipes/{id}",
     *     summary="Eliminar una receta",
     *     tags={"Recipes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la receta",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirige a la lista de recetas tras la eliminación"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Receta no encontrada"
     *     )
     * )
     */
    public function destroy(Recipe $recipe)
    {
        // Código para eliminar la receta
    }

    /**
     * @OA\Post(
     *     path="/recipes/calculate-ingredients",
     *     summary="Calcular ingredientes necesarios para la receta",
     *     tags={"Recipes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "quantity"},
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="quantity", type="integer", example=2, description="Cantidad de platillos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de ingredientes calculados"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Receta no encontrada"
     *     )
     * )
     */
    public function calculateIngredients(Request $request)
    {
        // Código para calcular los ingredientes
    }

    /**
     * @OA\Post(
     *     path="/recipes/elaborate/{id}",
     *     summary="Elaborar la receta y actualizar inventario",
     *     tags={"Recipes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la receta",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"multiplier"},
     *             @OA\Property(property="multiplier", type="integer", example=1, description="Multiplicador de la cantidad")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Éxito en la elaboración de la receta"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en los ingredientes"
     *     )
     * )
     */
    public function elaborate(Request $request, $id)
    {
        // Código para elaborar la receta y actualizar el inventario
    }
}