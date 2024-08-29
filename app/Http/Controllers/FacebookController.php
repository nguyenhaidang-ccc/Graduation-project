<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $token = $user->token; 

        session(['facebook_token' => $token]); 

       
    
    }

public function shareToFacebook(Request $request)
    {
        $token = session('facebook_token'); 
    $postId = $request->input('post_id'); 
    $postUrl = url('/posts/' . $postId); 

    try {
        $response = Http::withToken($token)->post('https://www.facebook.com/', [
            'link' => $postUrl,
            'message' => 'See my new article on the website!',
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'The article has been shared on Facebook!');
        } else {
            
            return redirect()->back()->with('error', 'Posts cannot be shared to Facebook.');
        }
    } catch (\Exception $e) {
       
        return redirect()->back()->with('error', 'An error occurred while sharing the article.');
    }

}
}