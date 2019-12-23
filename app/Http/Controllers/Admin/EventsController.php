<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Event;
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
