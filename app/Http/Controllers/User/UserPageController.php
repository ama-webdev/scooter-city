<?php

namespace App\Http\Controllers\User;

use App\Helper\DATE;
use App\Helper\UUID;
use App\Models\Bike;
use App\Models\User;
use App\Models\Brand;
use App\Models\Booking;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\BookingDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserPageController extends Controller
{

    public function about()
    {
        return view('user.about');
    }

    public function bikes(Request $request)
    {
        $name = $request->model;
        $cat_id = $request->cat;
        $brand_id = $request->brand;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $categories = Category::all();
        $brands = Brand::all();
        $bikes = Bike::orderBy('id', 'desc')
            ->where('qty', '>', 0)
            ->when($name, function ($query, $name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            })->when($cat_id, function ($query, $cat_id) {
                $query->where('category_id', $cat_id);
            })->when($brand_id, function ($query, $brand_id) {
                $query->where('brand_id', $brand_id);
            })->when($min_price, function ($query, $min_price) {
                $query->where('price', '>=', $min_price);
            })->when($max_price, function ($query, $max_price) {
                $query->where('price', '<=', $max_price);
            })
            ->paginate(12);
        return view('user.bikes', compact('bikes', 'categories', 'brands'));
    }

    public function bikeDetail(Request $request, $id)
    {
        $bike = Bike::findOrFail($id);
        return view('user.bike-detail', compact('bike'));
    }

    public function cart(Request $request)
    {
        return view('user.cart');
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'end_date' => 'required|after:now',
            'nrc' => 'required|string',
            'address' => 'required|string',
            'remark' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $bikes = json_decode($request->cart);
        $end_date = $request->end_date;
        $nrc = $request->nrc;
        $remark = $request->remark;
        $address = $request->address;
        $code = UUID::generate();
        $total_bikes = 0;
        $dateCount = DATE::duration(now(), $end_date);
        $total = 0;

        foreach ($bikes as $bike) {
            $total_bikes += $bike->qty;
            $total += $bike->qty * $bike->price;
        }
        DB::beginTransaction();
        try {
            foreach ($bikes as $bike) {
                $main_bike = Bike::find($bike->id);
                if ($main_bike->qty < $bike->qty) {
                    return response(['errors' => ["$main_bike->name is only left $main_bike->qty."]], 422);
                }
            }

            $booking = new Booking();
            $booking->code = $code;
            $booking->user_id = Auth::user()->id;
            $booking->start_date = now();
            $booking->end_date = $end_date;
            $booking->status = 'booking';
            $booking->nrc = $nrc;
            $booking->address = $address;
            $booking->remark = $remark;
            $booking->total = $total * $dateCount;
            $booking->qty = $total_bikes;
            $booking->save();

            foreach ($bikes as $bike) {
                $main_bike = Bike::find($bike->id);
                $main_bike->qty -= $bike->qty;
                $main_bike->update();

                $detail = new BookingDetail();
                $detail->booking_id = $booking->id;
                $detail->bike_id = $bike->id;
                $detail->qty = $bike->qty;
                $detail->total = $bike->price * $bike->qty;
                $detail->save();
            }
            DB::commit();
            return response(['data' => ['code' => $code]], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['errors' => [$e->getMessage()]], 422);
        }
    }

    public function orderList(Request $request)
    {
        $status = $request->status;
        $orders = Booking::where('user_id', Auth::user()->id)
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('user.order-list', compact('orders'));
    }

    public function orderDetail(Request $request, $id)
    {
        $order = Booking::with('booking_details')->findOrFail($id);
        return view('user.order-detail', compact('order'));
    }
    public function showChangePassword()
    {
        return view('user.change-password');
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
}