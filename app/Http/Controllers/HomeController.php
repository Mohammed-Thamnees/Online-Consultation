<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginsubmit(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'status'=>1])) {
            if (Auth::user()->roles[0]['name'] == 'admin' || Auth::user()->roles[0]['name'] == 'doctor') {
                Toastr::success('Login success', 'Success');
                return redirect()->route('home');
            }
            else {
                Auth::logout();
                Toastr::error('You dont have login access', 'Failed');
                return redirect()->route('login.form');
            }
        }
        elseif (Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'status'=>0])) {
            Auth::logout();
            Toastr::error('User is not active', 'Failed');
            return redirect()->route('login.form');
        }
        else {
            Toastr::error('Login failed', 'Failed');
            return redirect()->route('login.form');
        }
    }

    public function phonelogin()
    {
        return view('admin.auth.login_phone');
    }

    public function logout()
    {
        Auth::logout();
        Toastr::success('Logout Successfull', 'Success');
        return redirect()->route('login.form');
    }

    public function index()
    {
        return view('admin.index');
    }
}
