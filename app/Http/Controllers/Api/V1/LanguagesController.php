<?php

namespace App\Http\Controllers\Api\V1;

use App\Entities\Language;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/languages",
     *     summary="Языки",
     *     tags={"Common"},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список языков",
     *     @OA\JsonContent()
     *     ),
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $languages = Language::all();
        return response()->json(['items' => $languages]);
    }
}
