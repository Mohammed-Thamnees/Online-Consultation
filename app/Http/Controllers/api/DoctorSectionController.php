<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorSectionController extends Controller
{
    
    //get all category of doctors
    public function category()
    {
        $category = Category::get();
        return response()->json([
            'result' => true,
            'category' => $category,
        ],200);
    }

    //find doctor category by id
    public function findcategory(Request $request)
    {
        if ($request->id) {
            $category = Category::findOrFail($request->id);
            if ($category != NULL) {
                return response()->json([
                    'result' => true,
                    'category' => $category,
                ],200);
            }
            else {
                return response()->json([
                    'result' => false,
                    'message' => 'category does not exists',
                ],404);
            }
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'please input category id',
            ],404);
        }
    }

    //get all doctors list
    public function doctors()
    {
        $doctors = Doctor::with('doctordetails','doctorcategory')->get();
        return response()->json([
            'result' => true,
            'image path' =>'/storage/user/',
            'doctors' => $doctors,
        ],200);
    }

    //find doctor by id
    public function finddoctor(Request $request)
    {
        if ($request->id) {
            $doctor = Doctor::where('id',$request->id)->with('doctordetails','doctorcategory')->first();
            if ($doctor != NULL) {
                return response()->json([
                    'result' => true,
                    'image path' =>'/storage/user/',
                    'doctor' => $doctor,
                    'about' => strip_tags($doctor->details),
                ],200);
            }
            else {
                return response()->json([
                    'result' => false,
                    'message' => 'doctor does not exists',
                ],404);
            }
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'please input doctor id',
            ],404);
        }
    }

}
