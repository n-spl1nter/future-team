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
     * @OA\Post(
     *     path="/user/profile",
     *     summary="Добавление\обновление профиля пользователя",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(property="first_name", description="Имя", type="string"),
     *              @OA\Property(property="middle_name",description="Отчество", type="string"),
     *              @OA\Property(property="last_name", description="Фамилия", type="string"),
     *              @OA\Property(property="phone", description="Телефон", type="string"),
     *              @OA\Property(property="birth_date_at", description="Дата рождения", type="string"),
     *              @OA\Property(property="city_id", description="ID города", type="integer"),
     *              @OA\Property(property="activity_field_id", description="ID Сферы деятельности", type="integer"),
     *              @OA\Property(property="goals[0]", description="ID Цели", type="integer"),
     *              @OA\Property(property="goals[1]", description="ID Цели", type="integer"),
     *              @OA\Property(
     *                  property="known_languages[]",
     *                  collectionFormat="multi",
     *                  description="Языки, которыми владею(массив Id)",
     *                  type="array",
     *                  @OA\Items(type="integer")
     *              ),
     *              @OA\Property(
     *                  property="languages_wltl[]",
     *                  collectionFormat="multi",
     *                  description="Языки, которые хочу выучить(массив Id)",
     *                  type="array",
     *                  @OA\Items(type="integer")
     *              ),
     *              @OA\Property(
     *                  property="language_exchange_agreement",
     *                  description="Согласие на участие в языковом обмене (0 или 1)",
     *                  type="integer"
     *              ),
     *              @OA\Property(
     *                  property="motivation[]",
     *                  collectionFormat="multi",
     *                  description="Цели(массив строк, длинна 1-5)",
     *                  type="array",
     *                  @OA\Items(type="string")
     *              ),
     *              @OA\Property(
     *                   property="photo", description="Фото", type="file",
     *                   @OA\Items(type="string", format="binary")
     *              ),
     *              @OA\Property(property="about", description="О себе", type="string"),
     *              @OA\Property(property="terms", description="Согласие на обработку данных"),
     *              @OA\Property(property="organization_id", description="id существующей организации", type="integer"),
     *              @OA\Property(property="organization_name", description="Имя организации", type="string"),
     *          ),
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
     *          @OA\Schema(
     *              @OA\Property(property="full_name", description="Полное название", type="string"),
     *              @OA\Property(property="country_id", description="ID страны", type="integer"),
     *              @OA\Property(property="description", description="Описание(макс 1500 символов)", type="string"),
     *              @OA\Property(property="contact_person_name", description="Контактное лицо", type="string"),
     *              @OA\Property(property="contact_person_email", description="Email контактного лица", type="string"),
     *              @OA\Property(property="cooperation_type", description="Пример желаемого сотрудничества(10-1500 символов)", type="string"),
     *              @OA\Property(property="organization_type_id", description="Тип организации (id)", type="integer"),
     *              @OA\Property(property="organization_type", description="Тип организации (свой)", type="string"),
     *              @OA\Property(property="goals[0]", description="ID Цели", type="integer"),
     *              @OA\Property(property="goals[1]", description="ID Цели", type="integer"),
     *              @OA\Property(
     *                   property="photo", description="Фото", type="file",
     *                   @OA\Items(type="string", format="binary")
     *              ),
     *              @OA\Property(property="terms", description="Согласие на обработку данных"),
     *          ),
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
