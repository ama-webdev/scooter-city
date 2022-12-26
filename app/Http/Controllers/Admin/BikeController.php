<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bike;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BikeController extends Controller
{

    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        $bikes = Bike::orderBy('id', 'desc')->paginate(10);
        return view('admin.bikes.index', compact('bikes'));
    }


    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.bikes.create', compact('brands', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
            'category' => 'required|exists:categories,id',
            'brand' => 'required|exists:brands,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'qty' => 'required|integer',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $name = $request->name;
        $desc = $request->desc;
        $category_id = $request->category;
        $brand_id = $request->brand;
        $photo = $request->photo;
        $qty = $request->qty;
        $price = $request->price;

        // store image in products folder
        $photo_name = uniqid() . date('Ymd') .  '.' . $photo->extension();
        $photo_url = "/uploads/bikes/$photo_name";
        $photo->move(public_path('/uploads/bikes/'), $photo_name);

        // insert record
        $bike = new Bike();
        $bike->name = $name;
        $bike->desc = $desc;
        $bike->category_id = $category_id;
        $bike->brand_id = $brand_id;
        $bike->photo = $photo_url;
        $bike->qty = $qty;
        $bike->price = $price;
        $bike->save();

        return redirect()->route('admin.bikes.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $bike = Bike::findOrFail($id);
        return view('admin.bikes.edit', compact('bike', 'categories', 'brands'));
    }


    public function update(Request $request, $id)
    {
        $bike = Bike::findOrFail($id);
        $old_photo = $bike->photo;
        $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
            'category' => 'required|exists:categories,id',
            'brand' => 'required|exists:brands,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'qty' => 'required|integer',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $name = $request->name;
        $desc = $request->desc;
        $category_id = $request->category;
        $brand_id = $request->brand;
        $photo = $request->photo;
        $qty = $request->qty;
        $price = $request->price;

        if ($photo) {
            // store image in products folder
            $photo_name = uniqid() . date('Ymd') .  '.' . $photo->extension();
            $photo_url = "/uploads/bikes/$photo_name";
            $photo->move(public_path('/uploads/bikes/'), $photo_name);

            // delete old image if has new image
            $old_image_url = substr($old_photo, 1);
            if (File::exists($old_image_url)) {
                File::delete($old_image_url);
            }
        } else {
            $photo_url = $old_photo;
        }

        // update record
        $bike->name = $name;
        $bike->desc = $desc;
        $bike->category_id = $category_id;
        $bike->brand_id = $brand_id;
        $bike->photo = $photo_url;
        $bike->qty = $qty;
        $bike->price = $price;
        $bike->update();
        return redirect()->route('admin.bikes.index');
    }


    public function destroy($id)
    {
        $bike = Bike::findOrFail($id);
        $bike->delete();
        $photo_url = substr($bike->photo, 1);
        if (File::exists($photo_url)) {
            File::delete($photo_url);
        }
        return redirect()->route('admin.bikes.index');
    }
}