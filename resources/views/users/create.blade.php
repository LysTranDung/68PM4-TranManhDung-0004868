@extends('layouts.layoutmaster')
@section('title','Tạo tài khoản')
@section('content')<h1>Tạo tài khoản</h1><form method="POST" action="{{ route('users.store') }}" class="card card-body mt-3" style="max-width:640px">@csrf @include('users._form',['user'=>null])</form>@endsection
