<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Leavedefine;
use App\Models\Notification;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    
    //Leave types list
    public function types()
    {
        $types = Leave::select('leaves.id','leaves.Leavetype')->get();
        if ($types) {
            return response()->json([
                'result' => true,
                'leave_types' => $types
            ],200);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'no leave types added'
            ],404);
        }
    }

    //Leave Register
    public function register(Request $request)
    {
        $user = $request->user_id;
        $type = $request->type;
        $reason = $request->reason;
        $from = $request->from_date;
        $to = $request->to_date;

        if ($user==NULL || $type==NULL || $reason==NULL || $from==NULL || $to==NULL) {
            return response()->json([
                'result' => false,
                'message' => 'please enter all necessary fields'
            ],404);
        }

        $exist = Leavedefine::where('user_id',$user)->where('Fromdate',$from)->where('Todate',$to)->first();
        if ($exist) {
            return response()->json([
                'result' => false,
                'message' => 'Leave already applied'
            ],404);
        }

        $leave = new Leavedefine();
        $leave->user_id = $user;
        $leave->Leavetype = $type;
        $leave->Fromdate = $from;
        $leave->Todate = $to;
        $leave->Reason = $reason;
        $leave->status = 0;
        $leave->save();

        Notification::create($user, 'leave appiled');
        Notification::create(1, 'new leave application recieved');
        return response()->json([
            'result' => true,
            'leave' => $leave
        ],200);
    }

    //All leaves list
    public function all(Request $request)
    {
        $user = $request->user_id;
        if ($user == NULL) {
            return response()->json([
                'result' => false,
                'message' => 'user id is required'
            ],404);
        }

        $leaves = Leavedefine::with('type')->where('user_id',$user)->get();
        if ($leaves) {
            return response()->json([
                'result' => true,
                'leaves' => $leaves,
            ],200);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'no leaves'
            ],404);
        }
    }

    //Awaitinng leaves list
    public function awaiting(Request $request)
    {
        $user = $request->user_id;
        if ($user == NULL) {
            return response()->json([
                'result' => false,
                'message' => 'user id is required'
            ],404);
        }

        $leaves = Leavedefine::with('type')->where('user_id',$user)->where('status',0)->get();
        if ($leaves) {
            return response()->json([
                'result' => true,
                'leaves' => $leaves
            ],200);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'no leaves'
            ],404);
        }
    }

    //Approved leaves list
    public function approved(Request $request)
    {
        $user = $request->user_id;
        if ($user == NULL) {
            return response()->json([
                'result' => false,
                'message' => 'user id is required'
            ],404);
        }

        $leaves = Leavedefine::with('type')->where('user_id',$user)->where('status',1)->get();
        if ($leaves) {
            return response()->json([
                'result' => true,
                'leaves' => $leaves
            ],200);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'no leaves'
            ],404);
        }
    }

}
