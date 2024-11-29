<?php

namespace App;
/**
 * @OA\Info(
 *     title="API de Inventario",
 *     version="1.0.0",
 *     description="Documentación de la API de Inventario",
 *     @OA\Contact(email="soporte@example.com"),
 *     @OA\License(name="MIT", url="https://opensource.org/licenses/MIT")
 * )
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor local"
 * )
 */
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
 * 
 * @OA\Tag(
 *     name="Inventario",
 *     description="Endpoints relacionados con la gestión de inventarios."
 * )
 * 
 * @OA\Tag(
 *     name="Recetas",
 *     description="Endpoints relacionados con la gestión de recetas."
 * )
 */
class ApiDocumentation
{
    // Esta clase solo existe para almacenar anotaciones Swagger.
}
