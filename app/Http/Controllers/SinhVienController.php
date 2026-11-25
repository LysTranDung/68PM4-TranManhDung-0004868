<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSinhVienRequest;
use App\Http\Requests\UpdateSinhVienRequest;
use App\Models\LopHoc;
use App\Models\SinhVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SinhVienController extends Controller
{
    private const SORTABLE = ['ma_sinh_vien', 'ho_ten', 'email', 'lop_hoc_id', 'trang_thai', 'created_at'];
    private const PER_PAGE = [10, 20, 50, 100];

    public function index(Request $request)
    {
        $filters = Validator::make($request->query(), [
            'keyword' => 'nullable|string|max:100', 'lop_hoc_id' => 'nullable|integer|exists:lop_hocs,id',
            'trang_thai' => 'nullable|in:0,1', 'sort' => 'nullable|in:'.implode(',', self::SORTABLE),
            'direction' => 'nullable|in:asc,desc', 'perPage' => 'nullable|in:'.implode(',', self::PER_PAGE),
        ])->valid();
        $sort = $filters['sort'] ?? 'ho_ten';
        $direction = $filters['direction'] ?? 'asc';
        $perPage = (int) ($filters['perPage'] ?? 10);
        $sinhViens = SinhVien::with('lopHoc')
            ->when(isset($filters['keyword']), function ($query) use ($filters) {
                $term = '%'.$filters['keyword'].'%';
                $query->where(fn ($q) => $q->where('ma_sinh_vien', 'like', $term)->orWhere('ho_ten', 'like', $term)->orWhere('email', 'like', $term));
            })
            ->when(isset($filters['lop_hoc_id']), fn ($q) => $q->where('lop_hoc_id', $filters['lop_hoc_id']))
            ->when(isset($filters['trang_thai']), fn ($q) => $q->where('trang_thai', $filters['trang_thai']))
            ->orderBy($sort, $direction)->paginate($perPage)->withQueryString();

        return view('sinhvien.index', compact('sinhViens', 'filters', 'sort', 'direction', 'perPage'))
            ->with(['sortable' => self::SORTABLE, 'perPageOptions' => self::PER_PAGE, 'lopHocs' => LopHoc::orderBy('ten_lop')->get()]);
    }

    public function create()
    {
        return view('sinhvien.create', ['lopHocs' => LopHoc::orderBy('ten_lop')->get()]);
    }

    public function store(StoreSinhVienRequest $request)
    {
        SinhVien::create($request->validated());
        return redirect()->route('sinhvien.index')->with('success', 'Sinh viên đã được thêm.');
    }

    public function show(SinhVien $sinhvien)
    {
        return view('sinhvien.show', ['sinhVien' => $sinhvien->load('lopHoc')]);
    }

    public function edit(SinhVien $sinhvien)
    {
        return view('sinhvien.edit', ['sinhVien' => $sinhvien, 'lopHocs' => LopHoc::orderBy('ten_lop')->get()]);
    }

    public function update(UpdateSinhVienRequest $request, SinhVien $sinhvien)
    {
        $sinhvien->update($request->validated());
        return redirect()->route('sinhvien.index')->with('success', 'Thông tin sinh viên đã được cập nhật.');
    }

    public function destroy(SinhVien $sinhvien)
    {
        $sinhvien->delete();
        return back()->with('success', 'Sinh viên đã được xóa.');
    }
}
