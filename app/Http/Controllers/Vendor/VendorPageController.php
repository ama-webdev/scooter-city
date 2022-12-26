<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorPageController extends Controller
{
    public function home(Request $request)
    {
        return view('vendor.home');
    }
}