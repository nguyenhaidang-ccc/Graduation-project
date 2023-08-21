<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductItem;
use DB;

class CheckoutController extends Controller
{
    public function index(){
        return view('frontend.checkout');
    }

    public function checkout(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'payment' => 'required|in:1,2',
        ]);

        DB::beginTransaction();
        try {
            $data['total_price'] = session('total_price');
            $data['user_id'] = \Auth::id();
            $order = Order::create($data);

            $carts = session('cart',[]);

            foreach($carts as $cart){
                foreach($cart as $item){
                    $order->products()->attach($item['product_id'], [
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'size' => $item['size'],
                    ]);

                    $productItem = ProductItem::where('product_id',$item['product_id'])
                                            ->where('size', $item['size'])
                                            ->first();  
                    $productItem->quantity -= $item['quantity'];
                    $productItem->save();
                }
            }
            session()->forget(['cart','total_price']);
            DB::commit();

            return redirect()->route('home');

        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

    }
}