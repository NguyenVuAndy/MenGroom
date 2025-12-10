<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
    public function run()
    {

        $user = User::create([
            'hoten' => 'Nguyen Van A',
            'sdt' => '0909123456',
            'email' => 'khachhang@mengroom.com',
            'pass_hash' => Hash::make('123456'),
            'vaitro' => 'user',
        ]);

        User::create([
            'hoten' => 'Admin Manager',
            'sdt' => '0909999999',
            'email' => 'admin@mengroom.com',
            'pass_hash' => Hash::make('123456'),
            'vaitro' => 'admin',
        ]);

        $brandNivea = Thuonghieu::create(['tenthuonghieu' => 'Nivea Men', 'logo_url' => 'brands/nivea-men.png', 'mota_thuonghieu' => 'Chuyên gia chăm sóc da nam giới.']);
        $brandRomano = Thuonghieu::create(['tenthuonghieu' => 'Romano', 'logo_url' => 'brands/romano.png', 'mota_thuonghieu' => 'Hương nước hoa Ý lịch lãm.']);
        $brandXmen = Thuonghieu::create(['tenthuonghieu' => 'X-Men', 'logo_url' => 'brands/xmen.png', 'mota_thuonghieu' => 'Đàn ông đích thực.']);
        $brandGillette = Thuonghieu::create(['tenthuonghieu' => 'Gillette', 'logo_url' => 'brands/gillette.png', 'mota_thuonghieu' => 'Tốt nhất dành cho đàn ông.']);
        $brandOldSpice = Thuonghieu::create(['tenthuonghieu' => 'Old Spice', 'logo_url' => 'brands/oldspice.png', 'mota_thuonghieu' => 'Mùi hương huyền thoại từ Mỹ.']);

        $catFace = Loaisp::create(['tenloai' => 'Chăm sóc da mặt', 'mota_loaisp' => 'Sữa rửa mặt, kem dưỡng, trị mụn.']);
        $catHair = Loaisp::create(['tenloai' => 'Tóc & Tạo kiểu', 'mota_loaisp' => 'Dầu gội, sáp vuốt, gôm xịt.']);
        $catBody = Loaisp::create(['tenloai' => 'Chăm sóc cơ thể', 'mota_loaisp' => 'Sữa tắm, khử mùi, lăn nách.']);
        $catShave = Loaisp::create(['tenloai' => 'Cạo râu', 'mota_loaisp' => 'Dao cạo, bọt cạo râu, after-shave.']);
        $catPerfume = Loaisp::create(['tenloai' => 'Nước hoa Nam', 'mota_loaisp' => 'Nước hoa cao cấp, body mist.']);


        $spSRM = Sanpham::create([
            'tensp' => 'Sữa Rửa Mặt Nivea Men Deep White Oil Clear 100g',
            'sku' => 'NIV-DEEP-100',
            'gia' => 89000,
            'giakhuyenmai' => 79000, // Có giảm giá
            'soluongtonkho' => 50,
            'chitietsp' => 'Công thức chứa than đen hoạt tính giúp hút sạch bã nhờn sâu trong lỗ chân lông.',
            'hdsd' => 'Làm ướt mặt, tạo bọt và massage nhẹ nhàng.',
            'thanhphansp' => 'Than hoạt tính, Vitamin C, Aqua...',
            'id_loaisp' => $catFace->id,
            'id_thuonghieu' => $brandNivea->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Sữa Rửa Mặt Nivea Men Extra White 100g',
            'sku' => 'NIV-EXTRA-100',
            'gia' => 85000,
            'soluongtonkho' => 60,
            'chitietsp' => 'Giúp da sáng khỏe, mờ vết thâm mụn.',
            'hdsd' => 'Dùng 2 lần sáng và tối.',
            'thanhphansp' => 'Vitamin B3, Hạt mát-xa siêu nhỏ.',
            'id_loaisp' => $catFace->id,
            'id_thuonghieu' => $brandNivea->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Sữa Rửa Mặt Oxy Deep Wash 100g',
            'sku' => 'XMEN-OXY-100',
            'gia' => 72000,
            'soluongtonkho' => 100,
            'chitietsp' => 'Đánh bay nhờn, tút lại vẻ đẹp trai.',
            'hdsd' => 'Rửa sạch mặt với nước.',
            'thanhphansp' => 'Hạt than siêu nhỏ, tinh chất trà xanh.',
            'id_loaisp' => $catFace->id,
            'id_thuonghieu' => $brandXmen->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Sáp Vuốt Tóc Romano Matte Clay 60g',
            'sku' => 'ROMA-CLAY-60',
            'gia' => 120000,
            'giakhuyenmai' => 0,
            'soluongtonkho' => 20,
            'chitietsp' => 'Giữ nếp lâu, hoàn thiện mờ tự nhiên (Matte finish), phù hợp tóc ngắn và trung bình.',
            'hdsd' => 'Lấy một lượng nhỏ xoa đều ra tay rồi vuốt lên tóc khô.',
            'thanhphansp' => 'Kaolin Clay, Beeswax.',
            'id_loaisp' => $catHair->id,
            'id_thuonghieu' => $brandRomano->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Dầu Gội X-Men For Boss Intense 650g',
            'sku' => 'XMEN-BOSS-650',
            'gia' => 180000,
            'giakhuyenmai' => 159000,
            'soluongtonkho' => 45,
            'chitietsp' => 'Hương nước hoa trầm đầy nội lực, dành cho người đàn ông thành đạt.',
            'hdsd' => 'Thoa đều lên tóc ướt, xả sạch với nước.',
            'thanhphansp' => 'Tinh dầu nước hoa nhập khẩu.',
            'id_loaisp' => $catHair->id,
            'id_thuonghieu' => $brandXmen->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Dầu Gội Head & Shoulders Ultra Men 600ml', // Tạm gán vào Old Spice nếu chưa có brand H&S
            'sku' => 'OS-HS-600',
            'gia' => 165000,
            'soluongtonkho' => 80,
            'chitietsp' => 'Sạch gàu, mát lạnh sảng khoái bạc hà.',
            'hdsd' => 'Mát xa nhẹ nhàng da đầu.',
            'thanhphansp' => 'Tinh chất bạc hà, Zinc Pyrithione.',
            'id_loaisp' => $catHair->id,
            'id_thuonghieu' => $brandOldSpice->id, // Tạm
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Sữa Tắm Old Spice Timber 500ml',
            'sku' => 'OS-TIMBER-500',
            'gia' => 190000,
            'soluongtonkho' => 30,
            'chitietsp' => 'Hương gỗ đàn hương và bạc hà, mang lại cảm giác như đang ở trong rừng rậm.',
            'hdsd' => 'Cho sữa tắm vào bông tắm hoặc lòng bàn tay.',
            'thanhphansp' => 'Gỗ đàn hương, Bạc hà.',
            'id_loaisp' => $catBody->id,
            'id_thuonghieu' => $brandOldSpice->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Lăn Khử Mùi Nivea Men Black & White',
            'sku' => 'NIV-ROLL-BW',
            'gia' => 65000,
            'soluongtonkho' => 200,
            'chitietsp' => 'Không gây ố vàng áo trắng, không để lại vệt trắng trên áo đen.',
            'hdsd' => 'Lăn lên vùng da dưới cánh tay mỗi ngày.',
            'thanhphansp' => 'Aluminum Chlorohydrate.',
            'id_loaisp' => $catBody->id,
            'id_thuonghieu' => $brandNivea->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Xịt Khử Mùi Romano Classic 150ml',
            'sku' => 'ROMA-SPRAY-150',
            'gia' => 95000,
            'giakhuyenmai' => 89000,
            'soluongtonkho' => 100,
            'chitietsp' => 'Ngăn mùi hiệu quả 24h, hương thơm cổ điển.',
            'hdsd' => 'Xịt cách da 15cm.',
            'thanhphansp' => 'Alcohol, Perfume.',
            'id_loaisp' => $catBody->id,
            'id_thuonghieu' => $brandRomano->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Bọt Cạo Râu Gillette Lemon Lime 300g',
            'sku' => 'GIL-FOAM-300',
            'gia' => 110000,
            'soluongtonkho' => 40,
            'chitietsp' => 'Lớp bọt dày mịn giúp dao cạo lướt êm, hương chanh tươi mát.',
            'hdsd' => 'Lắc đều, xịt ra tay và thoa lên vùng râu cần cạo.',
            'thanhphansp' => 'Hương chanh, Glycerin.',
            'id_loaisp' => $catShave->id,
            'id_thuonghieu' => $brandGillette->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Dao Cạo Râu Gillette Mach 3 Turbo',
            'sku' => 'GIL-MACH3',
            'gia' => 150000,
            'giakhuyenmai' => 135000,
            'soluongtonkho' => 150,
            'chitietsp' => '3 lưỡi dao tiên tiến, cạo sạch hơn, ít kích ứng hơn.',
            'hdsd' => 'Rửa sạch dao sau khi sử dụng.',
            'thanhphansp' => 'Thép không gỉ.',
            'id_loaisp' => $catShave->id,
            'id_thuonghieu' => $brandGillette->id,
            'trangthaihienthi' => 1,
        ]);

        Sanpham::create([
            'tensp' => 'Nước Hoa Romano Classic 100ml',
            'sku' => 'ROMA-PERF-100',
            'gia' => 350000,
            'soluongtonkho' => 10,
            'chitietsp' => 'Biểu tượng của người đàn ông thành đạt và lịch lãm.',
            'hdsd' => 'Xịt lên cổ tay, sau gáy.',
            'thanhphansp' => 'Hương gỗ, Hoắc hương.',
            'id_loaisp' => $catPerfume->id,
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
            'tongtien' => 178000, // 2 * 89000
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
    }
}