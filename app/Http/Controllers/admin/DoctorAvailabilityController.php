<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\TimeSlot;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class DoctorAvailabilityController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:doctor_availability_list');
        $this->middleware('permission:doctor_availability_create', ['only' => ['create','store']]);
        $this->middleware('permission:doctor_availability_update', ['only' => ['edit','update']]);
        $this->middleware('permission:doctor_availability_delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $availables = DoctorAvailability::get();
        return view('admin.doctor_availability.index', compact('availables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = Doctor::all();
        return view('admin.doctor_availability.create', compact('doctors'));
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
            'doctor_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'sit_quantity' => 'required',
            'status' => 'required'
        ]);

        $exist = DoctorAvailability::where('doctor_id',$request->doctor_id)->where('day',$request->day)->first();
        if ($exist) {
            Toastr::error('Doctor availability already added for the selected day','Failed');
            return redirect()->route('availability.index');
        }
        
        $availability = new DoctorAvailability();
        $availability->doctor_id = $request->doctor_id;
        $availability->day = $request->day;
        $availability->start_time = $request->start_time;
        $availability->end_time = $request->end_time;
        $availability->sit_quantity = $request->sit_quantity;
        $availability->status = $request->status;
        $status = $availability->save();

        if ($status) {
            Toastr::success('Doctor availability added','Success');
            return redirect()->route('availability.index');
        }
        else {
            Toastr::erroe('Doctor availability failed to add','Failed');
            return redirect()->route('availability.index');
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
        $available = DoctorAvailability::findOrFail($id);
        $doctors = Doctor::all();
        return view('admin.doctor_availability.edit', compact('available','doctors'));
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
            'doctor_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'sit_quantity' => 'required',
            'status' => 'required'
        ]);
        
        $availability = DoctorAvailability::findOrFail($id);
        $availability->doctor_id = $request->doctor_id;
        $availability->day = $request->day;
        $availability->start_time = $request->start_time;
        $availability->end_time = $request->end_time;
        $availability->sit_quantity = $request->sit_quantity;
        $availability->status = $request->status;
        $status = $availability->save();

        if ($status) {
            Toastr::success('Doctor availability updated','Success');
            return redirect()->route('availability.index');
        }
        else {
            Toastr::erroe('Doctor availability failed to update','Failed');
            return redirect()->route('availability.index');
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
        $availability = DoctorAvailability::findOrFail($id);
        $status = $availability->delete();

        if ($status) {
            Toastr::success('Doctor availability deleted','Success');
            return redirect()->route('availability.index');
        }
        else {
            Toastr::erroe('Doctor availability failed to delete','Failed');
            return redirect()->route('availability.index');
        }

    }
}
