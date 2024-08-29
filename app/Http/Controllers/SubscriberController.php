<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        
        return back()->with('success', 'Thank you for subscribing to our service!');
    }
}
