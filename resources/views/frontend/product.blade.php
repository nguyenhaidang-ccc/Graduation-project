@extends('frontend.layout.master')

@section('content')

<style>
.rate {
    direction: rtl;
    display: flex;
}

.rate input[type="radio"] {
    display: none;
}

.rate label {
    font-size: 24px;
    color: #ddd;
    cursor: pointer;
}

.rate label:hover,
.rate label:hover ~ label,
.rate input[type="radio"]:checked ~ label {
    color: #ffc107;
}



</style>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{route('home')}}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop Detail</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="{{$product->images->shift()->image}}" alt="Image">
                    </div>

                    @foreach ($product->images as $item )
                    <div class="carousel-item">
                        <img class="w-100 h-100" src="{{$item->image}}" alt="Image">
                    </div>
                    @endforeach

                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <form action="{{route('cart.add', $product)}}" method="post">
                @csrf
                <h3 class="font-weight-semi-bold">{{$product->name}} - {{$product->color}}</h3>
                <p class="font-weight-semi-bold">{{$product->category->name}}</p>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                    <div class="text-primary mb-2">
                        @php
                            $averageRating = $product->productReviews->avg('rate');
                            $roundedAverageRating = round($averageRating); 
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $roundedAverageRating)
                                <i class="fas fa-star"></i> 
                            @else
                                <i class="far fa-star"></i> 
                            @endif
                        @endfor
                    </div>
                    </div>
                    <small class="pt-1">({{ $product->productReviews->count() }} Reviews)</small>

                </div>
                <h3 class="font-weight-bold mb-4 text-danger">{{number_format($product->price)}}VND</h3>
                <p class="mb-3">Product code: {{($product->product_code)}}</p>
                <p class="mb-3">Products in stock: {{($product->productItems->sum('quantity'))}}</p>
                @if($product->productItems->sum('quantity') > 0)
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>

                    @foreach ($product->productItems->sortBy('size') as $item )
                    @if ($item->quantity > 0)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input value="{{$item->size}}" onchange="getQuantity('{{$item->size}}','{{ $product->id}}');"
                            type="radio" class="custom-control-input" id="size-{{$item->size}}" name="size">
                        <label class="custom-control-label" for="size-{{$item->size}}">{{$item->size}}</label>
                    </div>
                    @endif
                    @endforeach
                </div>
                @error('size')
                <p style="margin-top:-20px;" class="text-danger">{{ $message }}</p>
                @enderror
                <h5 id="showQuantity" class="mb-4 text-info font-weight-bold"></h5>

                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="number" name="quantity" class="form-control bg-secondary text-center" value="1">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                        Cart</button>
                </div>
                @error('quantity')
                <p style="margin-top:-20px;" class="text-danger">{{ $message }}</p>
                @enderror
                @else
                <h1 class="text-danger ">Sold out</h1>
                @endif
                <div class="d-flex pt-2">
            
                    <!-- <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div> -->
                </div>
            </form>
            <div>
            <form action="{{ route('wishlist.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-outline-primary px-3"><i class="fa fa-heart mr-1"></i> Add to Wishlist</button>
                            </form>
                    
            </div>
        </div>
    </div>
   
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                <!-- <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Size guide</a> -->
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews ({{ $product->productReviews->count() }})</a>

            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Product Description</h4>
                    <p>{!!$product->description!!}</p>
                </div>
                <div class="tab-pane fade" id="tab-pane-2">
                    <h4 class="mb-3">Additional Information</h4>
                    <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt
                        duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur
                        invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet
                        rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam
                        consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam,
                        ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr
                        sanctus eirmod takimata dolor ea invidunt.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                </li>
                                <li class="list-group-item px-0">
                                    Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                </li>
                                <li class="list-group-item px-0">
                                    Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                </li>
                                <li class="list-group-item px-0">
                                    Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                </li>
                                <li class="list-group-item px-0">
                                    Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                </li>
                                <li class="list-group-item px-0">
                                    Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                </li>
                                <li class="list-group-item px-0">
                                    Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">Reviews</h4>
                            
                           
                            @if ($product->productReviews && count($product->productReviews) > 0) 
                                @forelse ($product->productReviews as $review)
                                    <div class="media mb-4">
                                        <img src="{{ $review->user->avatar ?? '/assets/frontend/img/user.jpg' }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>{{ $review->user->name ?? 'Anonymous' }} <small>- {{ $review->created_at?->format('d M Y') ?? 'N/A' }}</small></h6>
                                            <div class="text-primary mb-2">
                                                <p>Rating: 
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rate)
                                                            <i class="fas fa-star"></i> 
                                                        @else
                                                            <i class="far fa-star"></i> 
                                                        @endif
                                                    @endfor
                                                </p>
                                            </div>
                                            <p>{{ $review->content }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p>There are no reviews yet.</p> 
                                @endforelse
                            @else
                                <p>There are no reviews yet.</p> 
                            @endif
                        </div>


                        <div class="col-md-6">
                            <h4 class="mb-4">Leave a review</h4>
                            
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <div class="rate">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rate" id="rate-{{ $i }}" value="{{ $i }}" style="display: none;">
                                            <label for="rate-{{ $i }}" class="star-label" data-value="{{ $i }}"><i class="far fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="message">Your Review *</label>
                                    <textarea id="message" name="message" cols="30" rows="5" class="form-control" required></textarea>
                                </div>
                                @guest
                                <!-- <div class="form-group">
                                    <label for="name">Your Name *</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email *</label>
                                    <input type="email" name="email" class="form-control" id="email" required>
                                </div> -->
                                @endguest
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach ($relatedProducts as $product)
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ $product->images->shift()->image }}" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{$product->name}}</h6>
                            <div class="d-flex justify-content-center">
                                <h6>{{number_format($product->price)}}VND</h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-center bg-light border">
                            <a href="{{route('product', $product)}}" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-eye text-primary mr-1"></i>
                                View Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.star-label').click(function() {
                var ratingValue = $(this).data('value');
                var starLabels = $('.star-label');
                starLabels.each(function() {
                    var currentValue = $(this).data('value');
                    if (currentValue <= ratingValue) {
                        $(this).children('i').removeClass('far').addClass('fas');
                    } else {
                        $(this).children('i').removeClass('fas').addClass('far');
                    }
        });
    });
});

    </script>
@endsection