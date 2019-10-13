<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/account",
     *     summary="Возвращает профиль текущего пользователя",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает профиль текущего пользователя"
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Не авторизован"
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function account()
    {
        $account = \Auth::user()->getAccountInfo();

        return response()
            ->json($account);
    }
}
