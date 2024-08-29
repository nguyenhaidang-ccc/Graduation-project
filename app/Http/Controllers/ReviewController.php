<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rate' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to leave a review.');
        }

       
        $review = new ProductReview();
        $review->product_id = $validatedData['product_id'];
        $review->content = $validatedData['message'];
        $review->rate = $validatedData['rate'];
        $review->user_id = auth()->user()->id;
        $review->save();

       
        return redirect()->back()->with('success', 'Your review has been submitted successfully!');
    }
    
}