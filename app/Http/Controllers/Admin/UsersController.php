<?php

namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $usersQuery = User::with(['role', 'companyProfile', 'profile']);
        $usersQuery->where('email', 'like', $request->get('filter_email', '') . '%');
        $paginator = $usersQuery->sortable()->paginate(20)->appends($request->all());

        return view('admin.users.index', compact('paginator'));
    }
}
