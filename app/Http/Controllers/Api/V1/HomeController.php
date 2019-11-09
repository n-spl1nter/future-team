<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Server(url="http://futureteam.local/api/v1")
 * @OA\Server(url="https://ft.crazy-dev.ru/api/v1")
 * @OA\Info(
 *   title="FutureTeam API",
 *   version="0.1.0",
 *   @OA\Contact(
 *      email="razraz.odinodin@gmail.com",
 *      name="Aleksey Rodin",
 *   )
 * )
 * @OA\Tag(
 *   name="Api base",
 *   description="API base page"
 * )
 * @OA\Tag(
 *   name="Auth",
 *   description="Auth"
 * )
 * @OA\Tag(
 *   name="User",
 *   description="Пользователи"
 * )
 * @OA\Tag(
 *   name="Common",
 *   description="Общая информация"
 * )
 * @OA\Tag(
 *   name="Main",
 *   description="Основной функционал"
 * )
 * @OA\Parameter(
 *  parameter="token",
 *  name="Authorization",
 *  in="header",
 *  required=true,
 *  example="Bearer "
 * ),
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * )
 */
class HomeController extends Controller
{
    /**
     * @OA\Get(
     *   path="/",
     *   summary="Base path",
     *   tags={"Api base"},
     *   @OA\Response(
     *      response=200,
     *      description="Api information",
     *      @OA\JsonContent()
     *   )
     * )
     * @return string
     */
    public function index()
    {
        return 'Start page of Future team project';
    }
}
