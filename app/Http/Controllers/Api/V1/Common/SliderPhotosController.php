<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Entities\SliderPhoto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderPhotosController extends Controller
{
    /**
     * @OA\Get(
     *     path="/common/mainslider/photos",
     *     summary="Фото для основного слайдера",
     *     tags={"Common"},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список фото для основного слайдера",
     *     @OA\JsonContent()
     *     ),
     * )
     */
    public function index()
    {
        $images = SliderPhoto::orderByDesc('order')->get();
        return response()->json($images);
    }
}
