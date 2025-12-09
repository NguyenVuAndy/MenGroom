<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

// Import các Model (Đã bỏ Bienthe)
use App\Models\User;
use App\Models\Thuonghieu;
use App\Models\Loaisp;
use App\Models\Sanpham;
use App\Models\Diachi;
use App\Models\Donhang;
use App\Models\Chitietdonhang;
use App\Models\Danhgia;

class MenGroomSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'hoten' => 'Nguyen Van A',
            'sdt' => '0909123456',
            'email' => 'khachhang@mengroom.com',
            'pass_hash' => Hash::make('123456'),
            'vaitro' => 'user',
        ]);

        $brandNivea = Thuonghieu::create([
            'tenthuonghieu' => 'Nivea Men',
            'logo_url' => 'nivea-men-logo.png',
            'mota_thuonghieu' => 'Thương hiệu chăm sóc da hàng đầu cho nam giới.'
        ]);

        $brandRomano = Thuonghieu::create([
            'tenthuonghieu' => 'Romano',
            'logo_url' => 'romano-logo.png',
            'mota_thuonghieu' => 'Hương nước hoa nam tính, lịch lãm.'
        ]);

        $catFace = Loaisp::create([
            'tenloai' => 'Chăm sóc da mặt',
            'mota_loaisp' => 'Sữa rửa mặt, kem dưỡng ẩm cho nam.'
        ]);

        $catHair = Loaisp::create([
            'tenloai' => 'Tóc & Tạo kiểu',
            'mota_loaisp' => 'Dầu gội, sáp vuốt tóc, gôm xịt.'
        ]);

        $spSRM = Sanpham::create([
            'tensp' => 'Sữa Rửa Mặt Nivea Men Deep White Oil Clear 100g',
            'sku' => 'NIV-DEEP-100',
            'gia' => 89000,
            'soluongtonkho' => 50,
            'chitietsp' => 'Sạch sâu, ngừa mụn, sáng da.',
            'hdsd' => 'Làm ướt mặt, tạo bọt và massage nhẹ nhàng.',
            'thanhphansp' => 'Chiết xuất than hoạt tính, vitamin C.',
            'id_loaisp' => $catFace->id,
            'id_thuonghieu' => $brandNivea->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Sữa Rửa Mặt Nivea Men Deep White Oil Clear 50g',
            'sku' => 'NIV-DEEP-50',
            'gia' => 45000,
            'soluongtonkho' => 100,
            'chitietsp' => 'Phiên bản nhỏ gọn tiện lợi.',
            'hdsd' => 'Làm ướt mặt, tạo bọt và massage nhẹ nhàng.',
            'thanhphansp' => 'Chiết xuất than hoạt tính, vitamin C.',
            'id_loaisp' => $catFace->id,
            'id_thuonghieu' => $brandNivea->id,
            'trangthaihienthi' => 1,
        ]);

        $spWax = Sanpham::create([
            'tensp' => 'Sáp Vuốt Tóc Romano Matte Clay',
            'sku' => 'ROMA-CLAY-60',
            'gia' => 120000,
            'soluongtonkho' => 20,

            'chitietsp' => 'Giữ nếp lâu, không bóng, phù hợp tóc ngắn.',
            'hdsd' => 'Lấy một lượng nhỏ xoa đều ra tay rồi vuốt lên tóc.',
            'thanhphansp' => 'Đất sét, sáp ong...',
            'id_loaisp' => $catHair->id,
            'id_thuonghieu' => $brandRomano->id,
            'trangthaihienthi' => 1,
        ]);

        $diachi = Diachi::create([
            'user_id' => $user->id,
            'tennguoinhan' => 'Nguyen Van A',
            'sodienthoai' => '0909123456',
            'diachichitiet' => '123 Đường ABC',
            'phuong_xa' => 'Phường 1',
            'quan_huyen' => 'Quận 1',
            'tinh_thanhpho' => 'TP. Hồ Chí Minh',
            'diachimacdinh' => 1
        ]);

        $order = Donhang::create([
            'user_id' => $user->id,
            'ngaydathang' => Carbon::now()->subDays(2),
            'trangthai' => 'Đã hoàn thành',
            'tongtien' => 178000,
            'diachi_id' => $diachi->id,
            'phuongthucthanhtoan' => 'COD',
            'ghichu' => 'Giao giờ hành chính'
        ]);

        Chitietdonhang::create([
            'donhang_id' => $order->id,
            'sanpham_id' => $spSRM->id,
            'soluong' => 2,
            'giagoc' => 89000
        ]);

        Danhgia::create([
            'user_id' => $user->id,
            'sanpham_id' => $spSRM->id,
            'danhgia' => 5,
            'binhluan' => 'Sản phẩm dùng rất thích, sạch nhờn mà không khô da.',
            'thoigiandanhgia' => Carbon::now()
        ]);
    }
}