<?php

namespace App\Http\Controllers\Api\V1;

use App\Entities\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/countries",
     *     summary="Страны",
     *     tags={"Common"},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список стран",
     *     @OA\JsonContent()
     *     ),
     * )
     */
    public function index()
    {
        $countries = Country::getMainLocales();
        return response()->json(['items' => $countries]);
    }
}
