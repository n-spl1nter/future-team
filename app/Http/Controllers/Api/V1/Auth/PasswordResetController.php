<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\PasswordResetRequest;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /**
     * @OA\Post(
     *     path="/auth/reset-password",
     *     summary="Сброс пароля",
     *     tags={"Auth"},
     *     @OA\Parameter(name="token", required=true, in="query", description="Токен сброса пароля"),
     *     @OA\Parameter(name="email", required=true, in="query", description="Почта"),
     *     @OA\Parameter(name="password", required=true, in="query", description="Новый пароль"),
     *     @OA\Parameter(name="password_confirmation", required=true, in="query", description="Новый пароль"),
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
    public function resetPassword(ResetPasswordRequest $request)
    {
        $response =  Password::broker()->reset(
                $this->credentials($request), function ($user, $password) {
                $this->setNewPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? response()->json()
            : response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    protected function setNewPassword($user, $password)
    {
        $user->password = \Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }
}
