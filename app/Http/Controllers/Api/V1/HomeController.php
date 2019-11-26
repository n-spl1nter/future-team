<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Server(url="http://futureteam.local/api/v1")
 * @OA\Server(url="https://ft.crazy-dev.ru/api/v1")
 * @OA\Info(
 *   title="FutureTeam API",
 *   version="0.1.0",
 *   @OA\Contact(
 *      email="razraz.odinodin@gmail.com",
 *      name="Aleksey Rodin",
 *   )
 * )
 * @OA\Tag(
 *   name="Auth",
 *   description="Auth"
 * )
 * @OA\Tag(
 *   name="User",
 *   description="Пользователи"
 * )
 * @OA\Tag(
 *   name="Common",
 *   description="Общая информация"
 * )
 * @OA\Tag(
 *   name="Main",
 *   description="Основной функционал"
 * )
 * @OA\Parameter(
 *  parameter="token",
 *  name="Authorization",
 *  in="header",
 *  required=true,
 *  example="Bearer "
 * ),
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * ),
 *          @OA\Schema(
 *              schema="CompanyProfile",
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
 *
 *
 *          @OA\Schema(
 *              schema="MemberProfile",
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
 *
 * /**
 * @OA\Schema(
 *   schema="RegisterMember",
 *   allOf={
 *     @OA\Schema(
 *       @OA\Property(property="email", description="unique email"),
 *       @OA\Property(property="type",  description="'company' or 'member'"),
 *     ),
 *     @OA\Schema(ref="#/components/schemas/MemberProfile"),
 *   }
 * )
 */
class HomeController extends Controller
{
    public function index()
    {
        return 'Start page of Future team project';
    }
}
