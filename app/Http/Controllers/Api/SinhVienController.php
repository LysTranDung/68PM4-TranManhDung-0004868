<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSinhVienRequest;
use App\Http\Requests\UpdateSinhVienRequest;
use App\Http\Resources\SinhVienResource;
use App\Models\SinhVien;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SinhVienController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = SinhVien::with('lopHoc');
        if ($request->filled('keyword')) {
            $term = '%'.$request->string('keyword').'%';
            $query->where(fn ($q) => $q->where('ma_sinh_vien', 'like', $term)->orWhere('ho_ten', 'like', $term)->orWhere('email', 'like', $term));
        }
        if ($request->filled('lop_hoc_id')) $query->where('lop_hoc_id', $request->integer('lop_hoc_id'));
        if ($request->has('trang_thai') && in_array($request->input('trang_thai'), ['0', '1'], true)) $query->where('trang_thai', $request->input('trang_thai'));
        $data = $query->orderBy('id')->paginate(min(max($request->integer('per_page', 15), 1), 100));
        return $this->success(SinhVienResource::collection($data)->response()->getData(true));
    }

    public function store(StoreSinhVienRequest $request)
    {
        return $this->success(new SinhVienResource(SinhVien::create($request->validated())->load('lopHoc')), 'Tạo sinh viên thành công.', 201);
    }

    public function show(SinhVien $sinhvien)
    {
        return $this->success(new SinhVienResource($sinhvien->load('lopHoc')));
    }

    public function update(UpdateSinhVienRequest $request, SinhVien $sinhvien)
    {
        $sinhvien->update($request->validated());
        return $this->success(new SinhVienResource($sinhvien->refresh()->load('lopHoc')), 'Cập nhật sinh viên thành công.');
    }

    public function destroy(SinhVien $sinhvien)
    {
        $sinhvien->delete();
        return $this->success(null, 'Xóa sinh viên thành công.');
    }
}
