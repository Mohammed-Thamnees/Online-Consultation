<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    
    public function list(Request $request)
    {
        $user = $request->user_id;
        if ($user == NULL) {
            return response()->json([
                'result' => false,
                'message' => 'please provide user id'
            ],404);
        }

        $notification = Notification::where('user_id',$user)->get();
        if ($notification) {
            return response()->json([
                'result' => true,
                'notification' => $notification
            ],200);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'no notifications'
            ],404);
        }
    }

}
