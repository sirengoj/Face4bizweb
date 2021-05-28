<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    function list() {
        ImageManager::cleanSession();
        $banners = \App\Model\Banner::orderBy('id', 'desc')->paginate(10);
        return view('admin-views.banner.view', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',

        ], [
            'url.required' => 'url is required!',

        ]);
        $bannerType = $request->banner_type;
        $banner = new Banner;
        $banner->banner_type = $bannerType;
        $banner->url = $request->url;
        if ($bannerType == "Main Banner") {
            $x = ImageManager::upload('banner/', 'png', 'main_banner_image_modal');
            $banner->photo = $x[0];
        } elseif ($bannerType == "Footer Banner") {
            $x = ImageManager::upload('banner/', 'png', 'secondary_banner_image_modal');
            $banner->photo = $x[0];
        } else {
            $x = ImageManager::upload('banner/', 'png', 'popup_banner_image_modal');
            $banner->photo = $x[0];
        }
        $banner->save();
        Toastr::success('Banner added successfully!');
        return back();
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $banner = Banner::find($request->id);
            $banner->published = $request->status;
            $banner->save();
            $data = $request->status;
            return response()->json($data);
        }
    }

    public function edit(Request $request)
    {
        $data = Banner::where('id', $request->id)->first();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        // dd($request->id)->toArray();
        $request->validate([
            'url' => 'required',

        ], [
            'url.required' => 'url is required!',

        ]);
        $banner = Banner::find($request->id);

        $bannerType = $request->banner_type;

        $banner->banner_type = $bannerType;
        $banner->url = $request->url;
        if ($bannerType == "Main Banner") {
            $x = ImageManager::update('banner/', $banner['photo'], 'png', 'main_banner_image_modal');
            $banner->photo = $x[0];

        } elseif ($bannerType == "Footer Banner") {
            $x = ImageManager::update('banner/', $banner['photo'], 'png', 'secondary_banner_image_modal');
            $banner->photo = $x[0];
        } else {
            $x = ImageManager::update('banner/', $banner['photo'], 'png', 'popup_banner_image_modal');
            $banner->photo = $x[0];
        }
        $banner->save();

        return response()->json();
    }

    public function delete(Request $request)
    {

        $br = Banner::find($request->id);
        ImageManager::delete('/banner/' . $br['photo']);
        $br->delete();
        return response()->json();
    }
}
