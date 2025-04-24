<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Payemnt;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Teacher;
use App\Models\Tute;
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

    public function classview($id)
    {
        $month = now()->month;
        $clases = Classes::where('id',$id)->first();
        $tutes = Tute::where('class_id',$id)->get();
        $studentData = StudentClass::where('class_id', $id)->with('student')->get()->pluck('student');
        $paymentcount = Payemnt::where('class_id',$id)->where('month',$month)->count();
        return view('list.class',['class'=>$clases,'tutes'=>$tutes,'studentData'=>$studentData,'paymentcount'=>$paymentcount]);
    }

    public function tutestore(Request $request)
    {
        if ($request->hasFile('tute')) {
            $file = $request->file('tute');
            $path = $file->store('tutes', 'public');

            Tute::create([
                'class_id' => $request->class_id,
                'name' => $request->tute_name,
                'file' => $path,
            ]);

            return back()->with('success', 'Tute added successfully!');
        }
        return back()->withErrors(['tute' => 'File upload failed.']);
    }

    public function destroy($id)
    {
        $tute = Tute::findOrFail($id);

        if ($tute->file_path && Storage::disk('public')->exists($tute->file_path)) {
            Storage::disk('public')->delete($tute->file_path);
        }

        $tute->delete();

        return back()->with('success', 'Tute deleted successfully.');
    }

}
