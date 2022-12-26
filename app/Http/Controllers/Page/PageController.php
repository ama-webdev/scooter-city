<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome(Request $request)
    {
        return view('page.welcome');
    }
    public function chooseType(Request $request)
    {
        return view('page.choose-type');
    }

    public function userRegister()
    {
        return view('auth.user-register');
    }
}