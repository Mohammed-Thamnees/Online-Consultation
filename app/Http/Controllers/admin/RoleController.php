<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:role_list');
        $this->middleware('permission:role_create', ['only' => ['create','store']]);
        $this->middleware('permission:role_update', ['only' => ['edit','update']]);
        $this->middleware('permission:role_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.user-management.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user-management.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'guard_name' => 'required|string'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $status = $role->save();

        if ($status) {
            Toastr::success('Role added successfully', 'Success');
            return redirect()->route('roles.index');
        }
        else {
            Toastr::error('Role added failed', 'Failed');
            return redirect()->route('roles.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.user-management.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'guard_name' => 'required|string'
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $status = $role->save();

        if ($status) {
            Toastr::success('Role updated successfully', 'Success');
            return redirect()->route('roles.index');
        }
        else {
            Toastr::error('Role updation failed', 'Failed');
            return redirect()->route('roles.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $status = $role->delete();

        if ($status) {
            Toastr::success('Role deleted successfully', 'Success');
            return redirect()->route('roles.index');
        }
        else {
            Toastr::error('Role deletion failed', 'Failed');
            return redirect()->route('roles.index');
        }
    }
}
