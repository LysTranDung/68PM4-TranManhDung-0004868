<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ma_sinh_vien')->unique();
            $table->string('ho_ten');
            $table->string('email')->nullable()->unique();
            $table->string('so_dien_thoai', 20)->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->string('gioi_tinh', 20)->nullable();
            $table->foreignId('lop_hoc_id')->constrained('lop_hocs')->cascadeOnUpdate()->restrictOnDelete();
            $table->text('dia_chi')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sinh_viens');
    }
};
