<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Action;
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
}
