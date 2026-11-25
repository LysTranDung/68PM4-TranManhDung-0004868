<?php

namespace Database\Seeders;

use App\Models\LopHoc;
use App\Models\SinhVien;
use Illuminate\Database\Seeder;

class SinhVienSeeder extends Seeder
{
    public function run(): void
    {
        $classes = LopHoc::all();
        if ($classes->isEmpty()) return;
        for ($index = 0; $index < 40; $index++) {
            SinhVien::factory()->create(['lop_hoc_id' => $classes[$index % $classes->count()]->id]);
        }
    }
}
