<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Entities\MailSubscribe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailSubscribesController extends Controller
{
    /**
     * @OA\Post(
     *     path="/user/subscribe",
     *     summary="Подписка на новости",
     *     tags={"User"},
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
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $subscribe = MailSubscribe::whereEmail($request->get('email'))
            ->firstOrCreate([], $request->all());

        return response()->json([]);

    }

    public function unSubscribe()
    {

    }
}
