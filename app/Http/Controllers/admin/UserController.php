<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user_list');
        $this->middleware('permission:user_create', ['only' => ['create','store']]);
        $this->middleware('permission:user_update', ['only' => ['edit','update']]);
        $this->middleware('permission:user_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','!=','2')->get();
        return view('admin.user-management.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::whereIn('name',['admin','patient'])->get();
        return view('admin.user-management.users.create',compact('roles'));
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
            'first_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->pin = $request->pin;
        $user->place = $request->place;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);

        if ($request->file('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
            $image->storeAs('public/user', $imagename);
            $user->image = $imagename;
        }

        $user->assignRole($request->role);
        
        $status = $user->save();

        if ($status) {
            Toastr::success('User added successfully','Success');
            return redirect()->route('users.index');
        }
        else {
            Toastr::error('User added failed','Failed');
            return redirect()->route('users.index');
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
        $user = User::findOrfail($id);
        $roles = Role::whereIn('name',['admin','patient'])->get();
        return view('admin.user-management.users.edit',compact('user','roles'));
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
            'first_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = User::findOrfail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->pin = $request->pin;
        $user->place = $request->place;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->status = $request->status;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        else {
            $user->password = $user->password;
        }

        if ($request->file('image')) {
            Storage::delete('public/user/'.$user->image);
            $image = $request->file('image');
            $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
            $image->storeAs('public/user', $imagename);
            $user->image = $imagename;
        }

        $user->removeRole($user->roles[0]['id']);
        $user->assignRole($request->role);
        
        $status = $user->save();

        if ($status) {
            Toastr::success('User updated successfully','Success');
            return redirect()->route('users.index');
        }
        else {
            Toastr::error('User updation failed','Failed');
            return redirect()->route('users.index');
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
        $user = User::findOrfail($id);
        Storage::delete('public/user/'.$user->image);
        $status = $user->delete();

        if ($status) {
            Toastr::success('User deleted successfully','Success');
            return redirect()->route('users.index');
        }
        else {
            Toastr::error('User deletion failed','Failed');
            return redirect()->route('users.index');
        }        
    }
}
