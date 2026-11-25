@extends('layouts.layoutmaster')
@section('title', 'Quản lý sinh viên')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><div><h1>Quản lý sinh viên</h1><p class="text-muted">Danh sách và thông tin sinh viên trong các lớp.</p></div><a class="btn btn-primary" href="{{ route('sinhvien.create') }}">Thêm sinh viên</a></div>
<form method="GET" class="card card-body mb-3"><div class="row g-2 align-items-end">
<div class="col-md-4"><label class="form-label">Từ khóa</label><input class="form-control" name="keyword" value="{{ $filters['keyword'] ?? '' }}" placeholder="Mã, họ tên hoặc email"></div>
<div class="col-md-3"><label class="form-label">Lớp học</label><select class="form-select" name="lop_hoc_id"><option value="">Tất cả lớp</option>@foreach($lopHocs as $lop)<option value="{{ $lop->id }}" @selected(($filters['lop_hoc_id'] ?? '') == $lop->id)>{{ $lop->ma_lop }} — {{ $lop->ten_lop }}</option>@endforeach</select></div>
<div class="col-md-2"><label class="form-label">Trạng thái</label><select name="trang_thai" class="form-select"><option value="">Tất cả</option><option value="1" @selected(($filters['trang_thai'] ?? '') === '1')>Đang học</option><option value="0" @selected(($filters['trang_thai'] ?? '') === '0')>Ngừng học</option></select></div>
<div class="col-md-2"><label class="form-label">Số dòng</label><select class="form-select" name="perPage">@foreach($perPageOptions as $n)<option value="{{ $n }}" @selected($perPage===$n)>{{ $n }}</option>@endforeach</select></div><div class="col-md-1"><button class="btn btn-primary">Lọc</button></div></div></form>
<div class="table-responsive"><table class="table table-striped table-hover align-middle"><thead><tr>
@foreach(['ma_sinh_vien'=>'Mã SV','ho_ten'=>'Họ tên','email'=>'Email','lop_hoc_id'=>'Lớp','trang_thai'=>'Trạng thái'] as $col=>$label)<th><a class="text-decoration-none text-dark" href="{{ request()->fullUrlWithQuery(['sort'=>$col,'direction'=>$sort===$col && $direction==='asc'?'desc':'asc','page'=>null]) }}">{{ $label }} @if($sort===$col){{ $direction==='asc'?'▲':'▼' }}@endif</a></th>@endforeach<th>Thao tác</th></tr></thead><tbody>
@forelse($sinhViens as $sv)<tr><td>{{ $sv->ma_sinh_vien }}</td><td><a href="{{ route('sinhvien.show',$sv) }}">{{ $sv->ho_ten }}</a></td><td>{{ $sv->email ?: '—' }}</td><td>{{ $sv->lopHoc?->ma_lop }} · {{ $sv->lopHoc?->ten_lop }}</td><td>{{ $sv->trang_thai?'Đang học':'Ngừng học' }}</td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="{{ route('sinhvien.edit',$sv) }}">Sửa</a> <form class="d-inline" method="POST" action="{{ route('sinhvien.destroy',$sv) }}" onsubmit="return confirm('Xóa sinh viên này?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Xóa</button></form></td></tr>
@empty<tr><td colspan="6" class="text-center py-4">Chưa có sinh viên phù hợp.</td></tr>@endforelse
</tbody></table></div><div>{{ $sinhViens->links() }}</div>
@endsection
