<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayController extends Controller
{
    function payment_show()
    {
        $customer = Auth::guard('customer')->user();
        $shipping = Setting::first()->shipping;
        $cart = $customer->cart;
        // Cập nhật lại giá của sản phẩm
        foreach ($cart->cart_items as $cart_items) {
            $cart_items->update([
                'price' => $cart_items->colorversionsize->color_version_image->version->product->price,
            ]);
        }
        // Cập nhật lại giá và số lượng giỏ hàng 
        $cart->update([
            'total_item'  => $cart->cart_items->sum('quantity'),
            'total_price' => $cart->cart_items->reduce(function ($carry, $item) {
                return $carry + ($item->price * $item->quantity);
            }, 0),
        ]);
        $cart_items = $cart->cart_items;

        return view('main.payment_show', compact('customer', 'cart', 'cart_items','shipping'));
    }

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    function payment_momo_atm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,11',
            'email' => 'required|email|max:255',
            'payment_option' => 'required|in:momo,atm',
        ]);

        $endpoint = env('MOMO_ENDPOINT');
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $serectkey = env('MOMO_SECRET_KEY');
        $orderInfo = "Thanh toán qua ATM MoMo";

        $orderInfo = "Thanh toán qua ATM MoMo";
        $amount = "10000";
        $orderId = time() . "";
        $redirectUrl = route('momo_ipn_handler');
        $ipnUrl = route('store_front');
        $extraData = $request->customer_id;

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));

        $jsonResult = json_decode($result, true);  // decode json

        // dd($result,$jsonResult);

        //Just a example, please check more in there
        if (isset($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult['payUrl']);
        } else {
            // Xử lý lỗi ở đây, ví dụ: trả về một thông báo lỗi cho người dùng
            return back()->with('status', 'Có lỗi xảy ra khi thanh toán qua MoMo.');
        }
    }

    function payment_momo_qr(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,11',
            'email' => 'required|email|max:255',
            'payment_option' => 'required|in:momo,atm',
        ]);
        // $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        // $partnerCode = 'MOMOBKUN20180529';
        // $accessKey = 'klm05TvNBzhg7h7j';
        // $serectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $endpoint = env('MOMO_ENDPOINT');
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $serectkey = env('MOMO_SECRET_KEY');

        $orderInfo = "Thanh toán qua MoMo";
        $amount = "1000";
        $orderId = time() . "";
        $redirectUrl = route('momo_ipn_handler');
        $ipnUrl = route('store_front');
        $extraData = $request->customer_id;

        $requestId = time() . "";
        $requestType = "captureWallet";

        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        // dd($result,$jsonResult);
        //Just a example, please check more in there

        if (isset($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult['payUrl']);
        } else {
            // Xử lý lỗi ở đây, ví dụ: trả về một thông báo lỗi cho người dùng
            return back()->with('status', 'Có lỗi xảy ra khi thanh toán qua MoMo.');
        }
    }

    public function handleMomoIPN(Request $request)
    {
        $resultCode = $request->resultCode;

        if ($resultCode == 0) {
            $customer_id = $request->extraData;
            $customer = Customer::find($customer_id);
            $cart = $customer->cart;
            $cart_items = $cart->cart_items;
    
            // Tạo ra bảng Order mới
            $new_order = Order::create([
                'status' => 'done',
                'total_item' => $cart->total_item,
                'total_price' => $cart->total_price,
                'customer_id' => $customer_id,
            ]);
    
            // Thêm order_item
            foreach ($cart_items as $item) {
                OrderItem::create([
                    'quantity' => $item->quantity,
                    'price'    => $item->price,
                    'order_id' => $new_order->id,
                    'color_version_size_id' => $item->color_version_size_id,
                ]);;
            }
    
            //Trừ số lượng sản phẩm trong kho
            foreach ($cart_items as $item) {
                $color_version_size = $item->colorversionsize;
                $color_version_size->update([
                    'quantity' => $color_version_size->quantity - $item->quantity,
                ]);
    
                //Cập nhật version
                $version = $color_version_size->color_version_image->version;
                $version->update([
                    'quantity'=> $version->with(['colorversionimages.colorvertionsizes'])->get()
                    ->flatMap(function ($version) {
                        return $version->colorversionimages->flatMap(function ($colorVersionImage) {
                            return $colorVersionImage->colorvertionsizes;
                        });
                    })->sum('quantity'),
                ]);
    
                //Cập nhật product
                $product = $version->product;
                $product->update([
                    'quantity' => $product->versions->sum('quantity'),
                ]);
            }
    
            // Xoá thông tin của cart_item
            foreach ($cart_items as $item) {
                $item->delete();
            }
    
            // Cập nhật lại thông tin của cart
            $cart->update([
                'total_item' => 0,
                'total_price' => 0,
            ]);
    
            return redirect()->route('store_front')->with('status', "Tạo đơn hàng thành công");
        } else{
            return redirect()->route('store_front')->with('status', "Giao dịch không thành công hoặc đã bị hủy");
        }
        
    }
}
