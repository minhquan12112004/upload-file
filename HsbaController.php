<?php

namespace App\Http\Controllers;

use App\Models\Hsba;
use App\Http\Requests\StorehsbaRequest;
use App\Http\Requests\UpdatehsbaRequest;

class HsbaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Hiển thị danh sách hồ sơ bệnh án
    public function index()
    {
        $records = Hsba::with('patient')->get();
        return response()->json($records);
    }

    // Tạo mới hồ sơ bệnh án cho một bệnh nhân xác định
    public function store(Request $request)
    {
        $request->validate([
            'mabn' => 'required|exists:benhnhan,mabn', // Xác nhận mã bệnh nhân tồn tại
            'mabl' => 'required|integer',
            'nhapvien' => 'required|boolean',
            'ghichu' => 'nullable|string|max:200',
        ]);

        // Tìm bệnh nhân theo mã bệnh nhân
        $patient = Benhnhan::findOrFail($request->mabn);

        // Tạo hồ sơ bệnh án mới
        $record = Hsba::create([
            'mabn' => $patient->mabn,
            'nhapvien' => $request->nhapvien,
            'ghichu' => $request->ghichu
        ]);

        return response()->json($record, 201);
    }

    // Hiển thị thông tin chi tiết của một hồ sơ bệnh án cụ thể
    public function show($mabn, $maba)
    {
        $record = Hsba::where('mabn', $mabn)->where('maba', $maba)->with('patient')->firstOrFail();
        return response()->json($record);
    }

    // Cập nhật thông tin hồ sơ bệnh án
    public function update(Request $request, $mabn, $maba)
    {
        $request->validate([
            'nhapvien' => 'sometimes|required|boolean',
            'ghichu' => 'nullable|string|max:200',
        ]);

        // Tìm hồ sơ bệnh án với mã bệnh nhân và mã hồ sơ bệnh án
        $record = Hsba::where('mabn', $mabn)->where('maba', $maba)->firstOrFail();
        $record->update($request->all());

        return response()->json($record);
    }

    // Xóa hồ sơ bệnh án
    public function destroy($mabn, $maba)
    {
        // Tìm hồ sơ bệnh án với mã bệnh nhân và mã hồ sơ bệnh án
        $record = Hsba::where('mabn', $mabn)->where('maba', $maba)->firstOrFail();
        $record->delete();

        return response()->json(['message' => 'Medical record deleted successfully']);
    }
}
