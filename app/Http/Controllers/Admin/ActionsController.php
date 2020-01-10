<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Action;
use App\Entities\ActivityField;
use App\Entities\Country;
use App\Entities\MediaFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    public function index()
    {
        $paginator = Action::orderByDesc('id')->paginate(10);
        return view('admin.actions.index', compact('paginator'));
    }

    public function view(Request $request)
    {
        $model = Action::findOrFail($request->route('id'));

        return view('admin.actions.view', compact('model'));
    }

    public function update(Request $request)
    {
        $model = Action::findOrFail($request->route('id'));
        $countries = Country::pluck('title_en', 'country_id');
        $domains = ActivityField::pluck('value_en');
        return view('admin.actions.edit', compact('model', 'countries', 'domains'));
    }

    public function change(Request $request)
    {
        dd($request);
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

        $event = Action::findOrFail($request->get('entity_id'));
        $event->setNewPhoto($request->file('new_photo'));

        $photos = $event->getImages(MediaFile::TYPE_EVENT);

        return response()->json(['photos' => $photos]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function removePhoto(Request $request)
    {
        $this->validate($request, [
            'photo_id' => 'required|integer',
        ]);

        $mediaFile = MediaFile::findOrFail($request->get('photo_id'));
        return response()->json($mediaFile->deleteWithFiles());
    }

    public function status(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        $model = Action::findOrFail($request->route('id'));
        if ($request->get('status') === Action::ACTIVE) {
            $model->status = Action::BLOCKED;
        } else {
            $model->status = Action::ACTIVE;
        }
        $model->save();

        return redirect()->route('admin.actions.index')->with('success', 'Статус акции изменен');
    }

    public function toggleFavoriteStatus(Request $request)
    {
        $model = Action::findOrFail($request->route('id'));
        $model->is_main = $model->isFavorite() ? 0 : 1;
        $model->save();

        return redirect()->back()->with('success', 'Main status changed');
    }
}
