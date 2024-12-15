<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bacsi;

class BacsiController extends Controller
{
    //
    public function index()
    {
        $doctors = Bacsi::all();
        return response()->json($doctors);
    }

    // Tạo mới bác sĩ
    public function store(Request $request)
    {
        $request->validate([
            'tenbs' => 'required|string|max:100',
            'ngsinh' => 'required|date',
            'gioitinh' => 'required|string|max:10',
            'diachi' => 'required|string|max:100',
            'sdt' => 'required|integer',
            'email' => 'required|string|email|max:100|unique:bacsi',
            'hocvi' => 'required|string|max:50',
            'chucvu' => 'required|string|max:50',
            'makhoa' => 'required|integer'
        ]);

        $doctor = Bacsi::create($request->all());
        return response()->json($doctor, 201);
    }

    // Hiển thị thông tin một bác sĩ cụ thể
    public function show($id)
    {
        $doctor = Bacsi::findOrFail($id);
        return response()->json($doctor);
    }

    // Cập nhật thông tin bác sĩ
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenbs' => 'sometimes|required|string|max:100',
            'ngsinh' => 'sometimes|required|date',
            'gioitinh' => 'sometimes|required|string|max:10',
            'diachi' => 'sometimes|required|string|max:100',
            'sdt' => 'sometimes|required|integer',
            'email' => 'sometimes|required|string|email|max:100|unique:bacsi,email,' . $id,
            'hocvi' => 'sometimes|required|string|max:50',
            'chucvu' => 'sometimes|required|string|max:50',
            'makhoa' => 'sometimes|required|integer'
        ]);

        $doctor = Bacsi::findOrFail($id);
        $doctor->update($request->all());
        return response()->json($doctor);
    }

    // Xóa bác sĩ
    public function destroy($id)
    {
        $doctor = Bacsi::findOrFail($id);
        $doctor->delete();
        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
