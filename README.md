# **Hướng Dẫn Cài Đặt & Chạy Dự Án**

Tài liệu này hướng dẫn chi tiết cách cài đặt môi trường và chạy source code trên máy tính cá nhân (Localhost).

## **1\. Cài đặt các phần mềm cần thiết**

Trước khi chạy được code, máy tính của bạn cần cài đặt 3 công cụ sau. Nếu đã có rồi thì bỏ qua bước này.

1. **WAMP** (Để chạy PHP và Database MySQL):
    - Tải tại: [wampserver.com](https://wampserver.com/en/download-wampserver-64bits/)
    - Cài đặt xong, mở **XAMPP Control Panel** và bấm nút **Start** ở 2 dòng: Apache và MySQL.
2. **Composer** (Để tải các thư viện cho PHP):
    - Tải tại: [getcomposer.org](https://getcomposer.org/)
    - Cài đặt như bình thường (Next \> Next).
3. **Node.js** (Để chạy giao diện VueJS/Frontend):
    - Tải tại: [nodejs.org](https://nodejs.org/) (Chọn bản **LTS**).

## **2\. Cài đặt thư viện cho dự án**

Sau khi tải code về máy, bạn cần tải các thư viện phụ thuộc về.

1. Mở thư mục chứa code dự án.
2. Trên thanh địa chỉ thư mục, gõ cmd rồi **Enter** để mở màn hình đen (Terminal).
3. Nhập lệnh sau và nhấn Enter (chờ chạy xong):  
   composer install

4. Tiếp tục nhập lệnh sau và nhấn Enter:  
   npm install

## **3\. Cấu hình Database (Cơ sở dữ liệu)**

### **Bước 3.1: Tạo Database**

1. Mở trình duyệt, vào địa chỉ: [http://localhost/phpmyadmin](https://www.google.com/search?q=http://localhost/phpmyadmin)
2. Bấm vào nút **Mới** (hoặc **New**) ở cột bên trái.
3. Nhập tên database là: mengroom (hoặc tên tùy ý, nhưng phải nhớ tên này).
4. Chọn bảng mã utf8mb4_unicode_ci rồi bấm **Tạo** (Create).

### **Bước 3.2: Kết nối code với Database**

1. Trong thư mục code, tìm file có tên .env.example.
2. Copy file đó và đổi tên bản copy thành .env.
3. Mở file .env bằng Notepad hoặc VS Code.
4. Tìm đoạn cấu hình dưới đây và sửa lại thông tin cho đúng:  
   DB_CONNECTION=mysql  
   DB_HOST=127.0.0.1  
   DB_PORT=3306  
   DB_DATABASE=mengroom  
   DB_USERNAME=root  
   DB_PASSWORD=

    _(Lưu ý: DB_DATABASE là tên database bạn vừa tạo, DB_USERNAME mặc định là root, DB_PASSWORD mặc định để trống)._

5. Lưu file lại.

### **Bước 3.3: Nạp dữ liệu mẫu**

Quay lại màn hình đen (Terminal), chạy lần lượt 3 lệnh sau:

1. Tạo khóa bảo mật:  
   php artisan key:generate

2. Thêm dữ liệu mẫu (Sản phẩm, User ảo...):  
   php artisan db:seed MenGroomSeeder

## **4\. Chạy dự án**

Đây là bước bạn sẽ làm mỗi ngày khi muốn bật web lên. Bạn cần mở **2 cửa sổ Terminal** chạy song song.

- Cửa sổ 1 (Chạy Backend):  
  Gõ lệnh:  
  php artisan serve

    _Màn hình sẽ hiện thông báo: Server running on \[http://127.0.0.1:8000\]_

- Cửa sổ 2 (Chạy Frontend):  
  Gõ lệnh:  
  npm run dev

    _Màn hình sẽ hiện chữ VITE v.v..._

## **5\. Truy cập Website**

Mở trình duyệt (Chrome/Edge) và vào địa chỉ:  
http://127.0.0.1:8000

## **6\. Các lỗi thường gặp**

- **Lỗi "Vite manifest not found":** Do bạn quên chạy lệnh npm run dev hoặc chưa cài npm install.
- **Lỗi "Access denied for user...":** Kiểm tra lại file .env xem tên database, username, password đã đúng chưa.
- **Lỗi "Table not found":** Chạy lại lệnh php artisan migrate.
- **Màn hình trắng trơn:** Kiểm tra xem đã Start XAMPP (Module Apache & MySQL) chưa.

## **7\. Thông tin đăng nhập mẫu**

| Loại tài khoản | Email                  | Mật khẩu |
| :------------- | :--------------------- | :------- |
| **Admin**      | admin@mengroom.com     | 123456   |
| **User**       | khachhang@mengroom.com | 123456   |
