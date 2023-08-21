<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthUserController extends Controller
{
    public function login(){
        return view('frontend.login');
    }

    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required', 'email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'status' => 1
        ])){
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'status' => 'The provided credentials do not match or your account has been locked.',
        ]);
    }

    public function register(){
        return view('frontend.register');
    }

    public function registerPost(Request $request){
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required:6',
        ]);

        $user = User::create($validated);
        if($user){
            return redirect()->route('login')->with('success', 'Successful account registration.');
        }
        
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}