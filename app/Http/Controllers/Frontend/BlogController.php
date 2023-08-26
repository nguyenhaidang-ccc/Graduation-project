<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MOdels\Post;

class BlogController extends Controller
{
    public function blog(){
        $posts = Post::orderByDesc('id')->paginate(9);
        return view('frontend.blog', compact('posts'));
    }

    public function blogDetail(Post $post){
        return view('frontend.blog-detail', compact('post'));
    }
}
