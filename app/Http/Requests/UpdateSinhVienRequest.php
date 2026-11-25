<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateSinhVienRequest extends StoreSinhVienRequest
{
    public function rules(): array
    {
        $sinhVien = $this->route('sinhvien') ?? $this->route('sinh_vien');
        $id = is_object($sinhVien) ? $sinhVien->id : $sinhVien;

        return array_replace(parent::rules(), [
            'ma_sinh_vien' => ['required', 'string', 'max:30', Rule::unique('sinh_viens', 'ma_sinh_vien')->ignore($id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('sinh_viens', 'email')->ignore($id)],
        ]);
    }
}
