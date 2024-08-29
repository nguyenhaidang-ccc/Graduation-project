<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
{
    $orders = Order::where('user_id', Auth::guard('web')->id());

    if ($request->has('date_filter') && $request->filled('date_filter')) { 
        try {
            $date = Carbon::createFromFormat('Y-m-d', $request->date_filter);
            $orders->whereDate('created_at', $date);
        } catch (\Exception $e) {
            Log::error('Date conversion error: ' . $e->getMessage());
        }
    }

    $orders = $orders->orderByDesc('id')->paginate(5);
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


    public function downloadInvoice(Order $order)
    {
        
        if ($order->user_id != Auth::guard('web')->id() || $order->status != 4) {
            abort(403, 'Unauthorized'); 
        }
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('frontend.invoices.invoice_details', compact('order'))); 
        $dompdf->render();
        return $dompdf->stream('Bill' . $order->id . '.pdf');
    }
}
