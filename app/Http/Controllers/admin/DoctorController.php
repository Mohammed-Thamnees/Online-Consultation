<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\DoctorCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:doctor_list');
        $this->middleware('permission:doctor_create', ['only' => ['create','store']]);
        $this->middleware('permission:doctor_update', ['only' => ['edit','update']]);
        $this->middleware('permission:doctor_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::get();
        return view('admin.doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.doctor.create', compact('categories'));
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
            'category' => 'required|array',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'about' => 'required',
            'start_date' => 'required|date',
            'fees' => 'required|numeric',
            'dob' => 'required|date',
            'designation' => 'required',
            'qualification' => 'required',
            'education' => 'required',
            'experiance' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'status' => 'required',
        ]);

        try{
            DB::beginTransaction();
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->pin = $request->pin;
            $user->place = $request->place;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);

            if ($request->file('image')) {
                $image = $request->file('image');
                $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
                $image->storeAs('public/user', $imagename);
                $user->image = $imagename;
            }

            $user->assignRole($request->role);
            $user->save();

            $lastuser = User::orderBy('id','DESC')->first();

            $doctor = new Doctor();
            $doctor->user_id = $lastuser->id;
            $doctor->fees = $request->fees;
            $doctor->start_date = $request->start_date;
            $doctor->designation = $request->designation;
            $doctor->qualification = $request->qualification;
            $doctor->education = $request->education;
            $doctor->experiance = $request->experiance;
            $doctor->details = $request->about;
            $status = $doctor->save();

            $lastdoctor = Doctor::orderBy('id','DESC')->first();

            foreach ($request->category as $categoryId) {
                $category = new DoctorCategory();
                $category->doctor_id = $lastdoctor->id;
                $category->category_id = $categoryId;
                $category->save();
            }
            DB::commit();

            if ($status) {
                Toastr::success('Doctor added successfully','Success');
                return redirect()->route('doctor.index');
            }
            else {
                Toastr::error('Doctor added failed','Failed');
                return redirect()->route('doctor.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Something wrong','Failed');
            return redirect()->route('doctor.index');
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
        $doctor = Doctor::findOrFail($id);
        $appointments = Appointment::where('doctor_id',$doctor->id)->orderBy('date','asc')->get();
        return view('admin.doctor.profile', compact('doctor','appointments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $categories = Category::get();
        $doc_cat = $doctor->doctorcategory->pluck('category_id')->toArray();
        return view('admin.doctor.edit', compact('doctor','categories','doc_cat'));
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
            'category' => 'required|array',
            'email' => 'required|email',
            'phone' => 'required',
            'designation' => 'required',
            'about' => 'required',
            'start_date' => 'required|date',
            'fees' => 'required|numeric',
            'dob' => 'required|date',
            'qualification' => 'required',
            'education' => 'required',
            'experiance' => 'required',
            'gender' => 'required',
            'status' => 'required',
        ]);

        try{
            DB::beginTransaction();
            $doctor = Doctor::findOrFail($id);
            $user = User::where('id',$doctor->user_id)->first();
            $doc_cat = DoctorCategory::where('doctor_id',$id)->get();
            foreach ($doc_cat as $cat) {
                $cat->delete();
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->pin = $request->pin;
            $user->place = $request->place;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
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

            $user->save();

            $doctor->user_id = $user->id;
            $doctor->start_date = $request->start_date;
            $doctor->fees = $request->fees;
            $doctor->designation = $request->designation;
            $doctor->qualification = $request->qualification;
            $doctor->education = $request->education;
            $doctor->experiance = $request->experiance;
            $doctor->details = $request->about;
            $status = $doctor->save();

            foreach ($request->category as $categoryId) {
                $category = new DoctorCategory();
                $category->doctor_id = $id;
                $category->category_id = $categoryId;
                $category->save();
            }
            DB::commit();

            if ($status) {
                Toastr::success('Doctor updated successfully','Success');
                return redirect()->route('doctor.index');
            }
            else {
                Toastr::error('Doctor updation failed','Failed');
                return redirect()->route('doctor.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Something wrong','Failed');
            return redirect()->route('doctor.index');
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
        //
    }
}
