<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//authentication
Route::post('/login', [App\Http\Controllers\api\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\api\AuthController::class, 'register']);

Route::group(['middleware'=>'auth:api'], function () {
    //Doctors section
    Route::get('/category', [App\Http\Controllers\api\DoctorSectionController::class, 'category']);
    Route::post('/findcategory', [App\Http\Controllers\api\DoctorSectionController::class, 'findcategory']);
    Route::get('/doctors', [App\Http\Controllers\api\DoctorSectionController::class, 'doctors']);
    Route::post('/finddoctor', [App\Http\Controllers\api\DoctorSectionController::class, 'finddoctor']);
    //story section
    Route::get('/stories', [App\Http\Controllers\api\StoryController::class, 'stories']);
    Route::get('/stories/active', [App\Http\Controllers\api\StoryController::class, 'activestories']);
    Route::post('/stories/user', [App\Http\Controllers\api\StoryController::class, 'userstories']);
    //User Section
    Route::post('/user/profile', [App\Http\Controllers\api\UserController::class, 'profiledetail']);
    Route::post('/user/update', [App\Http\Controllers\api\UserController::class, 'profileupdate']);
    //Appointment Section
    Route::post('/appointment/submit', [App\Http\Controllers\api\AppointmentController::class, 'appointmentsubmit']);
    Route::post('/appointments/today', [App\Http\Controllers\api\AppointmentController::class, 'todayappointment']);
    Route::post('/patient/active/history', [App\Http\Controllers\api\AppointmentController::class, 'patientactivehistory']);
    Route::post('/patient/past/history', [App\Http\Controllers\api\AppointmentController::class, 'patientpasthistory']);
    Route::post('/doctor/active/history', [App\Http\Controllers\api\AppointmentController::class, 'doctoractivehistory']);
    Route::post('/doctor/past/history', [App\Http\Controllers\api\AppointmentController::class, 'doctorpasthistory']);
    //Banner Section
    Route::get('/banners/list', [App\Http\Controllers\api\BannerController::class, 'list']);
    //Leave Section
    Route::get('/leave/type', [App\Http\Controllers\api\LeaveController::class, 'types']);
    Route::post('/leave/register', [App\Http\Controllers\api\LeaveController::class, 'register']);
    Route::post('/leave/all', [App\Http\Controllers\api\LeaveController::class, 'all']);
    Route::post('/leave/awaiting', [App\Http\Controllers\api\LeaveController::class, 'awaiting']);
    Route::post('/leave/approved', [App\Http\Controllers\api\LeaveController::class, 'approved']);
    //notification section
    Route::post('/notification', [App\Http\Controllers\api\NotificationController::class, 'list']);
    //Chat section
    Route::post('/chat', [App\Http\Controllers\api\ChatController::class, 'chat']);
    Route::post('/chat/user', [App\Http\Controllers\api\ChatController::class, 'specificchat']);
    Route::post('/chat/send', [App\Http\Controllers\api\ChatController::class, 'send']);
    Route::post('/chat/last', [App\Http\Controllers\api\ChatController::class, 'lastchat']);


});