<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class AppointmentController extends Controller
{
    //submit appointment
    public function appointmentsubmit(Request $request)
    {
        $category_id = $request->category_id;
        $doctor_id = $request->doctor_id;
        $date  = $request->date;
        $method  = $request->method;
        $patient_id = $request->patient_id;

        if ($category_id==NULL || $doctor_id==NULL || $patient_id==NULL || $date==NULL ||$method==NULL) {
            return response()->json([
                'result' => false,
                'message' => 'please input all necessary fields',
            ],404);
        }
        $day = Carbon::parse($date)->format('D');

        $exist = Appointment::where('date',$date)->where('category_id',$category_id)
            ->where('doctor_id',$doctor_id)->orderBy('token_no','DESC')->first();

        $available = DoctorAvailability::where('doctor_id',$doctor_id)->where('day',$day)
            ->where('status',1)->first();

        if (!$available) {
            return response()->json([
                'result' => false,
                'message' => 'doctor is not aavailable for this day',
            ],404);
        }
        else {
            if (!$exist) {
                $token = 1;
            }
            else {
                if ($exist->token_no == $available->sit_quantity) {
                    return response()->json([
                        'result' => false,
                        'message' => 'appointments are full for the selected date',
                    ],404);
                }
                else {
                    $token = $exist->token_no + 1;
                }
            }
        }

        $appointment = new Appointment();
        $appointment->user_id = $patient_id;
        $appointment->category_id = $category_id;
        $appointment->doctor_id = $doctor_id;
        $appointment->date = $date;
        $appointment->method = $method;
        $appointment->payment_status = 'unpaid';
        $appointment->status = 'new';
        $appointment->token_no = $token;
        $status = $appointment->save();

        $last = Appointment::orderBy('created_at','DESC')->first();
        $patient = User::where('id',$last->user_id)->first();
        $doctor = Doctor::with('doctordetails')->where('id',$last->doctor_id)->first();
        $category = Category::where('id',$last->category_id)->first();

        if ($status) {
            Notification::create($patient_id, 'appointment done');
            Notification::create($appointment->doctor->doctordetails->id, 'new appointment recieved');
            return response()->json([
                'result' => true,
                'message' => 'appointtment success',
                'appointment' => $last,
                'category' => $category,
                'doctor' => $doctor,
                'patient' => $patient
            ],200);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'appointment failed',
            ],404);
        }
    }

    //todays appointment for doctors
    public function todayappointment(Request $request)
    {
        $date = Carbon::now()->format('d');
        $doctor_id = $request->doctor_id;

        if ($doctor_id == NULL) {
            return response()->json([
                'result' => false,
                'message' => 'doctor id is not provided',
            ],404);
        }

        $appointment = Appointment::with('category','patient')->whereDay('date',$date)
                        ->where('doctor_id',$doctor_id)->get();

        foreach ($appointment as $app) {
            $time[] = Appointment::expectedtime($app->id,$app->doctor_id,Carbon::parse($app->date)->format('D'));
        }
        
        return response()->json([
            'result' => true,
            'appointments' => $appointment,
            'time' => $time,
            'patient image path' =>'/storage/user/',
        ],200);
    }

    //patient active history(current month)
    public function patientactivehistory(Request $request)
    {
        $date = Carbon::now()->format('m');
        $patient_id = $request->patient_id;

        if ($patient_id == NULL) {
            return response()->json([
                'result' => false,
                'message' => 'patient id is not provided'
            ],404);
        }

        $history = Appointment::with('category','doctor')->whereMonth('date',$date)->where('user_id',$patient_id)->get();

        foreach ($history as $app) {
            $time[] = Appointment::expectedtime($app->id,$app->doctor_id,Carbon::parse($app->date)->format('D'));
        }

        return response()->json([
            'result' => true,
            'appointments' => $history,
            'time' => $time
        ],200);
    }

    //patient past history(full history)
    public function patientpasthistory(Request $request)
    {
        $patient_id = $request->patient_id;
        $from = $request->from_date;
        $to = $request->to_date;
        $search = $request->search;

        if ($patient_id == Null) {
            return response()->json([
                'result' => false,
                'message' => 'patient id is not provided'
            ],404);
        }
        
        $appointment = Appointment::query();

        if ($from) {
            $appointment->where('date','>=',$from);
        }

        if ($to) {
            $appointment->where('date','<=',$to);
        }

        $appointment->join('doctors','doctors.id','=','appointments.doctor_id')
                        ->join('users','users.id','=','doctors.user_id');

        if ($search) {
            $appointment->where('users.first_name','LIKE','%'.$search.'%');
        }

        $result = $appointment->with('category')->where('appointments.user_id',$patient_id)
                ->select('appointments.*','users.first_name','users.last_name','users.phone','users.email')->get();

        if ($result) {
            foreach ($result as $app) {
                $time[] = Appointment::expectedtime($app->id,$app->doctor_id,Carbon::parse($app->date)->format('D'));
            }
        }

        return response()->json([
            'result' => true,
            'appointments' => $result,
            'time' => $time ?? ''
        ],200);
    }

    //doctors active history(curret month)
    public function doctoractivehistory(Request $request)
    {
        $date = Carbon::now()->format('m');
        $doctor_id = $request->doctor_id;

        if ($doctor_id == NULL) {
            return response()->json([
                'result' => false,
                'message' => 'doctor id is not provided'
            ],404);
        }

        $history = Appointment::with('category','patient')->whereMonth('date',$date)->where('doctor_id',$doctor_id)->get();

        if ($history) {
            foreach ($history as $app) {
                $time[] = Appointment::expectedtime($app->id,$app->doctor_id,Carbon::parse($app->date)->format('D'));
            }
        }

        return response()->json([
            'result' => true,
            'appointments' => $history,
            'time' => $time ?? ''
        ],200);
    }

    //doctor past history (full history)
    public function doctorpasthistory(Request $request)
    {
        $doctor_id = $request->doctor_id;
        $from = $request->from_date;
        $to = $request->to_date;
        $search = $request->search;

        if ($doctor_id == Null) {
            return response()->json([
                'result' => false,
                'message' => 'doctor id is not provided'
            ],404);
        }
        
        $appointment = Appointment::query();

        if ($from) {
            $appointment->where('date','>=',$from);
        }

        if ($to) {
            $appointment->where('date','<=',$to);
        }

        $appointment->join('users','users.id','=','appointments.user_id');

        if ($search) {
            $appointment->where('users.first_name','LIKE','%'.$search.'%');
        }

        $result = $appointment->with('category')->where('appointments.doctor_id',$doctor_id)
                ->select('appointments.*','users.first_name','users.last_name','users.phone','users.email')->get();

        if ($result) {
            foreach ($result as $app) {
                $time[] = Appointment::expectedtime($app->id,$app->doctor_id,Carbon::parse($app->date)->format('D'));
            }
        }

        return response()->json([
            'result' => true,
            'appointments' => $result,
            'time' => $time ??  ''
        ],200);
    }

}
