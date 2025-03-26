<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function index(){
            $roles = Role::get();
            //dd($roles);
            return view('role-permission.role.index', ['roles'=>$roles]);
        }
        function create(){
            return view('role-permission.role.create');
        }
        function store(Request $request){
            $request->validate([
                'name'=>['required','string','unique:roles,name']
            ]);
            Role::create([
                'name' => $request->name
            ]);
            return redirect('roles')->with('status','Role Created Success');
        }
        function edit(Role $role){
            return view('role-permission.role.edit',['role'=>$role]);
        }
        function update(Request $request, Role $role){
            $request->validate([
                'name'=>['required','string','unique:roles,name']
            ]);
            $role->update([
                'name' => $request->name
            ]);
            return redirect('roles')->with('status','Role Updated Success');
        }
        function destroy($roleId){
            $role = Role::find($roleId);
            $role->delete();
            return redirect('roles')->with('status','Role Deleted Success');
        }
        function addPermissionToRole($roleId){
            $permissions = Permission::get();
            $role = Role::findOrFail($roleId);
            $rolePermissions = DB::table('role_has_permissions')
                ->where('role_has_permissions.role_id', $roleId)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();
            return view('role-permission.role.add-permissions',['role'=>$role , 'permissions'=>$permissions , 'rolePermissions'=>$rolePermissions]);
        }
        function givePermissionToRole(Request $request,$roleID){
            $request->validate([
                'permission' => 'required'
            ]);
            $role = Role::findOrFail($roleID);
            $role->syncPermissions($request->permission);
            return redirect()->back()->with('status','Permission added to role');
        }
}
