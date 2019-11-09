<?php

namespace App\Http\Controllers\Api\V1\Main;

use App\Entities\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
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
     *        response=422,
     *        description="Возвращает массив ошибок",
     *        @OA\JsonContent()
     *    ),
     *     @OA\Response(
     *        response=401,
     *        description="Ошибка аутентификации",
     *        @OA\JsonContent()
     *    ),
     * )
     * @param CreateEventRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateEventRequest $request)
    {
        $event = Event::make($request);
        return response()->json($event, 201);
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
