<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    public function index(Request $request)
    {
        $users = User::with("roles")->whereHas("roles", function ($q) {
            $q->whereIn("name", ["user"]);
        })->paginate(10);
        $vendors = User::with("roles")->whereHas("roles", function ($q) {
            $q->whereIn("name", ["vendor"]);
        })->paginate(10);
        $admins = User::with("roles")->whereHas("roles", function ($q) {
            $q->whereIn("name", ["admin"]);
        })->paginate(10);
        return view('admin.users.index', compact('users', 'vendors', 'admins'));
    }

    public function create(Request $request)
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password',
            'role' => 'required|exists:roles,name',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index');
    }
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole(['admin'])) {
            return redirect()->route('admin.users.index');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();

        return redirect()->route('admin.users.index');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole(['admin'])) {
            return redirect()->route('admin.users.index');
        }
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}