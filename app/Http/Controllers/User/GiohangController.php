<?php

namespace App\Http\Controllers\User;

use App\Helper\GiohangHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\GiohangResource;
use App\Models\Diachi;
use App\Models\Giohang;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GiohangController extends Controller
{
    function view(Request $request, Sanpham $sanpham)
    {
        $user = $request->user();
        if ($user) {
            $gioHang = Giohang::where('user_id', $user->id)->get();
            $diaChi = Diachi::where('user_id', $user->id)->where('diachimacdinh', 1)->first();
            if ($gioHang->count() > 0) {
                return Inertia::render(
                    'User/Giohang',
                    [
                        'gioHang' => $gioHang,
                        'diaChi' => $diaChi
                    ]
                );
            }

        } else {
            $gioHang = GiohangHelper::getCookieGioHang();
            if (count($gioHang) > 0) {
                $cartItems = new GiohangResource(GiohangHelper::getSPGioHang());
                return Inertia::render('User/Giohang', ['gioHang' => $gioHang]);
            } else {
                return redirect()->back();
            }
        }
    }

    function store(Request $request, Sanpham $sanpham)
    {
        $soluong = $request->post('soluong', 1);
        $user = $request->user();

        if ($user) {
            $hangTrongGio = Giohang::where(['user_id' => $user->id, 'sanpham_id' => $sanpham->id])->first();
            if ($hangTrongGio) {
                $hangTrongGio->increment('soluong');
            } else {
                Giohang::create([
                    'user_id' => $user->id,
                    'sanpham_id' => $sanpham->id,
                    'soluong' => 1,
                ]);
            }
        } else {
            $gioHang = GiohangHelper::getCookieGioHang();
            $tonTai = false;
            foreach ($gioHang as $item) {
                if ($item['sanpham_id'] == $sanpham->id) {
                    $item['soluong'] += $soluong;
                    $tonTai = true;
                    break;
                }
            }

            if (!$tonTai) {
                $gioHang[] = [
                    'user_id' => null,
                    'sanpham_id' => $sanpham->id,
                    'soluong' => $soluong,
                    'gia' => $sanpham->gia,
                ];
            }

            GiohangHelper::setCookieGioHang($gioHang);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }

    function update(Request $request, Sanpham $sanpham)
    {
        $soLuong = $request->integer('soluong');
        $user = $request->user();
        if ($user) {
            Giohang::where(['user_id' => $user->id, 'sanpham_id' => $sanpham->id])->update(['soluong' => $soLuong]);
        } else {
            $gioHang = GiohangHelper::getCookieGioHang();
            foreach ($gioHang as &$item) {
                if ($item['sanpham_id'] === $sanpham->id) {
                    $item['soluong'] = $soLuong;
                    break;
                }
            }
            GiohangHelper::setCookieGioHang($gioHang);
        }

        return redirect()->back();
    }

    function delete(Request $request, Sanpham $sanpham)
    {
        $user = $request->user();
        if ($user) {
            Giohang::query()->where(['user_id' => $user->id, 'sanpham_id' => $sanpham->id])->first()?->delete();
            if (Giohang::count() <= 0) {
                return redirect()->route('home')->with('info', 'Giỏ hàng bạn không có gì cả.');
            } else {
                return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
            }
        } else {
            $gioHang = GiohangHelper::getCookieGioHang();
            foreach ($gioHang as $i => &$item) {
                if ($item['sanpham_id'] === $sanpham->id) {
                    array_splice($gioHang, $i, 1);
                    break;
                }
            }
            GiohangHelper::setCookieGioHang($gioHang);
            if (count($gioHang) <= 0) {
                return redirect()->route('home')->with('info', 'Giỏ hàng bạn không có gì cả.');
            } else {
                return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
            }
        }
    }
}
