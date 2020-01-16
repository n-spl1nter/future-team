<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Action;
use App\Entities\EmailMessage;
use App\Entities\Event;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $lastUsers = User::orderByDesc('created_at')->limit(8)->get();
        $monthlyRegisters = User::getLastMonthUserRegisters();
        $messagesSentTodayCount = EmailMessage::where('created_at', '>', Carbon::today())->count();
        $userRegisteredTodayCount = User::where('created_at', '>', Carbon::today())->count();
        $eventsCreatedTodayCount = Event::where('created_at', '>', Carbon::today())->count();
        $actionsCreatedTodayCount = Action::where('created_at', '>', Carbon::today())->count();
        return view('admin.home', compact(
            'monthlyRegisters',
            'lastUsers',
            'messagesSentTodayCount',
            'userRegisteredTodayCount',
            'eventsCreatedTodayCount',
            'actionsCreatedTodayCount'
        ));
    }

    public function mainNews()
    {
        $actions = Action::whereIsMain(1)->get();
        $events = Event::whereIsMain(1)->get();
        $models = $actions->merge($events)->sortByDesc('created_at');

        return view('admin.main-news.index', compact('models'));
    }
}
