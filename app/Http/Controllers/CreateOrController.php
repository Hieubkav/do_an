<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CreateOrController extends Controller
{
    function makeqr(){
        return view('main.makeqr'); 
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
    function payment_momo_qr(Request $request)
    {
        $request->validate([
            'total_price' => 'required|numeric',
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
        $amount = $request->total_price;
        $orderId = time() . "";
        $redirectUrl = route('makeqr_momo_ipn_handler');
        $ipnUrl = route('makeqr');
        $extraData = "";

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
            return redirect()->route('makeqr')->with('status', "Giao dịch bạn thực hiện thành công");
        } else{
            return redirect()->route('makeqr')->with('status', "Giao dịch không thành công hoặc đã bị hủy");
        }
        
    }
}
