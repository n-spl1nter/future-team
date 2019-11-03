<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Entities\OrganizationType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationTypesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/common/organizationtypes",
     *     summary="Типы организаций",
     *     tags={"Common"},
     *     @OA\Response(
     *      response=200,
     *      description="Возвращает список типов организаций",
     *     @OA\JsonContent()
     *     ),
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $organizationTypes = OrganizationType::all();
        return response()->json(['items' => $organizationTypes]);
    }
}
