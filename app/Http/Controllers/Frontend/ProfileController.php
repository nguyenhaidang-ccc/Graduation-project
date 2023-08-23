<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile(){
        return view('frontend.profile');
    }

    public function update(Request $request){
        $user = \Auth::user();
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
}
