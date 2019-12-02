<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\PasswordResetRequest;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{

    /**
     * @OA\Post(
     *     path="/auth/send-password-reset-link",
     *     summary="Запрос ссылки сброса пароля",
     *     tags={"Auth"},
     *     @OA\Parameter(name="email", required=true, in="query", description="Email пользователя"),
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendResetLink(PasswordResetRequest $request)
    {
        $user = User::whereEmail($request->get('email'))->first();
        if ($user) {
            Password::broker()->sendResetLink($request->only(['email']));
        }

        return response()->json();
    }

    public function setNewPassword(ResetPasswordRequest $request)
    {

    }
}
