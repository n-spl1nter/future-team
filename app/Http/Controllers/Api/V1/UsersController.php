<?php

namespace App\Http\Controllers\Api\V1;

use App\Entities\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/account",
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
     *      description="Не авторизован",
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
     *     path="/profile",
     *     summary="Добавляет профиль к пользователю",
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
     *              @OA\Property(
     *                  property="goals",
     *                  description="Цели(массив строк, длинна 1-5)",
     *                  type="array",
     *                  @OA\Items(type="string")
     *              ),
     *              @OA\Property(
     *                  property="known_languages",
     *                  description="Языки, которыми владею(массив Id)",
     *                  type="array",
     *                  @OA\Items(type="integer")
     *              ),
     *              @OA\Property(
     *                  property="languages_wltl",
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
     *                  property="motivation",
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
     *              @OA\Property(property="organization_id", description="id существующей организации"),
     *              @OA\Property(property="organization_name", description="Имя организации"),
     *          ),
     *      ),
     *     ),
     *     @OA\Response(
     *        response=201,
     *        description="Успешное добавление профиля к пользователю",
     *        @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *        response=400,
     *        description="Возвращает массив ошибок",
     *        @OA\JsonContent()
     *    ),
     *     @OA\Response(
     *        response=401,
     *        description="Ошибка авторизации",
     *        @OA\JsonContent()
     *    ),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setProfile(Request $request)
    {
        $validator = \Validator::make($request->all(), Profile::getOnCreateValidationRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->getMessages()], 400);
        }

    }
}
