<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorCategory;
use App\Models\Medicine;
use App\Models\MedicineType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    
    public function getdoctors(Request $request)
    {
        $doctors = DoctorCategory::join('doctors','doctors.id','=','doctor_categories.doctor_id')
                ->join('users','doctors.user_id','=','users.id')
                ->where('doctor_categories.category_id',$request->id)->select('doctors.id','users.first_name','users.last_name')
                ->get();
        return response()->json($doctors);
    }

    public function medicinetypes()
    {
        $types = MedicineType::get();
        return response()->json($types);
    }

    public function medicines()
    {
        $medicines = Medicine::where('status',1)->get();
        return response()->json($medicines);
    }

    public function loginphone(Request $request)
    {
        $user = User::where('phone',$request->number)->where('status',1)->first();
        if ($user) {
            return response()->json([
                'result' => true,
                'user' => $user
            ]);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'not a registered number or inactive user'
            ]);
        }
    }

    public function phonelogin(Request $request)
    {
        $user = User::where('phone',$request->number)->where('status',1)->first();
        if ($user) {
            if ($user->roles[0]['name'] == 'admin' || $user->roles[0]['name'] == 'doctor') {
                Auth::login($user);
                return response()->json([
                    'result' => true,
                    'redirect' => url("admin/home"),
                    'message' => 'login success'
                ]);
            }
            else {
                return response()->json([
                    'result' => false,
                    'message' => 'login failed'
                ]);
            }
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'login failed'
            ]);
        }
    }

}
