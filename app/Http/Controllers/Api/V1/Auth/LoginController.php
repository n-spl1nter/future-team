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
     *     path="/auth/login",
     *     summary="Логин через email",
     *     tags={"Auth"},
     *  @OA\Parameter(name="username", required=true, in="query", example="test@test.com", description="Email"),
     *  @OA\Parameter(name="password", required=true, in="query", example="", description="Password"),
     *  @OA\Response(
     *     response=200,
     *     description="Успешная авторизация, возвращает токен",
     *     @OA\JsonContent()
     *  ),
     *  @OA\Response(
     *     response=422,
     *     description="Возвращает массив ошибок",
     *     @OA\JsonContent()
     * ),
     *  @OA\Response(
     *     response=401,
     *     description="Неправильный пароль или email",
     *     @OA\JsonContent()
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
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $credentials = [
            'email' => $request->get('username'),
            'password' => $request->get('password'),
        ];

        if (!\Auth::attempt($credentials)) {
            $this->incrementLoginAttempts($request);
            return response()->json(['errors' => [__('auth.failed')]], 401);
        }

        $user = \Auth::getUser();
        if ($user->isBlocked()) {
            return response()->json(['errors' => [__('auth.failed')]], 401);
        }
        $accessToken = $user->makeToken()->accessToken;
        return response()->json(compact('accessToken'));
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Выход из приложения",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *       response=204,
     *       description="Удаляет все токены клиента",
     *       @OA\JsonContent()
     *     ),
     * )
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout()
    {
        \Auth::user()->oauthAccessTokens()->delete();

        return response()->json(null, 204);
    }
}
