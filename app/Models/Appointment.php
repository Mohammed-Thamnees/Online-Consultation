<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function prescription()
    {
        return $this->hasMany(Prescription::class, 'appointment_id','id');
    }

    public static function expectedtime($appointment_id,$doctor_id, $day)
    {
        $appointment = Appointment::where('id',$appointment_id)->first();
        $available = DoctorAvailability::where('doctor_id',$doctor_id)->where('day',$day)->where('status',1)->first();
        $start_time = Carbon::createFromFormat('H:i', $available->start_time);
        $end_time = Carbon::createFromFormat('H:i', $available->end_time);
        $timediff = $end_time->diffInMinutes($start_time);
        $per_person = $timediff / $available->sit_quantity;
        $time = $per_person * ($appointment->token_no - 1);
        $cal1 = $start_time->addMinutes($time);
        $exp1 = $cal1->format('h:i A');
        $exp2 = $cal1->addMinutes(10)->format('h:i A');
        return $exp1.' to '.$exp2;
    }

    public static function totalappointments($doctor_id)
    {
        return Appointment::where('doctor_id',$doctor_id)->count();
    }

    public static function todayappointments($doctor_id)
    {
        $today = Carbon::now()->format('Y-m-d');
        return Appointment::where('doctor_id',$doctor_id)->where('date',$today)->count();
    }

}
