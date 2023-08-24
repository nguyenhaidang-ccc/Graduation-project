<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderHistoryController extends Controller
{
    public function index(){
        $orders = Order::where('user_id', \Auth::guard('web')->id())->paginate(5);
        return view('frontend.order-history', compact('orders'));
    }

    public function cancel(Order $order){
        $order->status = 0;
        $order->save();

        return redirect()->back()->with('success', 'Cancel order successfully.');
    }

    public function receive(Order $order){
        $order->status = 4;
        $order->save();

        return redirect()->back()->with('success', 'Receive order successfully.');
    }
    public function return(Order $order){
        $order->status = 1;
        $order->save();

        return redirect()->back()->with('success', 'Return order successfully.');
    }

    public function orderDetail(Order $order){
        return view('frontend.order-detail', compact('order'));
    }
}
