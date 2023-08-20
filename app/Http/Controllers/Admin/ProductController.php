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
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $keyword = $request->input('search');

        $products = Product::when($keyword, function($query, $keyword){
                $query->where('name', 'like', '%'.$keyword.'%');
            })
            ->orderByDesc('id')
            ->paginate(5);
        return view('admin.product.list', compact('products'));
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
            return redirect()->route('product.show', $product->id);
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function createProductItem($product, $productItems){
        DB::beginTransaction();
        try {
            foreach($productItems as $item){
                ProductItem::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'size' => $item['size']
                    ],
                    [
                        'quantity' => $item['quantity']
                    ]
                );
                
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
            foreach($arrimages as $index => $image){
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

    protected function updateProductImage($product, $arrimages){
        DB::beginTransaction();
        try {
            foreach($arrimages as $index => $image){
                $productImage = null;
                $productImage = ProductImage::find($index);
                if($productImage){
                    $productImage->image = $this->saveImage($image);
                    $productImage->save();
                }
                else{
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = $this->saveImage($image);
                    $productImage->save();
                }
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
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::with(['productItems' => function ($query) {
            $query->where('quantity', '>', 0);
        }])->find($product->id);
        return view('admin.product.edit', compact('product','categories','brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $sizes = $data['sizes'];
        $quantities = $data['quantities'];
        $arrimages = $data['images'] ?? [];
        $productItems = array_map(function($size, $quantity) {
            return ['size' => $size, 'quantity' => $quantity];
        }, $sizes, $quantities);
        DB::beginTransaction();
        try {
            unset($data['sizes']);
            unset($data['quantities']);
            unset($data['images']);
            $product->update($data);
            $this->createProductItem($product,$productItems);
            $this->updateProductImage($product,$arrimages);
            DB::commit();
            return redirect()->route('product.show', $product->id);
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Delete successfully!');
    }
}
