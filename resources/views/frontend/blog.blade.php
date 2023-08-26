@extends('frontend.layout.master')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Blog</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{route('home')}}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Blog</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<section class="blog-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 order-1 order-lg-2">
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-sm-4">
                            <div class="blog-item">
                                <div class="bi-pic">
                                    <img src="{{$post->thumbnail}}" alt="thumbnail">
                                </div>
                                <div class="bi-text">
                                    <a href="{{route('blog.detail', $post)}}">
                                        <h4>{{ $post->title }}</h4>
                                    </a>
                                    <p>{{$post->postType->name}} <span>- {{date_format($post->created_at, "M d, Y")}}</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{$posts->links()}}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection