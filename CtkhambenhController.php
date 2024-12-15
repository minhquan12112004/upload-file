<?php

namespace App\Http\Controllers;

use App\Models\Ctkhambenh;
use Illuminate\Http\Request;

class CtkhambenhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createAndCount(Request $request)
{
    // Validate dữ liệu đầu vào
    $validated = $request->validate([
        'mabn' => 'required|integer|exists:benhnhan,mabn',
        'mapk' => 'required|integer|exists:phongkham,mapk',
    ]);

    // Tạo bản ghi mới
    $ctkhambenh = Ctkhambenh::create([
        'mabn' => $validated['mabn'],
        'mapk' => $validated['mapk'],
    ]);

    // Lấy số lượng theo phòng và ngày khám
    $count = \DB::table('ctkhambenh')
        ->where('mapk', $validated['mapk'])
        ->whereDate('created_at', now()->toDateString()) // Lấy ngày hôm nay
        ->count();

    // Trả về dữ liệu JSON bao gồm bản ghi mới và số lượng
    return response()->json([
        'message' => 'Thêm thành công.',
        'new_record' => $ctkhambenh,
        'count_today' => $count,
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(Ctkhambenh $ctkhambenh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ctkhambenh $ctkhambenh)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $makb)
    {
        $ctkhambenh = Ctkhambenh::find($makb);

        if (!$ctkhambenh) {
            return response()->json(['message' => 'Không tìm thấy bản ghi'], 404);
        }

        $validated = $request->validate([
            'mabn' => 'sometimes|integer|exists:benhnhan,mabn',
            'mapk' => 'sometimes|integer|exists:phongkham,mapk',
        ]);

        $ctkhambenh->update($validated);

        return response()->json([
            'message' => 'Cập nhật thành công!',
            'data' => $ctkhambenh,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($makb)
    {
        $ctkhambenh = Ctkhambenh::find($makb);

        if (!$ctkhambenh) {
            return response()->json(['message' => 'Không tìm thấy bản ghi'], 404);
        }

        $ctkhambenh->delete();

        return response()->json(['message' => 'Xóa thành công!']);
    }

    public function getByMabn($mabn)
    {
        $data = Ctkhambenh::where('mabn', $mabn)
            ->with(['benhnhan', 'phongkham'])
            ->get()
            ->map(function ($item) {
                $item->ngay_kham = $item->created_at;
                return $item;
            });

        return response()->json(['data' => $data]);
    }
}
