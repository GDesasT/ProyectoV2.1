<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Inventory",
 *     type="object",
 *     required={"name", "amount", "type", "unit"},
 *     @OA\Property(property="id", type="integer", description="ID del inventario"),
 *     @OA\Property(property="name", type="string", description="Nombre del producto"),
 *     @OA\Property(property="amount", type="number", description="Cantidad disponible del producto"),
 *     @OA\Property(property="type", type="string", description="Categoría del producto (e.g., Verdura, Fruta)"),
 *     @OA\Property(property="unit", type="string", description="Unidad de medida (e.g., Kg, L, Pz)"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de última actualización"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación del registro")
 * )
 */
class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'type',
        'unit',
    ];
}
