<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\enterprise;

/**
 * @OA\Tag(
 *     name="Enterprise",
 *     description="Gestión de empresas (Enterprise)"
 * )
 */
class EnterpriseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/enterprise/create",
     *     tags={"Enterprise"},
     *     summary="Mostrar formulario para crear una empresa",
     *     description="Devuelve la vista con el formulario para crear una nueva empresa.",
     *     @OA\Response(
     *         response=200,
     *         description="Vista del formulario para crear una empresa"
     *     )
     * )
     */
    public function create()
    {
        return view('enterprise');
    }

    /**
     * @OA\Post(
     *     path="/enterprise/store",
     *     tags={"Enterprise"},
     *     summary="Guardar una nueva empresa",
     *     description="Valida y guarda los datos de una nueva empresa.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "address"},
     *             @OA\Property(property="name", type="string", example="Empresa ABC"),
     *             @OA\Property(property="email", type="string", format="email", example="empresa@abc.com"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="address", type="string", example="Calle Principal 123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirige a la vista de creación con un mensaje de éxito"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:45',
            'email' => 'required|max:45|email|unique:enterprises,email',
            'phone' => 'required|max:45',
            'address' => 'required',
        ]);

        enterprise::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        return redirect()->route('enterprises.create')->with('success', 'La empresa se añadió correctamente!');
    }

    /**
     * @OA\Get(
     *     path="/enterprise/search",
     *     tags={"Enterprise"},
     *     summary="Buscar empresas",
     *     description="Busca empresas según los filtros proporcionados (nombre, email, teléfono).",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Nombre de la empresa a buscar"
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="email"),
     *         description="Correo electrónico de la empresa a buscar"
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Teléfono de la empresa a buscar"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de empresas que coinciden con los criterios de búsqueda"
     *     )
     * )
     */
    public function search(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:45',
            'email' => 'nullable|email|max:45',
            'phone' => 'nullable|string|max:45',
        ]);

        $query = enterprise::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        }

        if ($request->filled('phone')) {
            $query->where('phone', $request->input('phone'));
        }

        $enterprises = $query->get();

        return view('enterprise', compact('enterprises'));
    }

    /**
     * @OA\Delete(
     *     path="/enterprise/{id}",
     *     tags={"Enterprise"},
     *     summary="Eliminar una empresa",
     *     description="Elimina una empresa con base en su ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la empresa a eliminar"
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirige a la vista de creación con un mensaje de éxito"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Empresa no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $enterprise = enterprise::findOrFail($id);
        $enterprise->delete();

        return redirect()->route('enterprises.create')->with('success', 'La empresa fue eliminada correctamente!');
    }
}
