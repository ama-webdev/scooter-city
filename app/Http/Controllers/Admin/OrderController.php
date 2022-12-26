<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Booking;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
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
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Request $request, $id)
    {
        $order = Booking::with('booking_details')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function return(Request $request)
    {
        $id = $request->id;
        $order = Booking::findOrFail($id);
        foreach ($order->booking_details as $item) {
            $bike = Bike::find($item->bike_id);
            $bike->qty += $item->qty;
            $bike->update();
        }
        $order->status = 'return';
        $order->update();
        return redirect()->route('admin.orders.index');
    }
}