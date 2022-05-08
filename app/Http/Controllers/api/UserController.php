<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    
    public function profiledetail(Request $request)
    {
        $user = User::findOrFail($request->id);
        return response()->json([
            'result' => true,
            'patient' => $user
        ],200);
    }

    public function profileupdate(Request $request)
    {
        if ($request->type == 'patient') {
            $user = User::findOrFail($request->id);
            $user->first_name = $request->name;
            $user->blood_group = $request->blood_group;
            $user->dob = $request->dob;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->pin = $request->pin;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->country = $request->country;
            $user->gender = $request->gender;

            if ($request->file('image')) {
                Storage::delete('public/user/'.$user->image);
                $image = $request->file('image');
                $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
                $image->storeAs('public/user', $imagename);
                $user->image = $imagename;
            }
            
            $status = $user->save();

            if ($status) {
                return response()->json([
                    'result' => true,
                    'message' => 'profile updated',
                    'patient' => $user
                ],200);
            }
            else {
                return response()->json([
                    'result' => false,
                    'message' => 'profile update failed'
                ],401);
            }
        }
        elseif ($request->type == 'doctor') {
            $doctor = Doctor::findOrFail($request->id);
            $user = User::where('id',$doctor->user_id)->first();
            $user->first_name = $request->name;
            $user->blood_group = $request->blood_group;
            $user->dob = $request->dob;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->pin = $request->pin;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->country = $request->country;
            $user->gender = $request->gender;

            if ($request->file('image')) {
                Storage::delete('public/user/'.$user->image);
                $image = $request->file('image');
                $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
                $image->storeAs('public/user', $imagename);
                $user->image = $imagename;
            }
            
            $status = $user->save();

            if ($status) {
                return response()->json([
                    'result' => true,
                    'message' => 'profile updated',
                    'doctor' => $user
                ],200);
            }
            else {
                return response()->json([
                    'result' => false,
                    'message' => 'profile update failed'
                ],401);
            }
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'choose type as patient or doctor'
            ],401);
        }
    }

}
