<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderByDesc('id')->paginate(5);
        return view('admin.order.list', compact('orders'));
    }

    public function show(Order $order){
        return view('admin.order.show', compact('order'));
    }

    public function confirm(Order $order){
        $order->status = 3;
        $order->save();

        return redirect()->back()->with('success', 'Confirm order successfully.');
    }
}