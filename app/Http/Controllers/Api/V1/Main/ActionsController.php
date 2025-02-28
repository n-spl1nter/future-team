<?php

namespace App\Http\Controllers\Api\V1\Main;

use App\Entities\Action;
use App\Entities\ActionReport;
use App\Events\ActionCreate;
use App\Helpers\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Main\ActionReportRequest;
use App\Http\Requests\Api\V1\Main\CreateActionRequest;
use App\Http\Requests\Api\V1\Main\DeleteActionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActionsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/main/actions",
     *     summary="Список акций",
     *     tags={"Main"},
     *     @OA\Parameter(name="country_id", required=false, in="query", description="Id страны"),
     *     @OA\Parameter(name="page", required=false, in="query", example="1", description="номер страницы"),
     *     @OA\Parameter(name="perPage", required=false, in="query", example="20", description="Выводить на странице"),
     *     @OA\Parameter(name="status", required=false, in="query", description="Статус ('archive' | 'active')"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список акций и стран",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $actionsQuery = Action::whereStatus(Action::ACTIVE)
            ->orderByDesc('created_at');
        if ($request->has('country_id')) {
            $actionsQuery = $actionsQuery->whereCountryId($request->get('country_id'));
        }
        if ($status == 'archive') {
            $actionsQuery = $actionsQuery->where('end_at', '<', now());
        } elseif ($status == 'active') {
            $actionsQuery = $actionsQuery->where('end_at', '>', now());
        }
        $actions = $actionsQuery->paginate(Pagination::resolvePerPageCount($request))
            ->appends($request->except('page'));

        return response()->json([
            'items' => $actions,
            'countries' => Action::getDistinctCountries($request),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/main/actions/{action}",
     *     summary="Акция",
     *     tags={"Main"},
     *     @OA\Parameter(name="action", required=true, in="path", description="Slug акции"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает акцию",
     *     @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *      response=404,
     *      description="Не найдено",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param Action $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Action $action)
    {
        return response()->json($action->getAllInfo());
    }

    /**
     * @OA\Post(
     *     path="/main/action",
     *     summary="Создание акции",
     *     tags={"Main"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(property="name", description="Название(5+ символов)"),
     *              @OA\Property(property="about", description="В чем именно заключается Ваше доброе дело(5+ символов)"),
     *              @OA\Property(property="success_secret", description="Секрет успеха(5-400 символов)"),
     *              @OA\Property(property="domains[0]", description="Сферы(массив [2-5])", type="string"),
     *              @OA\Property(property="domains[1]", description="Сферы", type="string"),
     *              @OA\Property(
     *                   property="photos[0]", description="Массив фото(min_width=1280,min_height=700)", type="file",
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
     *        description="Успешное создание акции",
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
     * @param CreateActionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateActionRequest $request)
    {
        $action = Action::make($request);
        event(new ActionCreate($action));

        return response()->json($action->getAllInfo(), Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/main/action/report/{action}",
     *     summary="Добавление отчета о проведении акции",
     *     tags={"Main"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="action", required=true, in="path", description="Slug акции"),
     *     @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(
     *                   property="photos[0]", description="Массив фото(min_width=1280,min_height=700)", type="file",
     *                   @OA\Items(type="string", format="binary")
     *              ),
     *              @OA\Property(
     *                   property="photos[1]", description="Массив фото", type="file",
     *                   @OA\Items(type="string", format="binary")
     *              ),
     *              @OA\Property(property="video_links[0]", description="Ссылки на видео (массив URL)", type="string"),
     *          ),
     *      )
     *     ),
     *     @OA\Response(
     *        response=201,
     *        description="Успешное добавление отчета",
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
     * @param Action $action
     * @param ActionReportRequest $request
     * @return void
     */
    public function addReport(Action $action, ActionReportRequest $request)
    {
        ActionReport::add($action, $request);
        return response()->json(null, Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/main/action/join/{action}",
     *     @OA\Parameter(name="action", required=true, in="path", description="Slug акции"),
     *     summary="Присоединиться к акции",
     *     tags={"Main"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *        response=201,
     *        description="Успешное добавление пользователя к акции",
     *        @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *        response=401,
     *        description="Ошибка аутентификации",
     *        @OA\JsonContent()
     *    ),
     *     @OA\Response(
     *        response=404,
     *        description="Акция не найдена",
     *        @OA\JsonContent()
     *    ),
     *     @OA\Response(
     *        response=422,
     *        description="Возвращает массив ошибок",
     *        @OA\JsonContent()
     *    ),
     * )
     * @param Action $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function joinToAction(Action $action)
    {
        if (!$action->joinMember(\Auth::user())) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json();
    }

    /**
     * @OA\Get(
     *     path="/main/actions/{action}/members",
     *     summary="Получить список пользователей, присоединившихся к акции",
     *     tags={"Main"},
     *     @OA\Parameter(name="action", required=true, in="path", description="Slug акции"),
     *     @OA\Parameter(name="page", required=false, in="query", description="Номер страницы"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает объект пагинации поьзваотелей",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param Action $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMembers(Action $action)
    {
        $members = $action->joinedUsers()->paginate(20);
        return response()->json($members);
    }


    /**
     * @OA\Post(
     *     path="/main/action/delete/{action}",
     *     summary="Удаление акции",
     *     tags={"Main"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="action", required=true, in="path", description="Slug акции"),
     *     @OA\Response(
     *        response=200,
     *        description="Успешное удаление отчета",
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
     * @param Action $action
     * @param DeleteActionRequest $request
     * @return void
     */
    public function delete(Action $action, DeleteActionRequest $request)
    {
        $action->status = Action::DELETED;
        $action->save();
        return response()->json();
    }
}
