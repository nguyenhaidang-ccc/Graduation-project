@extends('frontend.layout.master')

@section('content')

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
                                    <a href="#">
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