<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LopHocSeeder::class,
            SinhVienSeeder::class,
            MenuSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Quản trị viên',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => '12345678',
        ]);
        User::factory()->create([
            'name' => 'Giảng viên',
            'email' => 'giangvien@gmail.com',
            'role' => 'giang_vien',
            'password' => '12345678',
        ]);
    }
}
