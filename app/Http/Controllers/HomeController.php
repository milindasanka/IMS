<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $student = Student::count();
        $class = Classes::count();
        $teachers = Teacher::count();

        $list = Classes::get();
        $widget = [
            'students' => $student,
            'class' => $class,
            'teachers' => $teachers,
        ];

        return view('home', compact('widget'),['list'=>$list]);
    }
}
