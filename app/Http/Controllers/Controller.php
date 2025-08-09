<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="CalorieDiet Swagger Documentation", version="1.0.0")
 *
 * @OA\PathItem(path="/api")
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="SERVER"
 *  )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 *     bearerFormat="JWT"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
