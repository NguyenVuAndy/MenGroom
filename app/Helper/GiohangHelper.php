<?php
namespace App\Helper;

use App\Models\Giohang;
use App\Models\Sanpham;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class GiohangHelper
{
    public static function getCount()
    {
        if ($user = auth()->user()) {
            return Giohang::whereUserId($user->id)->count();
        } else {
            return array_reduce(self::getCookieGioHang(), fn($carry) => $carry + 1, 0);
        }
    }

    public static function getGioHang()
    {
        if ($user = auth()->user()) {
            return Giohang::whereUserId($user->id)->get()->map(fn(Giohang $item) => ['sanpham_id' => $item->sanpham_id, 'soluong' => $item->soluong]);
        } else {
            return self::getCookieGioHang();
        }
    }

    public static function getCookieGioHang()
    {
        return json_decode(request()->cookie('giohang', '[]'), true);
    }

    public static function setCookieGioHang(array $gioHang)
    {
        Cookie::queue('giohang', json_encode($gioHang), 60 * 24 * 30);
    }

    public static function saveCookieGioHang()
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $userGioHang = Giohang::where(['user_id' => $user->id])->get()->keyBy('sanpham_id');
        $savedGioHang = [];
        foreach (self::getCookieGioHang() as $item) {
            if (isset($userGioHang[$item['sanpham_id']])) {
                $userGioHang[$item['sanpham_id']]->update(['soluong'], $item['soluong']);
                continue;
            } else {
                $savedGioHang[] = [
                    'user_id' => $user->id,
                    'sanpham_id' => $item['sanpham_id'],
                    'soluong' => $item['soluong'],
                ];
            }
        }

        if (!empty($savedGioHang)) {
            Giohang::insert($savedGioHang);
        }
    }

    public static function moveGioHangVaoDB()
    {
        $request = request();
        $gioHang = self::getCookieGioHang();
        $newGioHang = [];
        foreach ($gioHang as $item) {
            $tonTai = Giohang::where(['user_id' => $request->user()->id, 'sanpham_id' => $item['sanpham_id']])->first();
            if (!$tonTai) {
                $newGioHang[] = [
                    'user_id' => $request->user()->id,
                    'sanpham_id' => $item['sanpham_id'],
                    'soluong' => $item['soluong'],
                ];
            }
        }

        if (!empty($newGioHang)) {
            Giohang::insert($newGioHang);
        }
    }

    public static function getSPGioHang()
    {

        $gioHang = self::getGioHang();

        $ids = Arr::pluck($gioHang, 'sanpham_id');

        $sanphams = Sanpham::whereIn('id', $ids)->get();

        $gioHang = Arr::keyBy($gioHang, 'sanpham_id');

        return [$sanphams, $gioHang];

    }



    public static function clearCart()
    {

        if ($user = auth()->user()) {

            Giohang::whereUserId($user->id)->delete();

        }

    }

}

