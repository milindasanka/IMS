<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index(){
        $users = User::get();
        $roles = Role::get();
        return view('role-permission.user.index',['users'=>$users,'roles'=>$roles]);
    }
    public function create(){
        $roles = Role::pluck('name','name')->all();
        return view('role-permission.user.create',['roles'=>$roles]);
    }
    public function store(Request $request){
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $user->syncRoles($request->roles);
        return redirect('/users')->with('status','User Created Success with role');
    }
    public function update(Request $request, User $user){
            $roleName = Role::where('id', $request->role)->value('name');
            if ($request->status == 'active') {
                $status = Carbon::now();
            } else {
                $status = null;
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'last_name' => $request->last_name,
                'email_verified_at' => $status,
            ];
            $user->update($data);
            $user->syncRoles($roleName);
        return redirect('/users')->with('status','User Updated!');
    }
    public function passwordreset(Request $request){
        $user = User::find($request->user_id);
        $user->resetPassword($request->password);
        return redirect('/users')->with('status','Password Reset Successfully!');
    }
    public function destroy($userID){
        $user = User::findOrFail($userID);
        $user->delete();
        return redirect('/users')->with('status','User Delete Success');
    }

    public function storex(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'nullable|string|max:14',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:6',
                    'role' => 'required|exists:roles,id',
                    'status' => 'required|in:active,inactive',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                if ($request->status == 'active') {
                    $status = Carbon::now();
                } else {
                    $status = null;
                }
                $roleName = Role::where('id', $request->role)->value('name');
                $user = User::create([
                    'name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                    'email_verified_at'=>$status,
                ]);
                $user->syncRoles($roleName);

                return response()->json(['success' => true, 'message' => 'User added successfully!']);
    }

}
