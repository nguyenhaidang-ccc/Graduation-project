<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Hash;

class ProfileController extends Controller
{
    public function profile(){
        return view('frontend.profile');
    }

    public function update(Request $request){
        $user = \Auth::guard('web')->user();
        if($request->avatar){
            $file = $request->avatar;
            $imageName = $file->hashName();
            $res = $file->storeAs('uploads/user', $imageName, 'public');
            if($res){
                $user->avatar = 'uploads/user/' . $imageName;
            }
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        
        return redirect()->back()->with('success', 'Update profile successful.');
    }

    public function changePassword(){
        return view('frontend.change-password');
    }

    public function changePasswordPost(Request $request){
        $user = \Auth::guard('web')->user();

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Update password successfully.');

    }
}
