<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Leavedefine;
use App\Models\Notification;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;


class Approve_leave extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:leave_approve', ['only' => [
            'index', 'approvestatus', 'declinestatus', 'show', 'destroy'
            ]]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user['users'] = Leavedefine::all();
        return view('admin.leave.leaveapproval.index',$user);
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

    }

    public function approvestatus(Request $request,$id)
    {
        // return $id;
        $data = Leavedefine::find($id);
        if ($data->status == NULL) {
            $data->status = 1;
            $status = $data->save();
            if ($status) {
                Notification::create($data->user_id, 'your leave approved');
                Toastr::success('Leave approved','Success');
                return redirect()->route('leaveapprove.index');
            }
            else {
                Toastr::error('Leave failed to approve','Failed');
                return redirect()->route('leaveapprove.index');
            }
        } else {
            Toastr::error('Leave already approved','Failed');
            return redirect()->route('leaveapprove.index');
        }
    }

    public function declinestatus(Request $request,$id)
    {
        // return $id;
        $data = Leavedefine::find($id);
        if ($data->status == NULL) {
            $data->status = 0;
            $status = $data->save();
            if ($status) {
                Notification::create($data->user_id, 'your leave declained');
                Toastr::success('Leave declined','Success');
                return redirect()->route('leaveapprove.index');
            }
            else {
                Toastr::error('Leave failed to decline','Failed');  
                return redirect()->route('leaveapprove.index');
            }
        } else {
            Toastr::error('Leave already approved','Failed');
            return redirect()->route('leaveapprove.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   $leavedefine['define'] = Leavedefine::find($id);
        return view('admin.leave.leaveapproval.show',$leavedefine);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Leavedefine::find($id);

        $status = $delete->delete();
         if ($status) {
            Toastr::success('deleted','Success');
            return redirect()->route('leaveapprove.index');
        }
        else {
            Toastr::error('failed to delete','Failed');
            return redirect()->route('leaveapprove.index');
        }
    }
}
