<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('permission:chat', ['only' => ['index','startchat','send']]);
        $this->middleware('permission:chat_settings', ['only' => ['setting']]);
    }


    public function index()
    {
        $users = User::get();
        return view('admin.chat.chat', compact('users'));
    }

    public function startchat(Request $request, $id)
    {
        $users = User::get();
        $to = User::findOrFail($id);
        $from = User::findOrFail(Auth::user()->id);
        $msgs = Chat::whereIn('to_id',[$id,$from->id])->whereIn('from_id',[$id,$from->id])->get();
        //return $msgs;
        return view('admin.chat.chat', compact('users','to','from','msgs'));
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'msg' => 'required'
        ]);
        
        $msg = new Chat();
        $msg->from_id = Auth::user()->id;
        $msg->to_id = $request->to_id;
        $msg->msg = $request->msg;
        $msg->read = 0;
        $msg->save();
        return redirect()->route('chat.start',$request->to_id);
    }

}
