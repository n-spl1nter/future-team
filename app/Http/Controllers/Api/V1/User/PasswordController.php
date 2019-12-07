<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\ChangePasswordRequest;

class PasswordController extends Controller
{

    /**
     * @OA\Post(
     *     path="/user/password/change",
     *     summary="Смена пароля",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="current_password", required=true, in="query", description="Текущий пароль"),
     *     @OA\Parameter(name="password", required=true, in="query", description="Новый пароль"),
     *     @OA\Parameter(name="password_confirmation", required=true, in="query", description="Новый пароль(повтор)"),
     *     @OA\Response(
     *        response=200,
     *        description="Успешная отправка",
     *        @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *        response=422,
     *        description="Возвращает массив ошибок",
     *        @OA\JsonContent()
     *    ),
     * )
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        \Auth::user()->setPassword($request->get('password'))->save();
        return response()->json();
    }
}
