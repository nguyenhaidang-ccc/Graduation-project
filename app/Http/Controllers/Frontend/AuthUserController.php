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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(){
        return view('frontend.register');
    }

    public function registerPost(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
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