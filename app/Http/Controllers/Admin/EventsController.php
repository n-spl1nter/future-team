<?php

namespace App\Http\Controllers\Admin;

use App\Entities\ActivityField;
use App\Entities\Country;
use App\Entities\Event;
use App\Entities\MediaFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $paginator = Event::orderByDesc('id')->paginate(10);
        return view('admin.events.index', compact('paginator'));
    }

    public function view(Request $request)
    {
        $model = Event::findOrFail($request->route('id'));

        return view('admin.events.view', compact('model'));
    }

    public function update(Request $request)
    {
        $model = Event::findOrFail($request->route('id'));
        $countries = Country::pluck('title_en', 'country_id');
        $domains = ActivityField::pluck('value_en');
        return view('admin.events.edit', compact('model', 'countries', 'domains'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function uploadNewPhoto(Request $request)
    {
        $this->validate($request, [
            'new_photo' => 'required|image',
            'entity_id' => 'required|integer',
        ]);

        $event = Event::findOrFail($request->get('entity_id'));
        $event->setNewPhoto($request->file('new_photo'));

        $photos = $event->getImages(MediaFile::TYPE_EVENT)->pluck('url')->toArray();

        return response()->json(['photos' => $photos]);
    }

    public function change(Request $request)
    {
        dd($request);
    }

    public function status(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        $model = Event::findOrFail($request->route('id'));
        if ($request->get('status') === Event::ACTIVE) {
            $model->status = Event::BLOCKED;
        } else {
            $model->status = Event::ACTIVE;
        }
        $model->save();

        return redirect()->route('admin.events.index')->with('success', 'Статус события изменен');
    }

    public function toggleFavoriteStatus(Request $request)
    {
        $model = Event::findOrFail($request->route('id'));
        $model->is_main = $model->isFavorite() ? 0 : 1;
        $model->save();

        return redirect()->back()->with('success', 'Main status changed');
    }
}
