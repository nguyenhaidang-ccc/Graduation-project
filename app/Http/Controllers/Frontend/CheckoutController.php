<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckoutController extends Controller
{
    static $vnp_TmnCode = "W6YEW49O"; 
    static $vnp_HashSecret = "WSBCHHFZBEGYEQNOQHVKLNCGZVHQTHMU"; 
    static $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    static $vnp_Returnurl = "/checkout/vnPayCheck";

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


        $data['total_price'] = session('total_price');
        $data['user_id'] = Auth::id();
        $data['status'] = 2; 
        
        if($data['payment'] == 2){
            DB::beginTransaction();
            try {
                $order = Order::create($data);
                $this->createOrderDetail($order);
                DB::commit();

                return redirect()->route('order.success');

            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        };

       
        if($data['payment'] == 1){
            $order = Order::create($data);
            $data = [
                'vnp_TxnRef' => $order->id,
                'vnp_OrderInfo' => 'Order Payment No.' .$order->id,
                'vnp_Amount' => $order->total_price,

            ];
            $data_url = $this->vnpay_create_payment($data);
           
            Redirect::to($data_url)->send();
        }

    }

    protected function createOrderDetail($order){
        $carts = session('cart',[]);

        foreach($carts as $cart){
            foreach($cart as $item){
                $order->products()->attach($item['product_id'], [
                    'name' => $item['name'],
                    'color' => $item['color'],
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
    }

    protected function vnpay_create_payment(array $data)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TxnRef = $data['vnp_TxnRef'];
        $vnp_OrderInfo = $data['vnp_OrderInfo'];
        $vnp_OrderType = 200000;
        $vnp_Amount = $data['vnp_Amount'] * 100;
        $vnp_Locale = 'vn'; 
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //127.0.0.1

        $inputData = array(
            "vnp_Version" => "2.1.0", 
            "vnp_TmnCode" => self::$vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND", 
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => env('APP_URL') . self::$vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

       
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

       
        $vnp_Url = self::$vnp_Url . "?" . $query;
        if (isset(self::$vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, self::$vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = [
            'code' => '00', 
            'message' => 'success',
            'data' => $vnp_Url
        ];


        return $returnData['data']; 
    }

    public function vnPayCheck(Request $request){
      
        $vnp_ResponseCode = $request->get('vnp_ResponseCode'); 
        $vnp_TxnRef = $request->get('vnp_TxnRef'); 

       
        if($vnp_ResponseCode != null){
            $order = Order::find($vnp_TxnRef);

            
            if($vnp_ResponseCode == 00){
                $this->createOrderDetail($order);
                return redirect()->route('order.success');

            }elseif($vnp_ResponseCode == 24){ 
                $order->delete();
                return redirect()->route('checkout');
            }
            else{
                $order->delete();
                return redirect()->route('checkout')->with('error', 'Order payment failed.');
            }
        }
    }

    public function notification(){
        return view('frontend.notification');
    }
}
