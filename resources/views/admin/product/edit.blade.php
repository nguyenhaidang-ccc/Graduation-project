@extends('admin.layout.master')

@section('content')
<style>
    #container {
        width: 1000px;
        margin: 20px auto;
    }
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 200px;
    }
    .ck-content .image {
        /* block images */
        max-width: 80%;
        margin: 20px auto;
    }
    </style>

    <div class="app-main__inner">

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>
                        Product
                        <div class="page-title-subheading">
                            View, create, update, delete and manage.
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form method="post" action="{{route('product.update', $product)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="position-relative row form-group">
                                <label for="brand_id"
                                    class="col-md-3 text-md-right col-form-label">Brand</label>
                                <div class="col-md-9 col-xl-8">
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        <option value="">-- Brand --</option>
                                        @foreach ($brands as $brand)
                                             <option {{ $product->brand_id == $brand->id ? "selected" : "" }} value="{{$brand->id}}">{{$brand->name}}</option>   
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="category_id"
                                    class="col-md-3 text-md-right col-form-label">Category</label>
                                <div class="col-md-9 col-xl-8">
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">-- Category --</option>
                                        @foreach ($categories as $category)
                                             <option {{ $product->category_id == $category->id ? "selected" : "" }} value="{{$category->id}}">{{$category->name}}</option>   
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="position-relative row form-group">
                                <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="name" id="name" placeholder="Name" type="text"
                                        class="form-control" value="{{old('name', $product->name)}}">
                                    @error('name')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="price"
                                    class="col-md-3 text-md-right col-form-label">Price</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="price" id="price"
                                        placeholder="Price" type="number" class="form-control" value="{{ old('price', $product->price) }}">
                                    @error('price')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="color"
                                    class="col-md-3 text-md-right col-form-label">Color</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="color" id="color"
                                        placeholder="Color" type="text" class="form-control" value="{{old('color', $product->color)}}">
                                    @error('color')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="sku"
                                    class="col-md-3 text-md-right col-form-label">Product code</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="product_code" id="product_code"
                                        placeholder="Product code" type="text" class="form-control" value="{{old('product_code', $product->product_code)}}">
                                    @error('product_code')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @php
                                $firstItem = $product->productItems->shift();
                            @endphp

                            <div id="input-container">
                                <div class="position-relative row form-group">
                                    <label for="size"
                                        class="col-md-3 text-md-right col-form-label">Size</label>
                                    <div class="col-md-2 col-xl-2">
                                        <input name="sizes[]" id="size"
                                            placeholder="Size" type="number" class="form-control" value="{{$firstItem->size}}">
                                        @error('sizes.*')
                                            <p class="text-danger mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label for="sku"
                                        class="col-md-3 text-md-right col-form-label">Quantity</label>
                                    <div class="col-md-2 col-xl-2">
                                        <input name="quantities[]" id="quantity"
                                            placeholder="Quantity" type="number" class="form-control" value="{{$firstItem->quantity}}" >
                                        @error('quantities.*')
                                            <p class="text-danger mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="pl-2 d-flex align-items-center" onclick="addSection()">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                
                                @foreach ($product->productItems as $item)
                                    <div class="position-relative row form-group input-section">
                                        <label for="size"
                                            class="col-md-3 text-md-right col-form-label">Size</label>
                                        <div class="col-md-2 col-xl-2">
                                            <input name="sizes[]" id="size"
                                                placeholder="Size" type="number" class="form-control" value="{{$item->size}}">
                                        </div>
                                        <label for="sku"
                                            class="col-md-3 text-md-right col-form-label">Quantity</label>
                                        <div class="col-md-2 col-xl-2">
                                            <input name="quantities[]" id="quantity"
                                                placeholder="Quantity" type="number" class="form-control" value="{{$item->quantity}}">
                                        </div>
                                        <div class="pl-2 d-flex align-items-center deleteButton">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            
                            <div class="position-relative row form-group">
                                <label for="featured"
                                    class="col-md-3 text-md-right col-form-label">Featured</label>
                                <div class="col-md-9 col-xl-8">
                                    <div class="position-relative form-check pt-sm-2">
                                        <input {{ $product->featured == 1 ? 'checked' : '' }} name="featured" id="featured" type="checkbox" value="1" class="form-check-input">
                                        <label for="featured" class="form-check-label">Featured</label>
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="description"
                                    class="col-md-3 text-md-right col-form-label">Description</label>
                                <div class="col-md-9 col-xl-8">
                                    <textarea class="form-control" name="description" id="editor" >{{old('description', $product->description)}}</textarea>
                                    @error('description')
                                        <p class="text-danger mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="position-relative row form-group">
                                <label for="" class="col-md-3 text-md-right col-form-label">Images</label>
                                <div class="col-md-9 col-xl-8">
                                    <button class="btn border border-primary" type="button" id="addImageButton">
                                        Add Image
                                    </button>
                                    
                                    <div id="imageContainer">
                                        @foreach($product->images as $item)
                                            <div class="image-container mt-2">
                                                <input onchange="previewImg(this, {{$item->id}})" type="file" class="image-input" name="images[{{$item->id}}]"
                                                 accept="image/png, image/gif, image/jpeg, image/webp">
                                                <img class="preview-image-{{$item->id}}" style="width: 100px" src="{{$item->image}}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative row form-group mb-1">
                                <div class="col-md-9 col-xl-8 offset-md-2">
                                    <a href="{{route("product.index")}}" class="border-0 btn btn-outline-danger mr-1">
                                        <span class="btn-icon-wrapper pr-1 opacity-8">
                                            <i class="fa fa-times fa-w-20"></i>
                                        </span>
                                        <span>Cancel</span>
                                    </a>

                                    <button type="submit"
                                        class="btn-shadow btn-hover-shine btn btn-primary">
                                        <span class="btn-icon-wrapper pr-2 opacity-8">
                                            <i class="fa fa-download fa-w-20"></i>
                                        </span>
                                        <span>Save</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script src="/assets/admin/js/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
    @endpush

@endsection