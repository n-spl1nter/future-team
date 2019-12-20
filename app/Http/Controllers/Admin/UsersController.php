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

    public function view(User $user)
    {
        return view('admin.users.view', ['model' => $user]);
    }

    public function changeStatus(Request $request, User $user)
    {
        $user->toggleStatus();
        return redirect()->route('admin.users.view', $user->id)->with('success', 'User status has been changed');
    }

    public function update(Request $request, User $user)
    {
        dd($user, $request);
    }
}
