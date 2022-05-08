<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class AssignPermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:permission_assign', ['only' => ['index','rolepermission','rolepermissionassign']]);
    }

    public function index()
    {
        $roles = Role::all();
        return view('admin.user-management.assign-permission.index',compact('roles'));
    }

    public function rolepermission($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.user-management.assign-permission.assign',compact('role','permissions','rolePermissions'));
    }

    public function rolepermissionassign(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'guard_name' => 'required',
            'permissions' => 'required|array',
        ]);

        $role = Role::findByName($request->name);
        $status = $role->syncPermissions($request->permissions);

        if ($status) {
            Toastr::success('Permissions assigned', 'Success');
            return redirect()->route('role.lists');
        }
        else {
            Toastr::error('Permissions assigned failed', 'Failed');
            return redirect()->route('role.lists');
        }
    }

}
