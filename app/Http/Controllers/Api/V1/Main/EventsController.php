<?php

namespace App\Http\Controllers\Api\V1\Main;

use App\Entities\Event;
use App\Events\EventCreate;
use App\Helpers\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Main\CreateEventRequest;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/main/events",
     *     summary="Список событий",
     *     tags={"Main"},
     *     @OA\Parameter(name="country_id", required=false, in="query", description="Id страны"),
     *     @OA\Parameter(name="page", required=false, in="query", example="1", description="номер страницы"),
     *     @OA\Parameter(name="perPage", required=false, in="query", example="20", description="Выводить на странице"),
     *     @OA\Parameter(name="status", required=false, in="query", description="Статус ('archive' | 'active')"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список событий и стран",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $eventsQuery = Event::whereStatus(Event::ACTIVE)
            ->orderByDesc('created_at');
        if ($request->has('country_id')) {
            $eventsQuery = $eventsQuery->whereCountryId($request->get('country_id'));
        }
        if ($status == 'archive') {
            $eventsQuery = $eventsQuery->where('end_at', '<', now());
        } elseif ($status == 'active') {
            $eventsQuery = $eventsQuery->where('end_at', '>', now());
        }
        $events = $eventsQuery->paginate(Pagination::resolvePerPageCount($request))
            ->appends($request->except('page'));

        return response()->json([
            'items' => $events,
            'countries' => Event::getDistinctCountries($request),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/main/events/{event}",
     *     summary="Событие",
     *     tags={"Main"},
     *     @OA\Parameter(name="event", required=true, in="path", description="Slug события"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает событие",
     *     @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *      response=404,
     *      description="Не найдено",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Event $event)
    {
        return response()->json($event->getAllInfo());
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
     *              @OA\Property(property="name", description="Название"),
     *              @OA\Property(property="conditions", description="Условия участия"),
     *              @OA\Property(property="reasons", description="Чем ваше мероприятие может быть полезно"),
     *              @OA\Property(property="contact_data", description="Контактные данные организаторов"),
     *              @OA\Property(property="additional_info", description="Дополнительная информация"),
     *              @OA\Property(property="domains[0]", description="Сферы(массив [2-5])", type="string"),
     *              @OA\Property(property="domains[1]", description="Сферы", type="string"),
     *              @OA\Property(
     *                   property="photos[0]", description="Массив фото(min_width=1920,min_height=800)", type="file",
     *                   @OA\Items(type="string", format="binary")
     *              ),
     *              @OA\Property(
     *                   property="photos[1]", description="Массив фото", type="file",
     *                   @OA\Items(type="string", format="binary")
     *              ),
     *              @OA\Property(property="video_links[0]", description="Ссылки на видео (массив URL)", type="string"),
     *              @OA\Property(property="city_id", description="ID города"),
     *              @OA\Property(property="country_id", description="ID страны"),
     *              @OA\Property(property="start_at", description="Дата и время начало в формате Y-m-d H:i:s"),
     *              @OA\Property(property="end_at", description="Дата и время конца в формате Y-m-d H:i:s"),
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
     *     @OA\Response(
     *        response=403,
     *        description="Ошибка авторизации",
     *        @OA\JsonContent()
     *    ),
     * )
     * @param CreateEventRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateEventRequest $request)
    {
        $event = Event::make($request);
        event(new EventCreate($event));
        return response()->json($event->getAllInfo(), 201);
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
