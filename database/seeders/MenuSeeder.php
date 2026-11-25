<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['ten' => 'Lớp học', 'url' => '/lophoc', 'vi_tri' => 'sidebar', 'nhom' => 'Quản lý'],
            ['ten' => 'Sinh viên', 'url' => '/sinhvien', 'vi_tri' => 'sidebar', 'nhom' => 'Quản lý'],
            ['ten' => 'Tài khoản của tôi', 'url' => '/tai-khoan', 'vi_tri' => 'sidebar', 'nhom' => 'Tài khoản'],
            ['ten' => 'Quản lý người dùng', 'url' => '/users', 'vi_tri' => 'sidebar', 'nhom' => 'Quản trị'],
            ['ten' => 'Quản lý menu', 'url' => '/menu', 'vi_tri' => 'sidebar', 'nhom' => 'Quản trị'],
        ];
        foreach ($menus as $thuTu => $menu) {
            Menu::updateOrCreate(['url' => $menu['url'], 'vi_tri' => $menu['vi_tri']], $menu + ['thu_tu' => $thuTu + 1, 'trang_thai' => true]);
        }
    }
}
