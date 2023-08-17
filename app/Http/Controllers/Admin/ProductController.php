<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.product.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $sizes = $data['sizes'];
        $quantities = $data['quantities'];
        $arrimages = $data['images'];
        $productItems = array_map(function($size, $quantity) {
            return ['size' => $size, 'quantity' => $quantity];
        }, $sizes, $quantities);
        DB::beginTransaction();
        try {
            unset($data['sizes']);
            unset($data['quantities']);
            unset($data['images']);
            $product = Product::create($data);
            $this->createProductItem($product,$productItems);
            $this->createProductImage($product,$arrimages);
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function createProductItem($product, $productItems){
        DB::beginTransaction();
        try {
            foreach($productItems as $item){
                $productItem = new ProductItem();
                $productItem->product_id = $product->id;
                $productItem->size = $item['size'];
                $productItem->quantity = $item['quantity'];
                $productItem->save();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function createProductImage($product, $arrimages){
        DB::beginTransaction();
        try {
            foreach($arrimages as $image){
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $this->saveImage($image);
                $productImage->save();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function saveImage($image){
        $imageName = $image->hashName();
        $res = $image->storeAs('uploads/product', $imageName, 'public');
        if($res){
            $path = 'uploads/product/'. $imageName;
        } 
        return $path;

    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
