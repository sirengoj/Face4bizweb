<?php

namespace App\Http\Controllers;

use App\Model\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function update_software_index(){
        return view('update.update-software');
    }

    public function update_software(){
        Artisan::call('migrate');
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        if (BusinessSetting::where(['type' => 'razor_pay'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'razor_pay',
                'value' => '{"status":"1","razor_key":"","razor_secret":""}'
            ]);
        }

        return redirect('/admin/auth/login');
    }
}
