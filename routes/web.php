<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

//Role & Permissions
Route::resource('permissions',App\Http\Controllers\PermissionController::class);
Route::get('permissions/{permissionId}/delete',[App\Http\Controllers\PermissionController::class, 'destroy']);
Route::resource('roles',App\Http\Controllers\RoleController::class)->middleware('verified');;
Route::get('roles/{roleId}/delete',[App\Http\Controllers\RoleController::class,'destroy'])->middleware('permission:delete role');
Route::get('roles/{roleId}/give-permissions',[App\Http\Controllers\RoleController::class,'addPermissionToRole']);
Route::put('roles/{roleId}/give-permissions',[App\Http\Controllers\RoleController::class,'givePermissionToRole']);
Route::resource('users',App\Http\Controllers\UserController::class)->middleware('verified');
Route::post('/users/storex', [UserController::class, 'storex'])->name('users.storex');

//Admin
Route::get('/Student_Register', [AdminController::class, 'Student_Register'])->name('Admin.Student_Register');
Route::post('/Student_Register', [AdminController::class, 'saveStudent_Register'])->name('Admin.saveStudent_Register');
Route::get('/Class_Register', [AdminController::class, 'Class_Register'])->name('Admin.Class_Register');
Route::post('/Class_Register', [AdminController::class, 'saveClass_Register'])->name('Admin.saveClass_Register');
Route::get('/Teacher_Register', [AdminController::class, 'Teacher_Register'])->name('Admin.Teacher_Register');
Route::post('/Teacher_Register', [AdminController::class, 'saveTeacher_Register'])->name('Admin.saveTeacher_Register');
Route::post('/getclass', [AdminController::class, 'getclass'])->name('Admin.getclass');

Route::get('/student-list', 'StudentController@index')->name('Admin.student-list');
Route::get('/clases-list', 'StudentController@clases')->name('Admin.clases-list');
Route::get('/teachers-list', 'StudentController@teachers')->name('Admin.teachers-list');
Route::get('/clases-view/{id}', 'StudentController@classview')->name('Admin.clases-view');
Route::get('/student-view/{id}', 'StudentController@student')->name('Admin.student-view');
Route::post('/update-student', [StudentController::class, 'updateStudent'])->name('update.student');
Route::delete('/stclasses/{id}', [StudentController::class, 'stdestroy'])->name('stclasses.destroy');
Route::post('/addclassstr',[StudentController::class, 'addclassstr']);


Route::post('class_view/addtute', [StudentController::class, 'tutestore'])->name('tute.store');
Route::get('classedite/{id}', [StudentController::class, 'classedite'])->name('classedite');
Route::put('/classupdate', [StudentController::class, 'classupdate'])->name('class.update');
Route::post('/update_teacher', [StudentController::class, 'update_teacher'])->name('teacher.update');

Route::delete('/deletetute/{id}', [StudentController::class, 'destroy'])->name('tute.destroy');
Route::get('/deletestudent/{id}', [StudentController::class, 'stxdestroy'])->name('tute.destroy');

Route::get('/teacher-view/{id}', 'StudentController@teacher')->name('Admin.teacher-view');
Route::get('/attendance/{id}', 'StudentController@attendance')->name('Admin.attendance');
Route::post('/getDetailsstu', [StudentController::class, 'getDetailsstu'])->name('get.detailstu');

Route::post('/attend', [StudentController::class, 'attend'])->name('get.attend');
Route::post('/pay', [StudentController::class, 'pay'])->name('get.pay');
Route::get('/tclases-list', 'StudentController@tclases')->name('teacher.clases-list');
Route::get('/classlist', 'StudentController@classlist')->name('classlist');
Route::get('/stclases-view/{id}', 'StudentController@stclassview')->name('stclases-view');






