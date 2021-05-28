<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Brand;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function add_new()
    {
        ImageManager::cleanSession();
        $br = Brand::latest()->paginate(10);
        return view('admin-views.brand.add-new', compact('br'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Brand name is required!',
        ]);

        $x = ImageManager::upload('brand/', 'png', 'brand_image_modal');
        DB::table('brands')->insert([
            'name'       => $request->name,
            'image'      => $x['0'],
            'status'     => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Toastr::success('Brand added successfully!');
        return back();
    }

    function list() {
        $br = Brand::latest()->paginate(10);
        return view('admin-views.brand.list', compact('br'));
    }

    public function edit($id)
    {
        $b = Brand::where(['id' => $id])->first();
        return view('admin-views.brand.edit', compact('b'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Brand name is required!',
        ]);

        $b = Brand::find($id);

        $x = ImageManager::update('brand/', $b['image'], 'png', 'brand_image_modal');

        DB::table('brands')->where(['id' => $id])->update([
            'name'       => $request->name,
            'image'      => $x[0],
            'updated_at' => now(),
        ]);

        Toastr::success('Brand updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {

        $br = Brand::find($request->id);
        ImageManager::delete('/brand/' . $br['photo']);
        $br->delete();
        return response()->json();
    }
}
