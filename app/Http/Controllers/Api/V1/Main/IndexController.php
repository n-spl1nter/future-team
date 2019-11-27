<?php

namespace App\Http\Controllers\Api\V1\Main;

use App\Entities\Action;
use App\Entities\CompanyProfile;
use App\Entities\Event;
use App\Entities\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *     path="/summary/countries",
     *     summary="Кол-во акций, событий и участнков сгруппированные по городам",
     *     tags={"Main"},
     *     @OA\Response(
     *      response=200,
     *      description="Результат",
     *     @OA\JsonContent()
     *     ),
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWorldInfo()
    {
        $actions = Action::select('country_id', \DB::raw("count(*) as total"))
            ->groupBy('country_id')
            ->pluck('total', 'country_id')
            ->all();
        $events = Event::select('country_id', \DB::raw("count(*) as total"))
            ->groupBy('country_id')
            ->pluck('total', 'country_id')
            ->all();
        $members = Profile::select('country_id', \DB::raw("count(*) as total"))
            ->groupBy('country_id')
            ->pluck('total', 'country_id');
        $companies = CompanyProfile::select('country_id', \DB::raw("count(*) as total"))
            ->groupBy('country_id')
            ->pluck('total', 'country_id');

        return response()->json(compact('actions', 'events', 'members', 'companies'));
    }

    public function getCountryInfo()
    {

    }
}
