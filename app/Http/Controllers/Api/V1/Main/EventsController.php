<?php

namespace App\Http\Controllers\Api\V1\Main;

use App\Entities\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventsController extends Controller
{
    public function index()
    {
        // @todo Implement
    }

    public function view()
    {
        // @todo Implement
    }

    /**
     * @OA\Post(
     *     path="/main/event",
     *     summary="Создание события(мероприятия)",
     *     tags={"Main"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(property="terms", description="Согласие на обработку данных"),
     *          ),
     *      )
     *     ),
     *     @OA\Response(
     *        response=201,
     *        description="Успешное создание события",
     *        @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *        response=400,
     *        description="Возвращает массив ошибок",
     *        @OA\JsonContent()
     *    ),
     *     @OA\Response(
     *        response=401,
     *        description="Ошибка аутентификации",
     *        @OA\JsonContent()
     *    ),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), Event::getOnCreateValidationRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->getMessages()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([], 201);
    }

    public function update()
    {
        // @todo Implement
    }

    public function deleteImage(Request $request)
    {
        // @todo Implement
    }

    public function delete()
    {
        // @todo Implement
    }
}
