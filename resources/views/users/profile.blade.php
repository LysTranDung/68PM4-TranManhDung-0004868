@extends('layouts.layoutmaster')
@section('title','Tài khoản của tôi')
@section('content')<h1>Tài khoản của tôi</h1><p class="text-muted">Cập nhật thông tin cá nhân hoặc thay đổi mật khẩu.</p><form method="POST" action="{{ route('profile.update') }}" class="card card-body mt-3" style="max-width:640px">@csrf @method('PUT') @include('users._form')</form>@endsection
