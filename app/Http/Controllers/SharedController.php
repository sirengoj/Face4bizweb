<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SharedController extends Controller
{
    public function imageUpload(Request $request)
    {
        $remove_route = url('/') . '/image-remove';
        $i = ImageManager::keepInSession($request->image, $remove_route, $request->folder, !$request->multi_image);
        return response()->json($i);
    }

    public function imageRemove($id, $folder)
    {
        $r = ImageManager::removeFromSession($id, $folder);
        return response()->json($r);
    }

    public function lang($locale)
    {
        App::setLocale($locale);
        session()->forget('language_settings');
        Helpers::language_load();
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
