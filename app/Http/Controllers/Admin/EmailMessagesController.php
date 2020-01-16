<?php

namespace App\Http\Controllers\Admin;

use App\Entities\EmailMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailMessagesController extends Controller
{
    public function index()
    {
        $paginator = EmailMessage::orderByDesc('created_at')->paginate(10);
        return view('admin.email-messages.index', compact('paginator'));
    }

    public function view(EmailMessage $emailMessage)
    {
        return view('admin.email-messages.view', ['model' => $emailMessage]);
    }
}
