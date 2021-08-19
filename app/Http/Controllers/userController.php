<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class userController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:owner');
    }

    public function index()
    {
        $data = User::orderBy('id', 'DESC')->get();
        return view('users.show_user', compact('data'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::select('id', 'name')->get();
        return view('users.edit_user', compact('user', 'roles'));
    }

    public function create()
    {
        $roles =  Role::all();
        return view('users.create_user', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'role' => 'required'
        ]);

        $request->password = Hash::make($request->password);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'roles_name' => $request->role,
            'Status' => $request->Status
        ]);

        $user->assignRole($request->role);

        return redirect()->back()->with(['success' => 'User add successfully..!']);
    }

    public function destory(Request $request)
    {

        $user =  User::find($request->user_id);
        $user->delete();
        return redirect()->back()->with(['Delete' => 'User Delete successfully..!']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'password' => 'same:confirm-password',
            'role' => 'required'
        ]);
        if (!empty($request->password)) {
            $request->password = Hash::make($request->password);
            $user = User::find($request->user_id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'Status' => $request->Status,
                'roles_name' => $request->role,
                'password' => $request->password
            ]);
        } else {
            $user = User::find($request->user_id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'Status' => $request->Status,
                'roles_name' => $request->role,
            ]);
        }

        DB::table('model_has_roles')->where('model_id', $request->user_id)->delete();
        $user->assignRole($request->role);
        return redirect()->back()->with(['update' => 'User Updated Successsfully']);
    }
}
