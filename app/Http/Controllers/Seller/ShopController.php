<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function view()
    {
        // $id = Auth::id();
        $id = auth('seller')->id();
        ImageManager::cleanSession();
        $shop = Shop::where(['seller_id' => $id])->first();

        if (isset($shop) == false) {
            DB::table('shops')->insert([
                'seller_id'=>\auth('seller')->id(),
                'name'=>\auth('seller')->user()->f_name,
                'address'=>'',
                'contact'=>\auth('seller')->user()->phone,
                'image'=>'def.png',
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
            $shop = Shop::where(['seller_id' => $id])->first();
        }

        return view('seller-views.shop.shopInfo', compact('shop'));
    }

    public function edit($id)
    {
        $id = \auth('seller')->id();
        $shop = Shop::where(['seller_id' => $id])->first();

        return view('seller-views.shop.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::find($id);
        $shop->name = $request->name;
        $shop->address = $request->address;

        $shop->contact = $request->contact;

        $x = ImageManager::update('shop/', $shop->image, 'png', 'shop_image_modal');
        $shop->image = $x[0];
        $shop->save();

        Toastr::info('Shop updated successfully!');
        return redirect()->route('seller.shop.view');
    }

}
