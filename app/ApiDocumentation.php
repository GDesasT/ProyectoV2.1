<?php

namespace App;

/**
 * @OA\Info(
 *     title="API de Inventario y Recetas",
 *     version="1.0.0",
 *     description="Esta es la documentación de la API para gestionar inventarios y recetas.",
 *     @OA\Contact(
 *         email="soporte@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor local de desarrollo"
 * )
 * 
 * @OA\Server(
 *     url="https://api.tu-dominio.com",
 *     description="Servidor de producción"
 * )
 */
class ApiDocumentation
{
    // Esta clase solo existe para almacenar anotaciones Swagger.
}