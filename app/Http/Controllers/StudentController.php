<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('list.students', ['students' => $students]);
    }

    public function clases()
    {
        $clases = Classes::all();
        return view('list.classlist', ['classlist' => $clases]);
    }

    public function teachers()
    {
        $teachers = Teacher::all();
        return view('list.teachers', ['teachers' => $teachers]);
    }
}
