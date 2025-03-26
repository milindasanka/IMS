<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
   function index(){
       $permissions = Permission::get();
       return view('role-permission.permission.index', ['permissions'=>$permissions]);
   }
   function create(){
       return view('role-permission.permission.create');
   }
   function store(Request $request){
       $request->validate([
           'name'=>['required','string','unique:permissions,name']
       ]);
       Permission::create([
           'name' => $request->name
       ]);
       return redirect('permissions')->with('status','Permission Created Success');
   }
   function edit(Permission $permission){
       return view('role-permission.permission.edit',['permission'=>$permission]);
   }
   function update(Request $request, Permission $permission){
       $request->validate([
           'name'=>['required','string','unique:permissions,name']
       ]);
       $permission->update([
           'name' => $request->name
       ]);
       return redirect('permissions')->with('status','Permission Updated Success');
   }
   function destroy($permissionId){
       $permission = Permission::find($permissionId);
       $permission->delete();
       return redirect('permissions')->with('status','Permission Deleted Success');
   }
}
