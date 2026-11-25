@extends('layouts.layoutmaster')
@section('title','Chỉnh sửa sinh viên')
@section('content')<h1>Chỉnh sửa sinh viên</h1><form method="POST" action="{{ route('sinhvien.update',$sinhVien) }}" class="card card-body mt-3">@csrf @method('PUT') @include('sinhvien._form')</form>@endsection
