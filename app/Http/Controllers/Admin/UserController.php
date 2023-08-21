<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::orderByDesc('id')->paginate(5);
        return view('admin.user.list', compact('users'));
    }

    public function handleStatus(User $user, Request $request){
        $status = $request->input('status');
        if($status == 1){
            $user->status = 0;
        }
        else{
            $user->status = 1;
        }
        $user->save();
        return redirect()->back()->with('success', 'User status change successful.');
    }
}