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
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {   
        $keyword = $request->input('search');

        $products = Product::when($keyword, function($query, $keyword){                                                                             //Nếu $keyword có giá trị , thì hàm callback  sẽ được thực hiện.
                $query->where('name', 'like', '%'.$keyword.'%');                                                                                        //Thêm một điều kiện vào truy vấn để lọc ra các sản phẩm có tên chứa $keyword.
            })
            ->orderByDesc('id')->paginate(5)->appends($request->except('page'));
        return view('admin.product.list', compact('products'));
    }


    public function create()
    {   
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories','brands'));
    }

 
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $sizes = $data['sizes'];
        $quantities = $data['quantities'];
        $arrimages = $data['images'];
        $productItems = array_map(function($size, $quantity) {                                                                                          //Hàm callback ở đây tạo ra một mảng mới $productItems 
            return ['size' => $size, 'quantity' => $quantity];                                                                                              //chứa các cặp key-value ['size' => $size, 'quantity' => $quantity] 
        }, $sizes, $quantities);                                                                                                                            //cho từng cặp size và quantity tương ứng.
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
                if ($item['quantity'] <= 0) {
                    throw ValidationException::withMessages([
                        'quantity' => 'The quantity must be greater than zero.',
                    ]);}
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

  
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();

        
        $product->load(['productItems']);

        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }


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


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Delete successfully!');
    }
}
