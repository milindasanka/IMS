<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Payemnt;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Teacher;
use App\Models\Tute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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

    public function student($id)
    {
        $student = Student::where('id',$id)->first();
        $qr = QrCode::size(200)->generate($id);
        $class = Classes::get();
        $stclass = StudentClass::where('student_id', $id)->pluck('class_id');
        $stclasslist = Classes::whereIn('id', $stclass)->get();

        return view('list.student',['student'=>$student,'class'=>$class,'stclasslist'=>$stclasslist],compact('qr'));
    }

    public function updateStudent(Request $request)
    {
        $student = Student::where('id', $request->input('id'))->first();
        $student->name        = $request->input('name');
        $student->nic         = $request->input('nic');
        $student->cnumber     = $request->input('phone_no');
        $student->homenumber  = $request->input('home_no');
        $student->address     = $request->input('address');
        $student->save();

        return redirect()->back()->with('success', 'Student information updated successfully.');
    }

    public function stdestroy(Request $request, $id)
    {
        StudentClass::where('class_id', $id)
            ->where('student_id', $request->student_id)
            ->delete();
        return redirect()->back()->with('success', 'delete successfully.');
    }

    public function addclassstr(Request $request)
    {
        $exists = StudentClass::where('student_id', $request->id)
            ->where('class_id', $request->class)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This class is already assigned to the student.');
        }

        $stclass = new StudentClass();
        $stclass->student_id = $request->id;
        $stclass->class_id = $request->class;
        $stclass->save();

        return redirect()->back()->with('success', 'Added successfully.');
    }

    public function stxdestroy($id)
    {
        Student::where('id', $id)
            ->delete();
        return redirect()->route('Admin.student-list')->with('success', 'delete successfully.');
    }

    public function classedite($id)
    {
        $class = Classes::where('id',$id)->first();
        return view ('list.classedite',['class'=>$class]);
    }

    public function classupdate(Request $request)
    {
        $class = Classes::findOrFail($request->id);

        $class->update([
            'fee' => $request->fee,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Class updated successfully!');
    }

    public function teacher($id)
    {
        $class = DB::table('classes')
            ->select([
                'classes.class_name','classes.id',
                'classes.fee as class_fee',
                DB::raw('COUNT(DISTINCT studentclass.student_id) as student_count'),
                DB::raw('COUNT(DISTINCT payemnt.student_id) as paid_student_count')
            ])
            ->leftJoin('studentclass', 'classes.id', '=', 'studentclass.class_id')
            ->leftJoin('payemnt', function($join) {
                $join->on('classes.id', '=', 'payemnt.class_id')
                    ->where('payemnt.month', '=', now()->month); // Current month payments
            })
            ->where('classes.teacher', $id) // Filter by teacher
            ->groupBy('classes.id', 'classes.class_name', 'classes.fee')
            ->get();

        $teacher = Teacher::where('id',$id)->first();
        return view('list.teacher',['teacher'=>$teacher,'class'=>$class]);
    }

    public function update_teacher(Request $request)
    {
        $class = Teacher::findOrFail($request->id);
        $class->update([
            'name' => $request->name,
            'nic' => $request->nic,
            'cnumber' => $request->phone_no,
            'address' => $request->address,
        ]);
        return redirect()->back()->with('success', 'Class updated successfully!');
    }
}


