@extends('frontend.layout.master')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('home')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Checkout</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('checkoutPost')}}">
            @csrf
            <div class="row px-xl-5">
                <div class="col-lg-7 pl-5">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Name</label>
                                <input class="form-control" value="{{Auth::guard('web')->user()->name}}" name="name" type="text" placeholder="name">
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label>E-mail</label>
                                <input class="form-control" value="{{Auth::guard('web')->user()->email}}" type="email" name="email" placeholder="email">
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Phone</label>
                                <input class="form-control" type="number" value="{{Auth::guard('web')->user()->phone}}" name="phone" placeholder="phone">
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" value="{{Auth::guard('web')->user()->address}}" name="address" placeholder="address">
                                @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 pr-5">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-medium mb-3">Products</h5>
                            @foreach (session('cart') as $carts)
                                @foreach ($carts as $cart)
                                    <div class="d-flex justify-content-between">
                                        <span>{{$cart['name']}} - {{$cart['color']}} x {{$cart['quantity']}}
                                            <p style="font-size: 13px">Size: {{$cart['size']}}</p>
                                        </span>
                                        <p>{{number_format($cart['price'] * $cart['quantity'])}}đ</p>
                                    </div>
                                @endforeach
                                
                            @endforeach
                                                        
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Subtotal</h6>
                                <h6 class="font-weight-medium">{{number_format(session('total_price'))}}đ</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">Free</h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold">{{number_format(session('total_price'))}}đ</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Payment</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" value="1" id="vnpay">
                                    <label class="custom-control-label" for="vnpay">VNPay</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" value="2" id="cod">
                                    <label class="custom-control-label" for="cod">Cash on delivery (COD)</label>
                                </div>
                            </div>
                            @error('payment')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>
        
    </div>
    <!-- Checkout End -->
@endsection