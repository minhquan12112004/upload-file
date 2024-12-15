<?php

namespace App\Http\Controllers;

use App\Models\Ctnhapvien;
use Illuminate\Http\Request;

class CtnhapvienController extends Controller
{
    // Thêm bản ghi mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'maba' => 'required|integer|exists:hsba,maba',
            'mapb' => 'required|integer|exists:phongbenh,mapb',
            'ngnv' => 'required|date',
            'ngxv' => 'nullable|date',
        ]);

        $ctnhapvien = Ctnhapvien::create($validated);

        return response()->json([
            'message' => 'Thêm thành công.',
            'data' => $ctnhapvien,
        ]);
    }

    // Xóa bản ghi
    public function destroy($maba, $mapb)
    {
        $ctnhapvien = Ctnhapvien::where('maba', $maba)->where('mapb', $mapb)->first();

        if (!$ctnhapvien) {
            return response()->json([
                'message' => 'Không tìm thấy bản ghi.',
            ], 404);
        }

        $ctnhapvien->delete();

        return response()->json([
            'message' => 'Xóa thành công.',
        ]);
    }

    // Sửa bản ghi
    public function update(Request $request, $maba, $mapb)
    {
        $validated = $request->validate([
            'ngnv' => 'required|date',
            'ngxv' => 'nullable|date',
        ]);

        $ctnhapvien = Ctnhapvien::where('maba', $maba)->where('mapb', $mapb)->first();

        if (!$ctnhapvien) {
            return response()->json([
                'message' => 'Không tìm thấy bản ghi.',
            ], 404);
        }

        $ctnhapvien->update($validated);

        return response()->json([
            'message' => 'Cập nhật thành công.',
            'data' => $ctnhapvien,
        ]);
    }

    // Hiển thị chi tiết
    public function showDetails($maba)
    {
        $details = Ctnhapvien::with(['hsba', 'phongBenh'])
            ->where('maba', $maba)
            ->get();

        if ($details->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy dữ liệu.',
            ], 404);
        }

        return response()->json([
            'data' => $details,
        ]);
    }
}
