<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Логин через email",
     *     tags={"Auth"},
     *  @OA\Parameter(name="username", required=true, in="query", example="test@test.com", description="Email"),
     *  @OA\Parameter(name="password", required=true, in="query", example="", description="Password"),
     *  @OA\Response(
     *     response=200,
     *     description="Успешная авторизация, возвращает токен"
     *  ),
     *  @OA\Response(
     *     response=400,
     *     description="Возвращает массив ошибок"
     * ),
     *  @OA\Response(
     *     response=401,
     *     description="Неправильный пароль или email"
     * )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $validator = \Validator::make($request->all(), [
            'username' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

        $credentials = [
            'email' => $request->get('username'),
            'password' => $request->get('password'),
        ];

        if (!\Auth::attempt($credentials)) {
            $this->incrementLoginAttempts($request);
            return response()->json(['errors' => ['process' => [__('auth.failed')]]], 401);
        }

        return response()->json(\Auth::getUser()->makeToken());
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Выход из приложения",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *  @OA\Response(
     *     response=204,
     *     description="Удаляет все токены клиента"
     *  )
     * )
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout()
    {
        \Auth::user()->oauthAccessTokens()->delete();

        return response('', 204);
    }
}
