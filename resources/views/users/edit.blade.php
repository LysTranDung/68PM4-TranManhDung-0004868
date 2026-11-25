@extends('layouts.layoutmaster')
@section('title','Chỉnh sửa tài khoản')
@section('content')<h1>Chỉnh sửa tài khoản</h1><form method="POST" action="{{ route('users.update',$user) }}" class="card card-body mt-3" style="max-width:640px">@csrf @method('PUT') @include('users._form')</form>@endsection
