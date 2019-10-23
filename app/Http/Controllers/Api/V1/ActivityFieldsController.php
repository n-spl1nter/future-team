<?php

namespace App\Http\Controllers\Api\V1;

use App\Entities\ActivityField;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityFieldsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/activityfields",
     *     summary="Сферы деятельности",
     *     tags={"Common"},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список сфер деятельности",
     *     @OA\JsonContent()
     *     ),
     * )
     */
    public function index()
    {
        $activityFields = ActivityField::all();
        return response()->json(['items' => $activityFields]);
    }
}
