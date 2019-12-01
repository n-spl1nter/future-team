<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Entities\Action;
use App\Entities\CompanyProfile;
use App\Entities\Event;
use App\Entities\Profile;
use App\Entities\User;
use App\Helpers\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\GetCompanyMembersRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/account",
     *     summary="Возвращает профиль текущего пользователя",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает профиль текущего пользователя",
     *      @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *      response=401,
     *      description="Не аутентифицирован",
     *      @OA\JsonContent()
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function account()
    {
        $account = \Auth::user()->getAccountInfo();

        return response()
            ->json($account);
    }

    /**
     * @OA\Get(
     *     path="/user/{user}",
     *     summary="Возвращает публичный профиль пользователя",
     *     tags={"User"},
     *     @OA\Parameter(name="user", required=true, in="path", description="Id пользователя"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает публичный профиль пользователя",
     *      @OA\JsonContent()
     *     ),
     * )
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(User $user)
    {
        return response()->json($user->getPublicProfile());
    }

    /**
     * @OA\Post(
     *     path="/user/profile",
     *     summary="Добавление\обновление профиля пользователя",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Property(ref="#/components/schemas/MemberProfile"),
     *      ),
     *     ),
     *     @OA\Response(
     *        response=201,
     *        description="Успешное добавление профиля к пользователю",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setProfile(Request $request)
    {
        /** @var User $user */
        $user = \Auth::user();
        $rules = $user->profile ? Profile::getOnUpdateValidationRules() : Profile::getOnCreateValidationRules();
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $user->setProfile($request);

        return response()->json(['user' => $user->getAccountInfo()], 201);
    }

    /**
     * @OA\Post(
     *     path="/user/companyprofile",
     *     summary="Добавляет профиль к организации",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Property(ref="#/components/schemas/CompanyProfile"),
     *      ),
     *     ),
     *     @OA\Response(
     *        response=201,
     *        description="Успешное добавление профиля к компании",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setCompanyProfile(Request $request)
    {
        /** @var User $user */
        $user = \Auth::user();
        $rules = $user->companyProfile ? CompanyProfile::getOnUpdateValidationRules() : CompanyProfile::getOnCreateValidationRules();
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $user->setCompanyProfile($request);
        return response()->json(['user' => $user->getAccountInfo()], 201);
    }

    /**
     * @OA\Get(
     *     path="/user/companies/search",
     *     summary="Поиск компаний",
     *     tags={"User"},
     *     @OA\Parameter(name="companyName", required=true, in="query", description="Начало имени компании(мин длинна 2 символа))"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список наденных компаний",
     *      @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findCompanies(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'companyName' => 'required|string|min:2',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $value = $request->get('companyName') . '%';
        $companies = CompanyProfile::where('full_name', 'LIKE', $value)
            ->limit(20)
            ->get();

        return response()->json(['items' => $companies]);
    }

    /**
     * @OA\Post(
     *     path="/user/message/send",
     *     summary="Отправка сообщения пользователю",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="user_id", required=true, in="query", description="Id пользователя"),
     *     @OA\Parameter(name="message", required=true, in="query", description="Сообщение"),
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        try {
            /** @var User $currentUser */
            $currentUser = \Auth::user();
            $currentUser->sendMessageToUser(User::findOrFail($request->get('user_id')), $request->get('message'));
        } catch (\Throwable $exception) {
            return response()->json(['errors' => [$exception->getMessage()]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json();
    }

    /**
     * @OA\Get(
     *     path="/users/companies",
     *     summary="Компании",
     *     tags={"User"},
     *     @OA\Parameter(name="country_id", required=false, in="query", description="ID страны"),
     *     @OA\Parameter(name="page", required=false, in="query", example="1", description="номер страницы"),
     *     @OA\Parameter(name="perPage", required=false, in="query", example="20", description="Выводить на странице"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список наденных компаний",
     *      @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCompanies(Request $request)
    {
        $companiesQuery = User::companies();
        if ($request->has('country_id')) {
            $companiesQuery = $companiesQuery->whereHas('companyProfile', function (Builder $builder) use ($request) {
                $builder->where('country_id', '=', $request->get('country_id'));
            });
        }
        $companies = $companiesQuery->with(['companyProfile', 'companyProfile.country'])
            ->paginate(Pagination::resolvePerPageCount($request))
            ->appends($request->except('page'));
        return response()->json([
            'items' => $companies,
            'countries' => CompanyProfile::getDistinctCountries(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/user/activities/all",
     *     summary="Акции и ивенты юзера",
     *     tags={"User"},
     *     @OA\Parameter(name="user_id", required=true, in="query", description="Id юзера"),
     *     @OA\Response(
     *      response=200,
     *      description="Коллекция ивентов и акций",
     *      @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getUsersActionsAndEvents(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
        ]);

        $user = User::findOrFail($request->get('user_id'));
        $actions = $user->actions()
            ->where('status', '=', Action::ACTIVE)
            ->get()
            ->map(function ($model) {
                $model['type'] = 'action';
                return $model;
            });
        $events = $user->events()
            ->where('status', '=', Event::ACTIVE)
            ->get()
            ->map(function ($model) {
                $model['type'] = 'event';
                return $model;
            });;

        $merged = $actions->merge($events)->sortBy('created_at');

        return response()->json([
            'merged' => $merged,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/users/company/members",
     *     summary="Члены организации",
     *     tags={"User"},
     *     @OA\Parameter(name="user_id", required=true, in="query", description="Id компании"),
     *     @OA\Response(
     *      response=200,
     *      description="Пагинатор юзеров",
     *      @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function companyMembers(GetCompanyMembersRequest $request)
    {
        $company = User::findOrFail($request->get('user_id'));

        return response()->json($company->organizationMembers);
    }
}
