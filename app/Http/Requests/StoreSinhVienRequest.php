<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSinhVienRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'ma_sinh_vien' => ['required', 'string', 'max:30', 'unique:sinh_viens,ma_sinh_vien'],
            'ho_ten' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:sinh_viens,email'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'ngay_sinh' => ['nullable', 'date', 'before:today'],
            'gioi_tinh' => ['nullable', Rule::in(['Nam', 'Nữ', 'Khác'])],
            'lop_hoc_id' => ['required', 'integer', 'exists:lop_hocs,id'],
            'dia_chi' => ['nullable', 'string', 'max:1000'],
            'trang_thai' => ['required', 'boolean'],
        ];
    }
}
