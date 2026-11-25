<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filters = Validator::make($request->query(), ['keyword' => 'nullable|string|max:100', 'role' => 'nullable|in:admin,giang_vien', 'sort' => 'nullable|in:name,email,role,created_at', 'direction' => 'nullable|in:asc,desc'])->valid();
        $users = User::query()->when(isset($filters['keyword']), fn ($q) => $q->where(fn ($x) => $x->where('name', 'like', '%'.$filters['keyword'].'%')->orWhere('email', 'like', '%'.$filters['keyword'].'%')))
            ->when(isset($filters['role']), fn ($q) => $q->where('role', $filters['role']))
            ->orderBy($filters['sort'] ?? 'name', $filters['direction'] ?? 'asc')->paginate(10)->withQueryString();
        return view('users.index', compact('users', 'filters'));
    }

    public function create() { return view('users.create'); }
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated(); unset($data['password_confirmation']);
        User::create($data);
        return redirect()->route('users.index')->with('success', 'Tài khoản đã được tạo.');
    }
    public function edit(User $user) { return view('users.edit', compact('user')); }
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (blank($data['password'] ?? null)) unset($data['password']);
        unset($data['password_confirmation']);
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Tài khoản đã được cập nhật.');
    }
    public function destroy(User $user)
    {
        abort_if($user->is($requestUser = request()->user()), 422, 'Không thể xóa tài khoản đang đăng nhập.');
        $user->delete();
        return back()->with('success', 'Tài khoản đã được xóa.');
    }

    public function profile() { return view('users.profile', ['user' => request()->user()]); }
    public function updateProfile(UpdateUserRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        unset($data['role']);
        if (blank($data['password'] ?? null)) unset($data['password']);
        unset($data['password_confirmation']);
        $user->update($data);
        return back()->with('success', 'Thông tin tài khoản đã được cập nhật.');
    }
}
