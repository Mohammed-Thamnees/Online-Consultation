<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Leavedefine;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use GrahamCampbell\ResultType\Success;

class PendingLeave extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:leave_pending', ['only' => [
            'index', 'approvependingstatus', 'declinependingstatus', 'show', 'destroy'
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
        return view('admin.leave.pendingleave.index',$user);
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
        //
    }
    public function approvependingstatus(Request $request,$id)
    {
         // return $id;
         $data = Leavedefine::find($id);
         if ($data->status ==NULL) {
             $data->status =1;
             $status = $data->save();
             if($status){
                 Toastr::success('Leaveapproved','success');
                 return redirect()->route('pendingleaves.index');
             }else{
                 Toastr::error('Leave Failed To approve','Failed');
                 return redirect()->route('pendingleaves.index');

             }
        }else {
            Toastr::error('Leave already approved','Failed');
            return redirect()->route('pendingleaves.index');
        }
    }
    public function declinependingstatus(Request $request,$id)
    {
         // return $id;
         $data = Leavedefine::find($id);
         if ($data->status ==NULL) {
             $data->status = 0;
                $status = $data->save();
                if($status){
                    Toastr::success('Leave Declined','success');
                    return redirect()->route('pendingleaves.index');
                }else{
                    Toastr::error('Leave Declining Failed','Failed');
                    return redirect()->route('pendingleaves.index');

                }

         }else{
             Toastr::error('Leave already declined','Failed');
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
        $leavedefine['define'] = Leavedefine::find($id);
        return view('admin.leave.pendingleave.show',$leavedefine);
    }


    public function destroy($id)
    {
        $delete = Leavedefine::find($id);

        $status = $delete->delete();
         if ($status) {
            Toastr::success(' deleted','Success');
            return redirect()->route('pendingleaves.index');
        }
        else {
            Toastr::error('failed to delete','Failed');
            return redirect()->route('pendingleaves.index');
        }
    }
}
