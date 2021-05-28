<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function view()
    {
        ImageManager::cleanSession();
        $data = Admin::where('id', auth('admin')->id())->first();
        return view('admin-views.profile.view', compact('data'));
    }

    public function edit($id)
    {
        $data = Admin::where('id', $id)->first();
        return view('admin-views.profile.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->email = $request->email;

        $x = ImageManager::update('admin/', $admin->image, 'png', 'profile_image_modal');
        $admin->image = $x[0];
        $admin->save();

        Toastr::info('Profile updated successfully!');
        return back();
    }
    public function settings_password_update(Request $request)
    {
        $request->validate([
            'password'         => 'required|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        $admin = Admin::find(auth('admin')->id());
        $admin->password = bcrypt($request['password']);
        $admin->save();
        Toastr::success('Admin password updated successfully!');
        return back();
    }

}
