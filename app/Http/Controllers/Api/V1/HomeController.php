<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Server(url="http://futureteam.local/api/v1")
 * @OA\Info(
 *   title="FutureTeam API",
 *   version="1.0.0",
 *   @OA\Contact(
 *      email="razraz.odinodin@gmail.com"
 *   )
 * )
 * @OA\Tag(
 *   name="Api base",
 *   description="API base page"
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
     *      description="Api information"
     *   )
     * )
     * @return string
     */
    public function index()
    {
        return 'Start page of Future team project';
    }
}
