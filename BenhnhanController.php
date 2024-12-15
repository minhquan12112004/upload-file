<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Benhnhan;

class BenhnhanController extends Controller
{
    //
    public function index()
    {
        $patients = Benhnhan::all();
        return response()->json($patients);
    }

    // Tạo mới bệnh nhân
    public function store(Request $request)
    {
        $request->validate([
            'tenbn' => 'sometimes|required|string|max:100',
            'ngsinh' => 'sometimes|required|date',
            'gioitinh' => 'sometimes|required|string|max:10',
            'sdt' => 'sometimes|required|integer',
            'diachi' => 'sometimes|required|string|max:100',
            'ghichu' => 'nullable|string|max:200',
        ]);

        $patient = Benhnhan::create($request->all());
        return response()->json($patient, 201);
    }

    // Hiển thị thông tin một bệnh nhân cụ thể
    public function show($id)
    {
        $patient = Benhnhan::findOrFail($id);
        return response()->json($patient);
    }

    // Cập nhật thông tin bệnh nhân
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenbn' => 'required|string|max:100',
            'ngsinh' => 'required|date',
            'gioitinh' => 'required|string|max:10',
            'sdt' => 'required|integer',
            'diachi' => 'required|string|max:100',
            'ghichu' => 'nullable|string|max:200',
        ]);

        $patient = Benhnhan::findOrFail($id);
        $patient->update($request->all());
        return response()->json($patient);
    }

    // Xóa bệnh nhân
    public function destroy($id)
    {
        $patient = Benhnhan::findOrFail($id);
        $patient->delete();
        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
