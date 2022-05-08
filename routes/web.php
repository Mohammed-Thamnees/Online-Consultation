<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Authentication Routes
Auth::routes();
Route::redirect('/','/loginform');
Route::get('/loginform', [App\Http\Controllers\HomeController::class, 'login'])->name('login.form');
Route::get('/phone/login', [App\Http\Controllers\HomeController::class, 'phonelogin'])->name('phone.login.form');
Route::post('/loginform/submit', [App\Http\Controllers\HomeController::class, 'loginsubmit'])->name('login.form.submit');
Route::get('/userlogout', [App\Http\Controllers\HomeController::class, 'logout'])->name('user.logout');

//Admin Routes
Route::group(['prefix'=>'admin', 'middleware'=>['auth']], function () {

    //dashboard
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //Appointments Section
    Route::resource('/appointment', App\Http\Controllers\admin\AppointmentsController::class);
    Route::get('/appointments/history', [App\Http\Controllers\admin\AppointmentsController::class, 'history'])->name('appointments.history');
    Route::get('/appointments/today', [App\Http\Controllers\admin\AppointmentsController::class, 'today'])->name('appointments.today');
    Route::get('/prescription/mail/{id}', [App\Http\Controllers\admin\AppointmentsController::class, 'prescriptionmail'])->name('mail.prescription');
    //user management
    Route::resource('/roles', App\Http\Controllers\admin\RoleController::class);
    Route::resource('/users', App\Http\Controllers\admin\UserController::class);
    Route::get('/role/lists', [App\Http\Controllers\admin\AssignPermissionController::class, 'index'])->name('role.lists');
    Route::get('/role/permission/{id}', [App\Http\Controllers\admin\AssignPermissionController::class, 'rolepermission'])->name('role.permission');
    Route::post('/role/permission/assign', [App\Http\Controllers\admin\AssignPermissionController::class, 'rolepermissionassign'])->name('role.permission.assign');
    //Doctor section
    Route::resource('/category', App\Http\Controllers\admin\CategoryController::class);
    Route::resource('/doctor', App\Http\Controllers\admin\DoctorController::class);
    Route::resource('/timeslots', App\Http\Controllers\admin\TimeSlotController::class);
    Route::resource('/availability', App\Http\Controllers\admin\DoctorAvailabilityController::class);
    Route::resource('/fees', App\Http\Controllers\admin\DoctorFeesController::class);
    //Medicines Section
    Route::resource('/medicinetype', App\Http\Controllers\admin\MedicineTypeController::class);
    Route::resource('/medicine', App\Http\Controllers\admin\MedicineController::class);
    //General Options
    Route::resource('/banners', App\Http\Controllers\admin\BannerController::class);
    Route::resource('/story', App\Http\Controllers\admin\StoriesController::class);
    Route::resource('/complaint', App\Http\Controllers\admin\ComplaintController::class);
    Route::post('/attach/download/{id}', [App\Http\Controllers\admin\ComplaintController::class, 'attachdownload'])->name('attach.download');
    Route::post('/reply/attach/download/{id}', [App\Http\Controllers\admin\ComplaintController::class, 'replyattachdownload'])->name('reply_attach.download');
    Route::post('/reply/{id}', [App\Http\Controllers\admin\ComplaintController::class, 'reply'])->name('complaint.reply');
    Route::get('/chat', [App\Http\Controllers\admin\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/start/{id}', [App\Http\Controllers\admin\ChatController::class, 'startchat'])->name('chat.start');
    Route::post('/chat/send', [App\Http\Controllers\admin\ChatController::class, 'send'])->name('chat.send');
    //leave management
    Route::resource('/leave', App\Http\Controllers\admin\LeaveController::class);
    Route::resource('/leavedefine', App\Http\Controllers\admin\LeavedefineController::class);
    Route::resource('/leaveapprove', App\Http\Controllers\admin\Approve_leave::class);
    Route::get('/storeapprovestatus/{status}',[Approve_leave::class,'approvestatus'])->name('store.approvestatus');
    Route::get('/storedeclinestatus/{status}',[Approve_leave::class,'declinestatus'])->name('store.declinestatus');
    Route::get('/storeapprovestatuspending/{status}',[PendingLeave::class,'approvependingstatus'])->name('store.approvependingstatus');
    Route::get('/storedeclinestatuspending/{status}',[PendingLeave::class,'declinependingstatus'])->name('store.declinependingstatus');
    Route::resource('/pendingleaves',App\Http\Controllers\admin\PendingLeave::class);
    //Web Settings
    Route::get('/settings/index', [App\Http\Controllers\admin\SettingsController::class, 'index'])->name('settings.index');
    Route::any('/settings/save', [App\Http\Controllers\admin\SettingsController::class, 'save'])->name('settings.save');
    Route::get('/profile/{id}', [App\Http\Controllers\admin\SettingsController::class, 'profile'])->name('profile');
    Route::any('/profile/save/{id}', [App\Http\Controllers\admin\SettingsController::class, 'profilesave'])->name('profile.save');
    Route::get('/settings/mail', [App\Http\Controllers\admin\SettingsController::class, 'mail'])->name('settings.smtp');
    Route::any('/settings/mail/save', [App\Http\Controllers\admin\SettingsController::class, 'mailsave'])->name('mail.save');
    Route::get('/settings/sms', [App\Http\Controllers\admin\SettingsController::class, 'sms'])->name('settings.sms');
    Route::any('/settings/sms/save', [App\Http\Controllers\admin\SettingsController::class, 'smssave'])->name('sms.save');
    //test sms
    Route::get('/test/sms', [App\Http\Controllers\admin\SettingsController::class, 'testsms'])->name('test.sms');
    //Notification
    Route::resource('/notification',App\Http\Controllers\admin\NotificationController::class);

});


//Ajax Routes
Route::get('/getdoctors', [App\Http\Controllers\admin\AjaxController::class, 'getdoctors']);
Route::get('/getmedicinetypes', [App\Http\Controllers\admin\AjaxController::class, 'medicinetypes']);
Route::get('/getmedicines', [App\Http\Controllers\admin\AjaxController::class, 'medicines']);
Route::get('/getuser', [App\Http\Controllers\admin\AjaxController::class, 'loginphone']);
Route::post('/phonelogin', [App\Http\Controllers\admin\AjaxController::class, 'phonelogin']);