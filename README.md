# Hệ thống quản lý lớp học

Ứng dụng Laravel 13 quản lý lớp học, sinh viên, menu và tài khoản; phân quyền `admin` và `giang_vien`.

## Cài đặt nhanh

Yêu cầu PHP 8.3+, Composer và Node.js/npm.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Mở `http://127.0.0.1:8000`. Nếu Windows không có lệnh `cp`, hãy sao chép `.env.example` thành `.env` bằng Explorer.

## Tài khoản mẫu

| Vai trò | Email | Mật khẩu |
| --- | --- | --- |
| Admin | `admin@example.com` | `password` |
| Giảng viên | `teacher@example.com` | `password` |

Đổi mật khẩu mẫu trước khi dùng trên môi trường chia sẻ.

## Quyền truy cập

- Admin: quản lý lớp, sinh viên, menu, tài khoản người dùng và tài khoản của mình.
- Giảng viên: quản lý lớp, sinh viên và cập nhật tài khoản của mình.
- Các trang quản trị yêu cầu đăng nhập. Middleware `auth` kiểm tra đăng nhập; middleware `admin` giới hạn chức năng dành cho quản trị viên.

## API

Lấy bearer token bằng `POST /api/login` với JSON `{ "email": "admin@example.com", "password": "password" }`. Gửi token qua header `Authorization: Bearer <token>`. `POST /api/logout` thu hồi token hiện tại.

| Tài nguyên | Endpoint |
| --- | --- |
| Lớp học | `GET, POST /api/lop-hoc`; `GET, PUT/PATCH, DELETE /api/lop-hoc/{id}` |
| Sinh viên | `GET, POST /api/sinh-vien`; `GET, PUT/PATCH, DELETE /api/sinh-vien/{id}` |

Danh sách hỗ trợ `keyword`, `trang_thai`, `per_page`; sinh viên hỗ trợ thêm `lop_hoc_id`. Danh sách phân trang. Dữ liệu ghi được validate bằng Form Request.

## Giao diện

Các trang dùng chung `resources/views/layouts/layoutmaster.blade.php`; danh sách có lọc, sắp xếp, phân trang và giới hạn số dòng mỗi trang. Menu header/sidebar đọc từ bảng `menus`.
