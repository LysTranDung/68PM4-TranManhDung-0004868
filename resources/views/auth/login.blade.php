@extends('layouts.layoutmaster')
@section('title','Đăng nhập')
@section('content')
<div class="row justify-content-center"><div class="col-md-6 col-lg-5"><div class="card shadow-sm"><div class="card-body p-4"><h1 class="h3 mb-2">Đăng nhập</h1><p class="text-muted mb-4">Đăng nhập để sử dụng hệ thống quản lý lớp học.</p>
<form method="POST" action="{{ route('login') }}">@csrf
<div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label" for="password">Mật khẩu</label><input class="form-control" id="password" type="password" name="password" required autocomplete="current-password"></div>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember" value="1"><label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label></div><button class="btn btn-primary w-100">Đăng nhập</button></form>
</div></div></div></div>
@endsection
