<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ctdt;

class CtdtController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'madt' => 'required|integer',
            'mathuoc' => 'required|integer',
            'soluong' => 'required|integer',
        ]);

        $ctdt = Ctdt::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $ctdt,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'soluong' => 'required|integer',
        ]);

        $ctdt = Ctdt::find($id);

        if (!$ctdt) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chi tiết đơn thuốc không tồn tại.',
            ], 404);
        }

        $ctdt->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $ctdt,
        ]);
    }

    // Xóa ctdt
    public function destroy($id)
    {
        $validator = Validator::make($request->all(), [
            'madt' => 'required|integer',
            'mathuoc' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
    
        $madt = $request->input('madt');
        $mathuoc = $request->input('mathuoc');
    
        $deleted = Ctdt::where('madt', $madt)
            ->where('mathuoc', $mathuoc)
            ->delete();
    
        if ($deleted) {
            return response()->json([
                'message' => 'Bản ghi đã được xóa thành công!',
            ], 200);
        }
    
        return response()->json([
            'message' => 'Không tìm thấy bản ghi để xóa.',
        ], 404);
    }

    // Lấy chi tiết đơn thuốc của maba
    public function getDonThuocDetails($maba)
    {
        $results = DB::table('donthuoc')
            ->join('ctdt', 'donthuoc.madt', '=', 'ctdt.madt')
            ->join('thuoc', 'ctdt.mathuoc', '=', 'thuoc.mathuoc')
            ->where('donthuoc.maba', $maba)
            ->select('donthuoc.madt', 'ctdt.mathuoc', 'thuoc.tenthuoc', 'ctdt.soluong as sl')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $results,
        ]);
    }
}
