@extends('layouts.layoutmaster')
@section('title','Thêm sinh viên')
@section('content')<h1>Thêm sinh viên</h1><form method="POST" action="{{ route('sinhvien.store') }}" class="card card-body mt-3">@csrf @include('sinhvien._form')</form>@endsection
