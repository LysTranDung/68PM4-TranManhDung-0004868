<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLopHocRequest;
use App\Http\Requests\UpdateLopHocRequest;
use App\Http\Resources\LopHocResource;
use App\Models\LopHoc;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LopHocController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = LopHoc::query()->withCount('sinhViens');
        if ($request->filled('keyword')) {
            $term = '%'.$request->string('keyword').'%';
            $query->where(fn ($q) => $q->where('ten_lop', 'like', $term)->orWhere('ma_lop', 'like', $term));
        }
        if ($request->has('trang_thai') && in_array($request->input('trang_thai'), ['0', '1'], true)) {
            $query->where('trang_thai', $request->input('trang_thai'));
        }
        return $this->success($query->orderBy('id')->paginate(min(max($request->integer('per_page', 15), 1), 100)));
    }

    public function store(StoreLopHocRequest $request)
    {
        $lopHoc = LopHoc::create($request->validated());
        return $this->success(new LopHocResource($lopHoc), 'Tạo lớp học thành công.', 201);
    }

    public function show(LopHoc $lopHoc)
    {
        return $this->success(new LopHocResource($lopHoc->loadCount('sinhViens')));
    }

    public function update(UpdateLopHocRequest $request, LopHoc $lopHoc)
    {
        $lopHoc->update($request->validated());
        return $this->success(new LopHocResource($lopHoc->refresh()), 'Cập nhật lớp học thành công.');
    }

    public function destroy(LopHoc $lopHoc)
    {
        if ($lopHoc->sinhViens()->exists()) {
            return response()->json(['message' => 'Không thể xóa lớp đang có sinh viên.'], 409);
        }
        $lopHoc->delete();
        return $this->success(null, 'Xóa lớp học thành công.');
    }
}
