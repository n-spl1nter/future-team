<?php

namespace App\Http\Controllers\Api\V1\Main;

use App\Entities\Action;
use App\Entities\CompanyProfile;
use App\Entities\Country;
use App\Entities\Event;
use App\Entities\Profile;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use function foo\func;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *     path="/summary/countries",
     *     summary="Кол-во акций, событий и участнков сгруппированные по странам",
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
        $actions = Action::whereStatus(Action::ACTIVE)
            ->select('country_id', \DB::raw("count(*) as total"))
            ->groupBy('country_id')
            ->pluck('total', 'country_id')
            ->all();
        $events = Event::whereStatus(Event::ACTIVE)
            ->select('country_id', \DB::raw("count(*) as total"))
            ->groupBy('country_id')
            ->pluck('total', 'country_id')
            ->all();
        $members = Profile::select('country_id', \DB::raw("count(*) as total"))
            ->whereHas('user', function (Builder $builder) {
                $builder->where('status', '<>', User::STATUS_BLOCKED);
            })
            ->groupBy('country_id')
            ->pluck('total', 'country_id');
        $companies = CompanyProfile::select('country_id', \DB::raw("count(*) as total"))
            ->whereHas('user', function (Builder $builder) {
                $builder->where('status', '<>', User::STATUS_BLOCKED);
            })
            ->groupBy('country_id')
            ->pluck('total', 'country_id');

        return response()->json(compact('actions', 'events', 'members', 'companies'));
    }

    /**
     * @OA\Get(
     *     path="/summary/country",
     *     summary="Кол-во акций, событий в стране",
     *     tags={"Main"},
     *     @OA\Parameter(name="country_id", required=true, in="query", description="Id страны"),
     *     @OA\Response(
     *      response=200,
     *      description="Результат",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getCountryInfo(Request $request)
    {
        $this->validate($request, [
            'country_id' => 'required|integer',
        ]);

        $actions = Action::whereCountryId($request->get('country_id'))
            ->with('city')
            ->whereStatus(Action::ACTIVE)
            ->get();
        $events = Event::whereCountryId($request->get('country_id'))
            ->with('city')
            ->whereStatus(Event::ACTIVE)
            ->get();
        $members = User::whereHas('profile', function (Builder $query) use ($request) {
            $query->where('country_id', $request->get('country_id'));
        })->get();
        $companies = User::whereHas('companyProfile', function (Builder $query) use ($request) {
            $query->where('country_id', $request->get('country_id'));
        })->get();

        return response()->json(compact('actions', 'events', 'members', 'companies'));
    }

    /**
     * @OA\Get(
     *     path="/summary/favorites",
     *     summary="Акции и события для главной страницы",
     *     tags={"Main"},
     *     @OA\Response(
     *      response=200,
     *      description="Результат",
     *     @OA\JsonContent()
     *     ),
     * )
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getFavorites()
    {
        $actions = Action::active()
            ->whereIsMain(1)
            ->get()
            ->map(function ($model) {
                $model['type'] = 'action';
                return $model;
            });
        $events = Event::active()
            ->whereIsMain(1)
            ->get()
            ->map(function ($model) {
                $model['type'] = 'event';
                return $model;
            });
        $models = $actions->merge($events)->sortByDesc('created_at');

        return response()->json($models);
    }
}
