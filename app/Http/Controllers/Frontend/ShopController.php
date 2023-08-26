<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductItem;

class ShopController extends Controller
{
    public function index(){
        $highLightProducts = Product::where('featured', 1)->orderByDesc('id')->limit(8)->get();
        $products = Product::orderByDesc('id')->limit(8)->get();
        return view('frontend.index', compact('highLightProducts', 'products'));
    }

    public function contact(){
        return view('frontend.contact');
    }

    public function shop(Request $request){
        $sizes = ProductItem::all()->unique('size')->pluck('size')->sort();

        $keyword = $request->input('search');
        $products = Product::when($keyword, function($query,$keyword){
                        return $query->where('name','like',"%$keyword%");
                    });

        $products = $this->filter($products, $request);
        $products = $this->sortBy($products, $request);
        $products = $products->paginate(9);

        return view('frontend.shop',compact('products','sizes'));
    }

    public function getProductByCategory($category_id, Request $request){
        $sizes = ProductItem::all()->unique('size')->pluck('size')->sort();

        $products = Product::where('category_id',$category_id);

        $products = $this->filter($products, $request);
        $products = $this->sortBy($products, $request);
        $products = $products->paginate(9);

        return view('frontend.shop',compact('products','sizes'));
    }

    protected function filter($products,Request $request){

        //Brand
        $brands = $request->input('brand') ?? [];
        $brand_names = array_keys($brands);
        if($brand_names != null){
            $products = $products->whereHas('brand', function($query) use ($brand_names){
                                            return $query->whereIn('name', $brand_names);
            });
        }    

        //Price
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        $products = ($min_price != null && $max_price != null) 
                    ? $products->whereBetween('price', [$min_price, $max_price]) : $products;

        //Size
        $sizes = $request->input('size') ?? [];
        $arr_sizes = array_keys($sizes);

        $products = $arr_sizes != null ? $products->whereHas('productItems', function($query) use ($arr_sizes){
                                                            return $query->whereIn('size', $arr_sizes)
                                                                        ->where('quantity', '>', '0');
        }) : $products;

        return $products;
    }

    protected function sortBy($products,Request $request){
        $sortBy = $request->input('sort_by') ?? 'latest';
        
        switch ($sortBy) {
            case 'latest':
                $products = $products->orderByDesc('id');
                break;
            case 'oldest':
                $products = $products->orderBy('id');
                break;
            case 'name-ascending':
                $products = $products->orderBy('name');
                break;
            case 'name-desending':
                $products = $products->orderByDesc('name');
                break;
            case 'price-ascending':
                $products = $products->orderBy('price');
                break;
            case 'price-desending':
                $products = $products->orderByDesc('price');
                break;
            default: $products = $products->orderByDesc('id');
        }

        return $products;
    }

    public function product(Product $product){
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '<>', $product->id)
                                ->limit(8)
                                ->get();
                
        return view('frontend.product', compact('product', 'relatedProducts'));
    }

    public function brand(Brand $brand, Request $request){
        $sizes = ProductItem::all()->unique('size')->pluck('size')->sort();

        $products = Product::where('brand_id',$brand->id);

        $products = $this->filter($products, $request);
        $products = $this->sortBy($products, $request);
        $products = $products->paginate(9);

        return view('frontend.shop',compact('products','sizes'));
    }

    public function getQuantity(Request $request){
        $size = $request->size;
        $product_id = $request->product_id;
        
        $productItem = ProductItem::where('product_id', $product_id)
                                ->where('size', $size)
                                ->first();

        return response()->json($productItem->quantity);

    }
}