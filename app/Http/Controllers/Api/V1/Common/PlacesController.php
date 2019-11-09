<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Entities\City;
use App\Entities\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/common/countries",
     *     summary="Страны",
     *     tags={"Common"},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список стран",
     *     @OA\JsonContent()
     *     ),
     * )
     */
    public function countries()
    {
        $countries = Country::getMainLocales();
        return response()->json(['items' => $countries]);
    }

    /**
     * @OA\Get(
     *     path="/common/cities",
     *     summary="Города",
     *     tags={"Common"},
     *     @OA\Parameter(name="country_id", required=true, in="query", description="Id страны"),
     *     @OA\Parameter(name="value", required=true, in="query", description="Начало ввода города(мин длинна 2 символа))"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список городов",
     *     @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *      response=422,
     *      description="Возвращает массив ошибок",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'country_id' => 'required|integer|exists:_cities,city_id',
            'value' => 'required|string|min:2',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->getMessages()], 422);
        }

        $cities = City::whereCountryId($request->get('country_id'))
            ->where('title_ru', 'like', $request->get('value') . '%')
            ->select(['city_id', 'title_ru', 'area_ru', 'region_ru'])
            ->orderBy('city_id')
            ->limit(10)
            ->get();

        return response()->json(['items' => $cities]);
    }

    /**
     * @OA\Get(
     *     path="/common/city/{city}",
     *     summary="Город",
     *     tags={"Common"},
     *     @OA\Parameter(name="city", required=true, in="path", description="Id города"),
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает город по его id",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function city(City $city)
    {
        return response()->json(array_merge(
            $city->toArray(),
            ['country' => $city->country->toArray()]
        ));
    }
}
