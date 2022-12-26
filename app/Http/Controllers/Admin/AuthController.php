<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showChangePassword()
    {
        return view('admin.auth.change-password');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:20',
            'confirm_password' => 'required|same:new_password',
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->update();
            return back()->with('success', 'Successfully changed.');
        } else {
            return back()->with('error', 'Incorrect old password.');
        }
    }
    public function showResetPassword()
    {
        return view('admin.auth.reset-password');
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user->hasRole('user')) {
            return back()->with('error', "This email doesn't user email.");
        }
        $user->password = Hash::make($request->password);
        $user->update();
        return back()->with('success', 'Successfully changed.');
    }
}