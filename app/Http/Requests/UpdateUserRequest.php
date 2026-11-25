<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $user = $this->route('user') ?? $this->user();
        $id = is_object($user) ? $user->id : $user;
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'role' => ['sometimes', 'required', Rule::in(['admin', 'giang_vien'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
