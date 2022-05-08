<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function count($user)
    {
        return Notification::where('user_id',$user)->where('read',0)->count();
    }

    public static function create($user, $message)
    {
        $notification = new Notification();
        $notification->user_id = $user;
        $notification->message = $message;
        $result = $notification->save();
        return $result;
    }

}
