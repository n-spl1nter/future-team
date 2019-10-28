<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *  path="/register",
     *  summary="Register by email",
     *  tags={"Auth"},
     *  @OA\Parameter(name="email", required=true, in="query", example="test@test.com", description="unique email"),
     *  @OA\Parameter(name="type", required=true, in="query", example="member", description="'company' or 'member'"),
     *  @OA\Response(
     *     response=201,
     *     description="Успешная регистрация, возвращает сущность User"
     *  ),
     *  @OA\Response(
     *     response=400,
     *     description="Возвращает массив ошибок"
     * )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'type' => ['required', Rule::in([User::TYPE_MEMBER, User::TYPE_COMPANY])],
        ]);
        if ($validator->fails()) {
            return response()
                ->json(['errors' => $validator->errors()->getMessages()], 400);
        }
        $user = User::makeFromEmail($request->all());

        return response()->json(['user' => $user], 201);
    }
}
