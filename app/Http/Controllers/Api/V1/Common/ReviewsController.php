<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Entities\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/common/reviews",
     *     summary="Отзывы",
     *     tags={"Common"},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список отзывов",
     *     @OA\JsonContent()
     *     ),
     * )
     */
    public function index()
    {
        $reviews = Review::with('country')->get();

        return response()->json($reviews);
    }
}
