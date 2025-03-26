<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StudentController extends Controller
{
    public function index()
    {
        return view('studentslist');
    }

    public function students()
    {
        $users = Student::get();
        return response()->json($users);
    }
}
