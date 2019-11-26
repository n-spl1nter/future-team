<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Entities\CompanyProfile;
use App\Entities\Profile;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

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
            return response()->json(['errors' => $validator->errors()->getMessages()], 422);
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
            return response()->json(['errors' => $validator->errors()->getMessages()], 422);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function findCompanies(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'companyName' => 'required|string|min:2',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->getMessages()], 422);
        }

        $value = $request->get('companyName') . '%';
        $companies = CompanyProfile::where('full_name', 'LIKE', $value)
            ->limit(20)
            ->get();

        return response()->json(['items' => $companies]);
    }
}
