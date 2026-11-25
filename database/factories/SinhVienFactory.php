<?php

namespace Database\Factories;

use App\Models\LopHoc;
use App\Models\SinhVien;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SinhVien> */
class SinhVienFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ma_sinh_vien' => strtoupper(fake()->unique()->bothify('SV######')),
            'ho_ten' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'so_dien_thoai' => fake()->phoneNumber(),
            'ngay_sinh' => fake()->dateTimeBetween('-27 years', '-18 years')->format('Y-m-d'),
            'gioi_tinh' => fake()->randomElement(['Nam', 'Nữ', 'Khác']),
            'lop_hoc_id' => LopHoc::factory(),
            'dia_chi' => fake()->address(),
            'trang_thai' => true,
        ];
    }
}
