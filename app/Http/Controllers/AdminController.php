<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\StudentClass;
use Carbon\Carbon;
use App\Mail\XMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class AdminController extends Controller
{
    public function Student_Register()
    {
        return view('Admin.Student_Register');
    }

    public function Class_Register()
    {
        $teachers = Teacher::get();
        return view('Admin.Class_Register',['teachers'=>$teachers]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function Teacher_Register()
    {
        return view('Admin.Teacher_Register');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * save teacher
     */
    public function saveTeacher_Register(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'nic' => 'required|string|max:20|unique:teachers,nic',
            'address' => 'required|string|max:255',
            'cnumber' => 'required|string|max:15',
            'email' => 'required|email|unique:teachers,email',
            'pw' => 'required|string|min:6',
        ]);

        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->nic = $request->nic;
        $teacher->address = $request->address;
        $teacher->cnumber = $request->cnumber;
        $teacher->email = $request->email;
        $teacher->save();

        $roleName = Role::where('id', 2)->value('name');
        $user = User::create([
            'name'=>$request->name,
            'last_name'=>'Teacher',
            'email'=>$request->email,
            'password'=>$request->pw,
            'email_verified_at'=>Carbon::today()->toDateString(),
        ]);
        $user->syncRoles($roleName);
        return redirect()->back()->with('success', 'Teacher registered successfully!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * save class
     */
    public function saveClass_Register(Request $request){
        $request->validate([
            'stream' => 'required',
            'subject' => 'required',
            'teacher' => 'required',
            'year' => 'required',
            'type' => 'required',
            'fee' => 'required',
        ]);
        $class_name = $request->subject.' '. $request->type.' '. $request->year;


        $classes = new Classes();
        $classes->stream = $request->stream;
        $classes->class_name = $class_name;
        $classes->subject = $request->subject;
        $classes->teacher = $request->teacher;
        $classes->year = $request->year;
        $classes->type = $request->type;
        $classes->fee = $request->fee;
        $classes->status = 1;
        $classes->save();

        return redirect()->back()->with('success', 'Class registered successfully!');

    }

    /**
     * @param Request $request
     * @return string
     * get class list ajax
     */
    public function getclass(Request $request)
    {
        $stream = $request->stream;
        $year = $request->year;
        if($stream === null){
            $html = '<span style="color: red;">Select Stream</span>';
        }
        $classx = Classes::where('year', $year)->where('stream', $stream)->get();

        $html = '';
        foreach ($classx as $class) {
            $html .= '<div class="form-check">
                    <input class="form-check-input" type="checkbox" name="classes[]" value="' . $class->id . '" id="checkbox-' . $class->id . '">
                    <label class="form-check-label" for="checkbox-' . $class->id . '">
                        ' . $class->class_name . ' <!-- Assuming the class has a class_name attribute -->
                    </label>
                  </div>';
        }
        if($classx->count() == 0){
            $html = '<span style="color: red;">Classes Not Found</span>';
        }

        return $html;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * register student
     */
    public function saveStudent_Register(Request $request)
    {
        $request->validate([
            'student_name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'nic' => 'required',
            'cnumber' => 'required',
            'hcnumber' => 'required',
            'stream' => 'required',
            'year' => 'required',
        ]);

        $Student = new Student();
        $Student->name = $request->student_name;
        $Student->address = $request->address;
        $Student->nic = $request->nic;
        $Student->email = $request->email;
        $Student->cnumber = $request->cnumber;
        $Student->homenumber = $request->hcnumber;
        $Student->stream = $request->stream;
        $Student->year = $request->year;
        $Student->status = 1;
        $Student->save();
        $password = Str::random(10);

        $roleName = Role::where('id', 3)->value('name');
        $user = User::create([
            'name'=>$request->student_name,
            'last_name'=>'Student',
            'email'=>$request->email,
            'password'=>$password,
            'email_verified_at'=>Carbon::today()->toDateString(),
        ]);
        $user->syncRoles($roleName);

        $students_id = Student::where('nic',$request->nic)->get();
        $checkedClasses = $request->input('classes', []);
        foreach ($checkedClasses as $key => $id){
            $stclass = new StudentClass();
            $stclass->student_id = $students_id[0]['id'];
            $stclass->class_id = $id;
            $stclass->save();
        }
        $sdata = [
                    'name' => $request->student_name,
                    'email' => $request->email,
                    'password' => $password,
                    'students_id' => $students_id[0]['id'],
                  ];
        $this->sendTestEmail($sdata);
        return redirect()->back()->with('success', 'Student registered successfully!');

    }

    /**
     * @param $sdata
     * @return string
     * send email
     */
    public function sendTestEmail($sdata)
    {
        Mail::to($sdata['email'])->send(new XMail($sdata));
        return 'Email sent successfully!';
    }



}
