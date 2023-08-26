@extends('frontend.layout.master')

@section('content')
    <style>
        input.custom-input{
            height: 35px;
            width: 120px;
            border-radius: 5px;
        }
        .custom-btn{
            height: 30px;
            width: 55px;
        }
        .price-divider{
            margin: 25px 15px 0 15px;
        }
    </style>
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('home')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <form action="">
            <div class="row px-xl-5">
                <!-- Shop Sidebar Start -->
                <div class="col-lg-3 col-md-12">
                        <!-- Price Start -->
                    <div class="border-bottom mb-4 pb-4">
                        <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                        <div class="d-flex align-items-center justif-content-between">
                            <div class="">
                                <label class="" for="">From</label>
                                <div class="price-filter-input d-flex align-items-center">
                                    <label>
                                        <input class="custom-input" value="{{request('min_price') ?? '' }}" type="number" name="min_price" placeholder="0" min="0">
                                    </label>
                                </div>
                            </div>
                            <div class="price-divider">
                                <span>-</span>
                            </div>
                            <div class="price-filter-group">
                                <label class="price-filter-label" for="">To</label>
                                <div class="price-filter-input d-flex align-items-center">
                                    <label>
                                        <input class="custom-input"  value="{{request('max_price') ?? '' }}" type="number" placeholder="0" name="max_price" min="0">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="btn-primary mt-3 custom-btn" type="submit">Filter</button>
                        
                    </div>
                    <!-- Price End -->
                    
                    <!-- Color Start -->
                    <div class="border-bottom mb-4 pb-4">
                        <h5 class="font-weight-semi-bold mb-4">Filter by brand</h5>
                        @foreach($brands as $brand)
                            <div class="custom-control d-flex align-items-center justify-content-between mb-3">
                                <input onchange="this.form.submit()" type="checkbox" class="custom-control-input" id="brand-[{{$brand->id}}]" 
                                name="brand[{{$brand->name}}]" {{ (request('brand')[$brand->name] ?? '') == 'on' ? 'checked' : '' }}  >
                                <label class="custom-control-label" for="brand-[{{$brand->id}}]">{{$brand->name}}</label>
                            </div>
                        @endforeach
                    </div>
                    <!-- Color End -->

                    <!-- Size Start -->
                    <div class="mb-5">
                        <h5 class="font-weight-semi-bold mb-4">Filter by size</h5>
                        @foreach($sizes as $size)
                            <div class="custom-control d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="size-{{$size}}" name="size[{{$size}}]"
                                {{ (request('size')[$size] ?? '' ) == 'on' ? 'checked' : ''}} onchange="this.form.submit()">
                                <label class="custom-control-label" for="size-{{$size}}">{{$size}}</label>
                            </div>
                        @endforeach
                    </div>
                        <!-- Size End -->
                </div>
                <!-- Shop Sidebar End -->
    
                <!-- Shop Product Start -->
                <div class="col-lg-9 col-md-12">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="ml-4">
                                    <label>Sort by :</label>
                                    <select name="sort_by" onchange="this.form.submit()">
                                        <option {{request('sort_by') == 'latest' ? 'selected' : '' }} value="lastest">Latest</option>
                                        <option {{request('sort_by') == 'oldest' ? 'selected' : '' }} value="oldest">Oldest</option>
                                        <option {{request('sort_by') == 'name-ascending' ? 'selected' : '' }} value="name-ascending">Name A -> Z</option>
                                        <option {{request('sort_by') == 'name-desending' ? 'selected' : '' }} value="name-desending">Name Z -> A </option>
                                        <option {{request('sort_by') == 'price-ascending' ? 'selected' : '' }} value="price-ascending">Price Increase </option>
                                        <option {{request('sort_by') == 'price-desending' ? 'selected' : '' }} value="price-desending">Price Decrease </option>
                                    </select>
                                </div>
                                <div class="ml-4">
                                    <div>
                                        <p class="text-sm text-gray-700 leading-5">
                                            Showing
                                            <span class="font-medium">{{ $products->firstItem() }}</span>
                                            to
                                            <span class="font-medium">{{ $products->count()}}</span>
                                            of
                                            <span class="font-medium">{{$products->total()}}</span>
                                            results
                                        </p>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        @foreach($products as $product)    
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{$product->images->shift()->image}}" alt="">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">{{$product->name}} - {{$product->color}}</h6>
                                    <div class="d-flex justify-content-center">
                                        <h6 class="text-danger font-weight-bold">{{number_format($product->price)}}đ</h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-center bg-light border">
                                    <a href="{{route('product', $product)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-12 pb-1">
                            <nav aria-label="Page navigation">
                              <ul class="pagination justify-content-center mb-3">
                                {{$products->links()}}
                              </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Shop Product End -->
            </div>
        </form>
    </div>
    <!-- Shop End -->
@endsection