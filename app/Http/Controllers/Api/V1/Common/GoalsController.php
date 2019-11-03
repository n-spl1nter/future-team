<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Entities\Goal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoalsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/common/goals",
     *     summary="Цели устойчивого развития ООН",
     *     tags={"Common"},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список целей",
     *     @OA\JsonContent()
     *     ),
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['items' => Goal::all()]);
    }
}
