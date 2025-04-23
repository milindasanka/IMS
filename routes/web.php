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








