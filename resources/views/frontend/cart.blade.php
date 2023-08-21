@extends('frontend.layout.master')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    
    <div class="container-fluid pt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(!empty(session('cart')))
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        
                        @foreach (session('cart') as $carts )
                               @foreach ($carts as $cart)
                               <tr>
                                    <td class="align-middle"><img src="{{$cart['image']}}" style="width: 55px; padding-right:5px">
                                        <a href="{{route('product', $cart['product_id'])}}">{{$cart['name']}} - {{$cart['color']}}</a>
                                    </td>
                                    <td class="align-middle">{{number_format($cart['price'])}}đ</td>
                                    <td class="align-middle">{{$cart['size']}}</td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <form action="{{route('cart.decrease', [$cart['product_id'], $cart['size']])}}" method="GET">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-minus" >
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <input disabled readonly type="number" class="form-control form-control-sm bg-secondary text-center" value="{{$cart['quantity']}}">
                                            <div class="input-group-btn">
                                                <form method="GET" action="{{route('cart.increase',[ $cart['product_id'], $cart['size'] ])}}">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-plus">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </form>    
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{number_format($cart['quantity'] * $cart['price'])}}đ</td>
                                    
                                    <td class="align-middle">
                                        <form method="POST" action="{{route('cart.delete', [$cart['product_id'], $cart['size']])}}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr> 
                               @endforeach
                        @endforeach
                                             
                    </tbody>
                </table>
                
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
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
                        <a href="{{route('checkout')}}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
        @else
            <h5 class="text-center">Không có sản phẩm nào!</h5>
            <div class="row justify-content-center">
                <a href="{{route('shop')}}" class="btn btn-primary my-4">Continue shopping</a>
            </div>
        @endif 
    </div>
    <!-- Cart End -->

@endsection
