<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *  path="/auth/register",
     *  summary="Register by email",
     *  tags={"Auth"},
     *     @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Property(ref="#/components/schemas/RegisterMember"),
     *      ),
     *     ),
     *  @OA\Response(
     *     response=201,
     *     description="Успешная регистрация, возвращает сущность User",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(
     *     response=422,
     *     description="Возвращает массив ошибок",
     *      @OA\JsonContent()
     * )
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::makeFromEmail($request);

        return response()->json(['user' => $user], 201);
    }
}
