<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Action;
use App\Entities\Event;
use App\Entities\User;
use App\Helpers\Export;
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
        if ($user->isBlocked()) {
            /** @var Event $event */
            foreach ($user->events as $event) {
                $event->status = Event::BLOCKED;
                $event->save();
            }
            /** @var Action $action */
            foreach ($user->actions as $action) {
                $action->status = Action::BLOCKED;
                $action->save();
            }
        }
        return redirect()->route('admin.users.view', $user->id)->with('success', 'User status has been changed');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function removeCompanyMember(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
        ]);

        $user = User::findOrFail($request->get('user_id'));
        $user->organization_id = null;
        $user->save();

        return redirect()->back()->with('success', 'Member has been removed.');
    }

    public function update(Request $request, User $user)
    {
        dd($user, $request);
    }

    public function exportMembers()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
            fputcsv($file, ['ID', 'Email', 'FullName', 'About', 'Country', 'City', 'Status', 'Crated At']);
            User::has('profile')
                ->with(['profile', 'profile.country', 'profile.city'])
                ->chunk(200, function ($users) use ($file) {
                /** @var User $user */
                foreach ($users as $user) {
                    $fields = [
                        $user->id,
                        $user->email,
                        $user->profile->full_name,
                        $user->profile->about,
                        $user->profile->country->title_en,
                        $user->profile->city->title_en,
                        $user->status,
                        $user->created_at,
                    ];
                    fputcsv($file, $fields);
                }
            });
            fclose($file);
        };

        return Export::getExportStream($callback, 'members');
    }

    public function exportCompanies()
    {
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
            fputcsv($file, ['ID', 'Email', 'FullName', 'Description', 'ContactPersonName', 'Country', 'Status', 'Crated At']);
            User::has('companyProfile')
                ->with(['companyProfile', 'companyProfile.country'])
                ->chunk(200, function ($users) use ($file) {
                    /** @var User $user */
                    foreach ($users as $user) {
                        $fields = [
                            $user->id,
                            $user->email,
                            $user->companyProfile->full_name,
                            $user->companyProfile->description,
                            $user->companyProfile->contact_person_name,
                            $user->companyProfile->country->title_en,
                            $user->status,
                            $user->created_at,
                        ];
                        fputcsv($file, $fields);
                    }
                });
            fclose($file);
        };

        return Export::getExportStream($callback, 'companies');
    }
}
