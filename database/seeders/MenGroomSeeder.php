<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MenGroomSeeder extends Seeder
{

    public function run(): void
    {
        $userId = DB::table('User')->insertGetId([
            'hoten' => 'Nguyen Van A',
            'sdt' => '0909123456',
            'email' => 'khachhang@mengroom.com',
            'pass_hash' => Hash::make('123456'),
            'vaitro' => 'user',
            'thoigiantao' => Carbon::now(),
        ]);

        $brandNivea = DB::table('Thuonghieu')->insertGetId([
            'tenthunghieu' => 'Nivea Men',
            'logo_url' => 'nivea-men-logo.png',
            'mota_thuonghieu' => 'Thương hiệu chăm sóc da hàng đầu cho nam giới.'
        ]);

        $brandRomano = DB::table('Thuonghieu')->insertGetId([
            'tenthunghieu' => 'Romano',
            'logo_url' => 'romano-logo.png',
            'mota_thuonghieu' => 'Hương nước hoa nam tính, lịch lãm.'
        ]);

        $catFace = DB::table('Loaisp')->insertGetId([
            'tenloai' => 'Chăm sóc da mặt',
            'slug' => 'cham-soc-da-mat',
            'mota_loaisp' => 'Sữa rửa mặt, kem dưỡng ẩm cho nam.'
        ]);

        $catHair = DB::table('Loaisp')->insertGetId([
            'tenloai' => 'Tóc & Tạo kiểu',
            'slug' => 'toc-va-tao-kieu',
            'mota_loaisp' => 'Dầu gội, sáp vuốt tóc, gôm xịt.'
        ]);


        $spSRM = DB::table('Sanpham')->insertGetId([
            'tensp' => 'Sữa Rửa Mặt Nivea Men Deep White Oil Clear',
            'mota_chinh' => 'Sạch sâu, ngừa mụn, sáng da.',
            'hdsu' => 'Làm ướt mặt, tạo bọt và massage nhẹ nhàng.',
            'id_loaisp' => $catFace,
            'id_thuonghieu' => $brandNivea,
            'thoigiantao' => Carbon::now(),
        ]);

        DB::table('Bienthe')->insert([
            ['id_sp' => $spSRM, 'sku' => 'NIV-DEEP-100', 'ten' => 'Tuýp 100g', 'gia' => 89000, 'soluongtonkho' => 50, 'thuoc_tinh_1' => 'Dung tích', 'giatri_1' => '100g', 'thuoc_tinh_2' => null, 'giatri_2' => null],
            ['id_sp' => $spSRM, 'sku' => 'NIV-DEEP-50', 'ten' => 'Tuýp 50g', 'gia' => 45000, 'soluongtonkho' => 100, 'thuoc_tinh_1' => 'Dung tích', 'giatri_1' => '50g', 'thuoc_tinh_2' => null, 'giatri_2' => null],
        ]);

        $spWax = DB::table('Sanpham')->insertGetId([
            'tensp' => 'Sáp Vuốt Tóc Romano Matte Clay',
            'mota_chinh' => 'Giữ nếp lâu, không bóng, phù hợp tóc ngắn.',
            'id_loaisp' => $catHair,
            'id_thuonghieu' => $brandRomano,
            'thoigiantao' => Carbon::now(),
        ]);

        DB::table('Bienthe')->insert([
            ['id_sp' => $spWax, 'ten' => 'Hộp 60g', 'gia' => 120000, 'soluongtonkho' => 20, 'thuoc_tinh_1' => 'Trọng lượng', 'giatri_1' => '60g', 'thuoc_tinh_2' => null, 'giatri_2' => null],
        ]);

        $addrId = DB::table('Diachi')->insertGetId([
            'user_id' => $userId,
            'tennguoinhan' => 'Nguyen Van A',
            'sodienthoai' => '0909123456',
            'diachichitiet' => '123 Đường ABC',
            'phuong_xa' => 'Phường 1',
            'quan_huyen' => 'Quận 1',
            'tinh_thanhpho' => 'TP. Hồ Chí Minh',
            'diachimacdinh' => 1
        ]);

        $orderId = DB::table('Donhang')->insertGetId([
            'user_id' => $userId,
            'ngaydathang' => Carbon::now()->subDays(2), // Đặt cách đây 2 ngày
            'trangthai' => 'Đã hoàn thành',
            'tongtien' => 178000, // 2 tuýp 100g (89k x 2)
            'diachi_id' => $addrId,
            'phuongthucthanhtoan' => 'COD',
            'ghichu' => 'Giao giờ hành chính'
        ]);


        $bientheId = DB::table('Bienthe')->where('id_sp', $spSRM)->where('ten', 'Tuýp 100g')->value('id');

        DB::table('Chitietdonhang')->insert([
            'donhang_id' => $orderId,
            'bienthe_id' => $bientheId,
            'soluong' => 2,
            'giagoc' => 89000
        ]);

        DB::table('Danhgia')->insert([
            'user_id' => $userId,
            'sanpham_id' => $spSRM,
            'danhgia' => 5,
            'binhluan' => 'Sản phẩm dùng rất thích, sạch nhờn mà không khô da.',
            'thoigiandanhgia' => Carbon::now()
        ]);

        echo "Đã tạo dữ liệu mẫu thành công cho Mengroom!";
    }
}
