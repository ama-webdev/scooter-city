<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bike;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\User;

class AdminPageController extends Controller
{
    public function dashboard(Request $request)
    {
        $order_count = Booking::where('status', 'booking')->get()->count();
        $bike_count = Bike::all()->count();
        $brand_count = Brand::all()->count();
        $user_count = User::all()->count();
        $status = $request->status;
        $code = $request->code;

        $orders = Booking::orderBy('id', 'desc')
            ->when($code, function ($query, $code) {
                $query->where('code', $code);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->paginate(10);
        return view('admin.dashboard', compact('order_count', 'bike_count', 'brand_count', 'user_count', 'orders'));
    }
}