<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $user = User::where('email', $credentials['email'])->first();
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return $this->error(null, 'Email hoặc mật khẩu không chính xác.', 401);
        }
        $token = $user->createToken('class-management-api')->plainTextToken;
        return $this->success(['token' => $token, 'user' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role]], 'Đăng nhập thành công.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return $this->success(null, 'Đăng xuất API thành công.');
    }
}
