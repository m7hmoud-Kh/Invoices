<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:owner');
    }

    public function index()
    {

        $roles = Role::orderBy('id', 'DESC')->get();
        return view('role.index', compact('roles'));
    }

    public function show($id)
    {
        $role = Role::find($id);
        $permission = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')->where('role_has_permissions.role_id', $id)->get();
        return view('role.show', compact('role', 'permission'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')->where('role_has_permissions.role_id', $id)->get();
        $allpermission = Permission::all();
        return view('role.edit', compact('role', 'permission', 'allpermission'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'permission' => 'required'
        ]);

        $role = Role::findById($request->role_id);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with(['edit' => 'Role has Updated']);
    }

    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->back()->with(['delete' => 'Role Deleted Successfully']);
    }

    public function create()
    {
        $permission = Permission::get();
        return view('role.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name',
            'permission' => 'required'
        ]);

        $role = Role::create([
            'name' => $request->role_name,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($request->permission);

        return redirect()->back()->with(['success' => 'Role Added Successfully']);
    }
}
