<?php

namespace App\Http\Controllers\Admin;

use App\RBAC\Permission;
use App\RBAC\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        foreach (Role::all() as $role){
            if(isset($data[$role->id])){
                $role->savePermissions($data[$role->id]);
            }else{
                $role->savePermissions([]);
            }
        }

        return redirect()->back()->with('success', __('common.permissions.successMessage'));
    }
}
