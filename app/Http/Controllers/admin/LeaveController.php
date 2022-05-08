<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Leavedefine;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;


class LeaveController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:leave_type_list');
        $this->middleware('permission:leave_type_create', ['only' => ['create','store']]);
        $this->middleware('permission:leave_type_update', ['only' => ['edit','update']]);
        $this->middleware('permission:leave_type_delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Leave['leavetype'] = Leave::all();
        return view('admin.leave.type.index',$Leave);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required'
        ]);
        $leavetype = new Leave();
        $leavetype->LeaveType = $request->name;
        $status = $leavetype->save();

        if ($status) {
            Toastr::success('Leavetype Added Succesfully','Success');
            return redirect()->route('leave.index');
        }
        else {
            Toastr::error('Failed to add Leavetype','Failed');
            return redirect()->route('leave.index');
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
        //
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
            'name' => 'required'
        ]);
        $Leave = Leave::findOrFail($id);
        $Leave->Leavetype = $request->name;
        $status = $Leave->save();
        if ($status) {
            Toastr::success('Leavetype updated','Success');
            return redirect()->route('leave.index');
        }
        else {
            Toastr::error('failed to update Leavetype','Failed');
            return redirect()->route('leave.index');
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
        $leave = Leave::findOrFail($id);
        $leavedefine = Leavedefine::where('Leavetype',$id)->first();
        if ($leavedefine) {
            Toastr::error('Leave is existed in this type','Failed');
            return redirect()->route('leave.index');

        } 
        else {
            $status = $leave->delete();
        }

        if ($status) {
            Toastr::success('Leavetype deleted','Success');
            return redirect()->route('leave.index');
        }
        else {
            Toastr::error(  'failed to delete Leavetype','Failed');
            return redirect()->route('leave.index');
        }
    }
}
