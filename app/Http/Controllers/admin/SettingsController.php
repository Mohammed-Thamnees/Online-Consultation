<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MailConfig;
use App\Models\Setting;
use App\Models\SmsConfig;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:web_settings', ['only' => ['index',
            'save','mail','mailsave','sms','smssave']]);
    }


    public function index()
    {
        $setting = Setting::orderBy('id','ASC')->first();
        return view('admin.settings.general', compact('setting'));
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'copyright' => 'required'
        ]);

        if ($request->id) {
            $setting = Setting::findOrFail($request->id);
            $setting->name = $request->name;

            if ($request->file('logo')) {
                Storage::delete('public/setting/'.$setting->logo);
                $image = $request->file('logo');
                $imagename = time() . '.' . $request->file('logo')->getClientOriginalName();
                $image->storeAs('public/setting', $imagename);
                $setting->logo = $imagename;
            }

            if ($request->file('fav_icon')) {
                Storage::delete('public/setting/'.$setting->fav_icon);
                $image = $request->file('fav_icon');
                $imagename = time() . '.' . $request->file('fav_icon')->getClientOriginalName();
                $image->storeAs('public/setting', $imagename);
                $setting->fav_icon = $imagename;
            }

            $setting->copyright = $request->copyright;
            $status = $setting->save();
        }
        else {
            $setting = new Setting();
            $setting->name = $request->name;

            if ($request->file('logo')) {
                $image = $request->file('logo');
                $imagename = time() . '.' . $request->file('logo')->getClientOriginalName();
                $image->storeAs('public/setting', $imagename);
                $setting->logo = $imagename;
            }

            if ($request->file('fav_icon')) {
                $image = $request->file('fav_icon');
                $imagename = time() . '.' . $request->file('fav_icon')->getClientOriginalName();
                $image->storeAs('public/setting', $imagename);
                $setting->fav_icon = $imagename;
            }

            $setting->copyright = $request->copyright;
            $status = $setting->save();
        }

        if ($status) {
            Toastr::success('setting saved','Success');
            return redirect()->route('settings.index');
        }
        else {
            Toastr::error('setting failed to save','Failed');
            return redirect()->route('settings.index');
        }
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('admin.settings.profile', compact('user'));
    }

    public function profilesave(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'gender' => 'required',
        ]);

        $user = User::findOrfail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->pin = $request->pin;
        $user->place = $request->place;
        $user->gender = $request->gender;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        else {
            $user->password = $user->password;
        }

        if ($request->file('image')) {
            Storage::delete('public/user/'.$user->image);
            $image = $request->file('image');
            $imagename = time() . '.' . $request->file('image')->getClientOriginalName();
            $image->storeAs('public/user', $imagename);
            $user->image = $imagename;
        }
        
        $status = $user->save();

        if ($status) {
            Toastr::success('Profile updated successfully','Success');
            return redirect()->route('profile',$id);
        }
        else {
            Toastr::error('Profile updation failed','Failed');
            return redirect()->route('profile',$id);
        }
    }

    public function mail()
    {
        $mail = MailConfig::first();
        return view('admin.settings.smtp', compact('mail'));
    }

    public function mailsave(Request $request)
    {
        $this->validate($request, [
            'driver' => 'required|string',
            'host' => 'required',
            'port' => 'required',
            'name' => 'required',
            'encryption' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($request->id) {
            $mail = MailConfig::findOrFail($request->id);
            $mail->driver = $request->driver;
            $mail->host = $request->host;
            $mail->port = $request->port;
            $mail->from = $request->from;
            $mail->name = $request->name;
            $mail->encryption = $request->encryption;
            $mail->username = $request->username;
            $mail->password = $request->password;
            $status = $mail->save();
        }
        else {
            $mail = new MailConfig();
            $mail->driver = $request->driver;
            $mail->host = $request->host;
            $mail->port = $request->port;
            $mail->from = $request->from;
            $mail->name = $request->name;
            $mail->encryption = $request->encryption;
            $mail->username = $request->username;
            $mail->password = $request->password;
            $status = $mail->save();
        }

        if ($status) {
            Toastr::success('Mail config Updated', 'Success');
            return redirect()->back();
        }
        else {
            Toastr::error('Mail config failed to Update', 'failed');
            return redirect()->back();
        }
    }

    public function sms()
    {
        $sms = SmsConfig::first();
        return view('admin.settings.sms', compact('sms'));
    }

    public function smssave(Request $request)
    {
        $this->validate($request, [
            'sid' => 'required',
            'token' => 'required',
            'from' => 'required',
        ]);

        if ($request->id) {
            $sms = SmsConfig::findOrFail($request->id);
            $sms->twilio_sid = $request->sid;
            $sms->twilio_token = $request->token;
            $sms->twilio_from = $request->from;
            $status = $sms->save();
        }
        else {
            $sms = new SmsConfig();
            $sms->twilio_sid = $request->sid;
            $sms->twilio_token = $request->token;
            $sms->twilio_from = $request->from;
            $status = $sms->save();
        }

        if ($status) {
            Toastr::success('Sms config Updated', 'Success');
            return redirect()->back();
        }
        else {
            Toastr::error('Sms config failed to Update', 'failed');
            return redirect()->back();
        }

    }

    public function testsms()
    {
        $receiverNumber = "+918111869981";
        $message = "This is testing sms from drlive.optimisttechhub.com";
  
        try {
            $sms = SmsConfig::first();
            $account_sid = $sms->twilio_sid;
            $auth_token = $sms->twilio_token;
            $twilio_number = $sms->twilio_from;
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
  
            Toastr::success('Test sms sended', 'Success');
            return redirect()->back();
  
        } catch (Exception $e) {
            /* Toastr::error('Test sms failed to send', 'Failed');
            return redirect()->back(); */
            dd("Error: ". $e->getMessage());
        }
    }

}
