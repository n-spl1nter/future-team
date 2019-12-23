<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Action;
use App\Entities\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function mainNews()
    {
        $actions = Action::whereIsMain(1)->get();
        $events = Event::whereIsMain(1)->get();
        $models = $actions->merge($events)->sortByDesc('created_at');

        return view('admin.main-news.index', compact('models'));
    }
}
