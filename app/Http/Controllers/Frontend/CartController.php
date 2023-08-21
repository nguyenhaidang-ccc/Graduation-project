<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function cart(){
        return view('frontend.cart');
    }

    public function add(Product $product, Request $request){
        $validated = $request->validate([
            'size' => 'required',
            'quantity' => 'required|numeric|min:1',
        ]);
        $size = $validated['size'];
        $quantity = $validated['quantity'];
        $cart = session('cart', []);

        if(array_key_exists($product->id, $cart) 
        && array_key_exists($size, $cart[$product->id])){
            $cart[$product->id][$size]['quantity'] += $quantity;
            
        }
        else{
            $cart[$product->id][$size] = [
                'product_id' => $product->id,
                'image' => $product->images->first()->image,
                'name' => $product->name,
                'color' => $product->color,
                'quantity' => $quantity,
                'size' => $validated['size'],
                'price'=> $product->price,
            ];
        }
        session()->put('cart', $cart);
        $this->totalPrice();
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function increase($product_id, $size){ 
        $cart = session('cart', []);
        if(isset($cart[$product_id][$size])){
            $cart[$product_id][$size]['quantity'] += 1;
        };
        session()->put('cart', $cart);
        $this->totalPrice();

        return redirect()->back()->with('success', 'Update cart successfully.');
    }

    public function decrease($product_id, $size){ 
        $cart = session('cart', []);
        if(isset($cart[$product_id][$size])){
            $cart[$product_id][$size]['quantity'] -= 1;
        };
        session()->put('cart', $cart);
        $this->totalPrice();

        return redirect()->back()->with('success', 'Update cart successfully.');
    }

    public function giam($product_id, $size){
        return 'OK';
    }

    public function delete($product_id, $size){
        $cart = session('cart');
        unset($cart[$product_id][$size]);
        if(empty($cart[$product_id])){
            unset($cart[$product_id]);
        }
        session()->put('cart', $cart);

        $this->totalPrice();
        return back()->with('success', 'Product removed from cart successfully.');
    }

    protected function totalPrice(){
        $total_price = 0;
        foreach(session('cart') as $carts){
            foreach($carts as $item){
                $total_price += $item['quantity'] * $item['price'];
            }
        }
        session()->put('total_price', $total_price);
    }

    
}
