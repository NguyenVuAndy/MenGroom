<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\GiohangHelper;
use App\Models\Donhang;
use App\Models\Chitietdonhang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ThanhtoanController extends Controller
{
    function store(Request $request)
    {
        $user = $request->user();
        $giohang = $request->giohang;
        $sanphams = $request->sanphams;

        $mergeData = [];
        foreach ($giohang as $item) {
            foreach ($sanphams as $sanpham) {
                if ($item["sanpham_id"] == $sanpham["id"]) {
                    // Merge the cart item with product data
                    $mergedData[] = array_merge($item, ["title" => $sanpham["tensp"], 'gia' => $sanpham['gia']]);
                }
            }
        }

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

    function momo_payment(Request $request)
    {
        [$sanphams, $giohang] = GiohangHelper::getSPGioHang();
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = (string) $sanphams->reduce(fn(?float $carry, $sanpham) => $carry + $sanpham->gia * $giohang[$sanpham->id]['soluong']);
        $orderId = time() . "";
        $redirectUrl = route('thanhtoan.momo.return');
        $ipnUrl = route('home');
        $extraData = base64_encode(json_encode(['user_id' => $request->user()->id]));
        $requestId = time() . "";
        $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
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

        return redirect()->to($jsonResult['payUrl']);
    }


    public function momo_return(Request $request)
    {
        if ($request->query('resultCode') == 0) {
            try {
                $userId = $request->user()->id;
                [$sanphams, $giohangItems] = GiohangHelper::getSPGioHang();

                if ($sanphams->isEmpty()) {
                    return Inertia::render('User/OrderSuccess', [
                        'resultCode' => $request->query('resultCode')
                    ]);
                }

                $tongtien = $sanphams->reduce(fn(?float $carry, $sanpham) => $carry + $sanpham->gia * $giohangItems[$sanpham->id]['soluong']);

                $donhang = Donhang::create([
                    'user_id' => $userId,
                    'ngaydathang' => Carbon::now(),
                    'trangthai' => 'Đang xử lý',
                    'tongtien' => $tongtien,
                    'phuongthucthanhtoan' => 'momo',
                ]);

                foreach ($sanphams as $sanpham) {
                    Chitietdonhang::create([
                        'donhang_id' => $donhang->id,
                        'sanpham_id' => $sanpham->id,
                        'soluong' => $giohangItems[$sanpham->id]['soluong'],
                        'giagoc' => $sanpham->gia
                    ]);
                }

                GiohangHelper::clearCart();

            } catch (\Exception $e) {
                Log::error('Momo Return: Error creating order: ' . $e->getMessage());
            }
        }
        return Inertia::render('User/OrderSuccess', [
            'resultCode' => $request->query('resultCode')
        ]);
    }



}
